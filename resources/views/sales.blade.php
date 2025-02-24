<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Transaksi Penjualan</h2>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $products = ['Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Keyboard', 'Mouse', 'Headphone'];
                    $status = ['Selesai', 'Pending', 'Dibatalkan'];

                    for($i = 1; $i <= 10; $i++) {
                        $product = $products[array_rand($products)];
                        $qty = rand(1, 5);
                        $price = rand(1000000, 15000000);
                        $total = $qty * $price;
                        $date = date('Y-m-d', strtotime("-" . rand(0, 30) . " days"));
                        $currentStatus = $status[array_rand($status)];
                @endphp
                <tr>
                    <td>TRX-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $date }}</td>
                    <td>{{ $product }}</td>
                    <td>{{ $qty }}</td>
                    <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $currentStatus == 'Selesai' ? 'bg-success' : ($currentStatus == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $currentStatus }}
                        </span>
                    </td>
                </tr>
                @php
                    }
                @endphp
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
