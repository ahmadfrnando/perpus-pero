<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peminjaman Buku</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    width: 400px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
    padding: 20px;
}

.card-header {
    background-color: #4CAF50;
    color: white;
    padding: 10px 0;
    border-radius: 10px 10px 0 0;
}

.card-body {
    margin-top: 20px;
}

.qr-code img {
    width: 200px;
    height: 200px;
    margin-bottom: 15px;
}

.details {
    text-align: left;
}

.details p {
    margin-bottom: 8px;
    font-size: 14px;
}

.details strong {
    font-weight: bold;
}

.card-footer {
    margin-top: 20px;
    font-size: 12px;
    color: #777;
}

.card-footer p {
    margin: 0;
}

    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>Kartu Peminjaman Buku</h2>
        </div>
        <div class="card-body">
            <div class="qr-code">
                <!-- QR code image, bisa digenerate menggunakan library QR Code Generator -->
                <img src="{{ asset('qrcodes/'. $data->qrcode) }}" alt="QR Code">
            </div>
            <div class="details">
                <p><strong>Nama Peminjam:</strong> <span id="name">{{ $data->anggota->nama_anggota}}</span></p>
                <p><strong>Buku yang Dipinjam:</strong> <span id="book">Pemrograman Web</span></p>
                <p><strong>Tanggal Peminjaman:</strong> <span id="borrowed-date">01 Januari 2024</span></p>
                <p><strong>Tanggal Pengembalian:</strong> <span id="return-date">15 Januari 2024</span></p>
            </div>
        </div>
        <div class="card-footer">
            <p>SMK Swasta Swakarya - Perpustakaan</p>
        </div>
    </div>

<script>
    window.print();
</script>
</body>
</html>
