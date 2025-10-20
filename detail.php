<?php
require "./koneksi.php";

if (!isset($_GET['id'])) {
    echo "<script>alert('ID mobil tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$id = (int)$_GET['id'];

// Ambil data mobil dari database
$result = mysqli_query($koneksi, "SELECT * FROM mobil WHERE id = $id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
    echo "<script>alert('Data mobil tidak ditemukan'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Mobil - <?= htmlspecialchars($mobil['nama']) ?></title>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f9fafb;
        color: #111827;
        margin: 0;
        display: flex;
        justify-content: center;
        padding: 2rem;
    }
    .container {
        background: #fff;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        max-width: 600px;
        width: 100%;
    }
    img {
        width: 100%;
        border-radius: 0.5rem;
        object-fit: cover;
        margin-bottom: 1rem;
        height: 300px;
    }
    h2 {
        margin-top: 0;
        font-size: 1.5rem;
        color: #111827;
    }
    p {
        margin: 0.5rem 0;
        color: #6b7280;
        font-size: 1rem;
    }
    .back-btn {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        background-color: #2563eb;
        color: white;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .back-btn:hover {
        background-color: #1d4ed8;
    }
</style>
</head>
<body>

<div class="container">
    <img src="<?= htmlspecialchars($mobil['gambar']) ?>" alt="<?= htmlspecialchars($mobil['nama']) ?>">
    <h2><?= htmlspecialchars($mobil['nama']) ?> (<?= htmlspecialchars($mobil['merk']) ?>)</h2>
    <p><strong>Deskripsi: </strong> <?= $mobil['deskripsi'] ?></p>
    <p><strong>Harga:</strong> Rp <?= number_format($mobil['harga'], 0, ',', '.') ?></p>
    <a href="index.php" class="back-btn">Kembali ke Katalog</a>
</div>

</body>
</html>
