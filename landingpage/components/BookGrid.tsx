import React from 'react';
import { Plus, Check } from 'lucide-react';
import { BOOKS } from '../constants';
import { Book } from '../types';

const BookCard: React.FC<{ book: Book }> = ({ book }) => {
    return (
        <div className="group cursor-pointer">
            <div 
                className="relative w-full aspect-[2/3] mb-6 book-card rounded-sm overflow-hidden" 
                style={{ backgroundColor: book.imageColor }}
            >
                {/* Artistic Cover Placeholder */}
                <div className="absolute inset-4 border border-gray-900/10 flex flex-col items-center justify-center p-4 text-center">
                    <div className="w-16 h-16 rounded-full border border-gray-900/20 mb-4 flex items-center justify-center">
                        <span className="serif italic text-xl">{book.initial}</span>
                    </div>
                    <span className="text-[10px] uppercase tracking-widest text-gray-400">{book.author}</span>
                </div>
                
                {/* Overlays */}
                <div className="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300 flex items-end justify-between p-4 opacity-0 group-hover:opacity-100">
                    <span className="bg-white text-gray-900 text-[10px] font-bold px-2 py-1 uppercase tracking-wider">Quick View</span>
                    <button className="bg-gray-900 text-white p-2 rounded-full hover:scale-110 transition-transform">
                        <Plus className="w-4 h-4" />
                    </button>
                </div>

                {/* Badges */}
                {book.soldOut && (
                    <div className="absolute top-4 left-0">
                        <span className="bg-gray-900 text-white text-[10px] font-medium px-3 py-1 uppercase tracking-widest">Sold Out</span>
                    </div>
                )}
                {book.discount && (
                    <div className="absolute top-4 left-0">
                        <span className="bg-white text-gray-900 border border-gray-200 text-[10px] font-medium px-3 py-1 uppercase tracking-widest">{book.discount}</span>
                    </div>
                )}
            </div>
            
            <div className="space-y-1">
                <h3 className={`text-lg font-medium serif leading-tight group-hover:underline decoration-1 underline-offset-4 ${book.soldOut ? 'text-gray-400' : 'text-gray-900'}`}>
                    {book.title}
                </h3>
                <p className={`text-xs uppercase tracking-wider ${book.soldOut ? 'text-gray-400' : 'text-gray-500'}`}>{book.category}</p>
                
                <div className="flex items-center gap-2 pt-1">
                    <p className={`text-sm font-medium ${book.soldOut ? 'text-gray-400' : 'text-gray-900'}`}>
                        Rp {book.price.toLocaleString('id-ID')}
                    </p>
                    {book.originalPrice && (
                        <p className="text-xs text-gray-400 line-through">Rp {book.originalPrice.toLocaleString('id-ID')}</p>
                    )}
                </div>
            </div>
        </div>
    );
}

const BookGrid: React.FC = () => {
    return (
        <div className="flex flex-col lg:flex-row gap-16">
            {/* Sidebar */}
            <aside className="w-full lg:w-60 flex-shrink-0 hidden lg:block sticky top-32 h-fit space-y-12">
                <div>
                    <h3 className="serif text-xl text-gray-900 mb-6 italic">Kategori</h3>
                    <ul className="space-y-4">
                        <li>
                            <a href="#" className="group flex items-center justify-between text-sm text-gray-500 hover:text-gray-900 transition-colors">
                                <span className="border-b border-transparent group-hover:border-gray-900 pb-0.5 transition-all">Sastra Kontemporer</span>
                                <span className="text-xs text-gray-300">12</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" className="group flex items-center justify-between text-sm text-gray-900 font-medium transition-colors">
                                <span className="border-b border-gray-900 pb-0.5">Pengembangan Diri</span>
                                <span className="text-xs text-gray-900">24</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" className="group flex items-center justify-between text-sm text-gray-500 hover:text-gray-900 transition-colors">
                                <span className="border-b border-transparent group-hover:border-gray-900 pb-0.5 transition-all">Bisnis & Strategi</span>
                                <span className="text-xs text-gray-300">08</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 className="serif text-xl text-gray-900 mb-6 italic">Filter</h3>
                    <div className="space-y-4">
                        {['Hardcover', 'Paperback', 'Edisi Spesial'].map(label => (
                            <label key={label} className="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" className="custom-checkbox h-4 w-4 appearance-none border border-gray-300 rounded-sm transition-all outline-none focus:ring-0" />
                                <span className="text-sm text-gray-500 group-hover:text-gray-900 transition-colors">{label}</span>
                            </label>
                        ))}
                    </div>
                </div>
            </aside>

            {/* Product Grid */}
            <div className="flex-1">
                {/* Toolbar */}
                <div className="flex justify-between items-center mb-10 border-b border-gray-100 pb-6">
                    <p className="text-sm text-gray-500">Menampilkan <span className="text-gray-900 font-medium">{BOOKS.length}</span> buku dikurasi</p>
                    <div className="flex items-center gap-4">
                        <button className="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-2">
                            Populer <span className="text-[10px]">▼</span>
                        </button>
                    </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                    {BOOKS.map(book => (
                        <BookCard key={book.id} book={book} />
                    ))}
                </div>

                {/* Pagination */}
                <div className="mt-24 border-t border-gray-200 pt-10 flex justify-between items-center">
                    <button className="text-xs uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors flex items-center gap-2">
                         <span>←</span> Prev
                    </button>
                    <div className="flex space-x-8 text-sm font-serif italic">
                        <span className="border-b border-gray-900 text-gray-900 pb-1">01</span>
                        <span className="text-gray-400 hover:text-gray-900 cursor-pointer transition-colors">02</span>
                        <span className="text-gray-400 hover:text-gray-900 cursor-pointer transition-colors">03</span>
                    </div>
                    <button className="text-xs uppercase tracking-widest text-gray-900 hover:text-gray-600 transition-colors flex items-center gap-2">
                        Next <span>→</span>
                    </button>
                </div>
            </div>
        </div>
    );
};

export default BookGrid;