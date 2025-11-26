<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1a1a1a;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        
        .header p {
            font-size: 10px;
            color: #6b7280;
            margin-top: 5px;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 15px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .stat-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background: #1a1a1a;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        table tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Z3LF BOOKSTORE</h1>
        <p>LAPORAN PENJUALAN</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Buku Terjual</div>
            <div class="stat-value">{{ $booksSold }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rata-rata Pesanan</div>
            <div class="stat-value">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Top Books -->
    <div class="section">
        <div class="section-title">10 Buku Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Judul Buku</th>
                    <th width="25%">Pengarang</th>
                    <th width="15%" class="text-right">Terjual</th>
                    <th width="15%" class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topBooks as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->pengarang }}</td>
                        <td class="text-right">{{ $book->total_sold }}</td>
                        <td class="text-right">Rp {{ number_format($book->revenue, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6b7280;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top Customers -->
    <div class="section">
        <div class="section-title">10 Pelanggan Teratas</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama</th>
                    <th width="35%">Email</th>
                    <th width="15%" class="text-right">Pesanan</th>
                    <th width="15%" class="text-right">Total Belanja</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCustomers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td class="text-right">{{ $customer->orders_count }}</td>
                        <td class="text-right">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6b7280;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate otomatis pada {{ now()->format('d M Y H:i') }}</p>
        <p>© {{ now()->year }} Z3LF Bookstore. All rights reserved.</p>
    </div>
</body>
</html>
