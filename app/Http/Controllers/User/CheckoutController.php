<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty!');
        }
        
        $cartItems = $cart->items()->with('book.category')->get();
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->book->harga * $item->qty;
        }
        
        $ongkir = 15000; // Fixed shipping cost
        $total = $subtotal + $ongkir;
        
        return view('user.checkout.index', compact('cart', 'cartItems', 'subtotal', 'ongkir', 'total'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'alamat_lengkap' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kode_pos' => 'required|string|max:5',
            'ongkir' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'agree_terms' => 'required|accepted',
        ], [
            'agree_terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);
        
        $cart = Cart::where('user_id', auth()->id())->first();
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang belanja Anda kosong!');
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate total
            $subtotal = 0;
            foreach ($cart->items as $item) {
                // Check stock
                if ($item->book->stok < $item->qty) {
                    throw new \Exception("Stok tidak cukup untuk buku: {$item->book->judul}");
                }
                $subtotal += $item->book->harga * $item->qty;
            }
            
            $ongkir = $request->ongkir;
            $total = $subtotal + $ongkir;
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => 'INV-' . time() . '-' . auth()->id(),
                'total_harga' => $total,
                'status' => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran,
                'alamat_lengkap' => $request->alamat_lengkap,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kode_pos' => $request->kode_pos,
                'ongkir' => $ongkir,
                'catatan' => $request->catatan,
            ]);
            
            // Create order items and reduce stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'qty' => $item->qty,
                    'harga_satuan' => $item->book->harga,
                    'subtotal' => $item->book->harga * $item->qty,
                ]);
                
                // Reduce stock
                $item->book->decrement('stok', $item->qty);
            }
            
            // Clear cart
            $cart->items()->delete();
            
            DB::commit();
            
            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['orderItems.book'])
            ->latest()
            ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['orderItems.book.category'])
            ->findOrFail($id);
        
        return view('user.orders.show', compact('order'));
    }
    
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment already processed!');
        }
        
        // Store payment proof
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        
        $order->update([
            'status' => 'paid',
            'payment_proof' => $path,
        ]);
        
        return redirect()->back()->with('success', 'Payment proof uploaded successfully! Waiting for admin verification.');
    }
}
