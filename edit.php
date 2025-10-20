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

// Jika form disubmit, update data
if (!empty($_POST)) {
    $nama = $_POST['nama_mobil'];
    $deskripsi = $_POST['deskripsi_mobil'];
    $merk = $_POST['merk'];
    $gambar = $_POST['gambar'];
    $harga = (int)$_POST['harga'];

    $query = mysqli_query($koneksi, "UPDATE mobil SET nama='$nama', deskripsi='$deskripsi', merk='$merk', gambar='$gambar', harga='$harga' WHERE id=$id");

    if ($query) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --bg-color: #f9fafb;
            --text-color: #111827;
            --border-color: #e5e7eb;
            --radius: 0.5rem;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: #fff;
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
        }

        input {
            padding: 0.6rem 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            outline: none;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.7rem;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        button:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <form method="POST">
        <label for="nama">Nama Mobil:</label>
        <input type="text" name="nama_mobil" id="nama" value="<?= htmlspecialchars($mobil['nama']) ?>" required>
        
        <label for="deskripsi">Deskripsi Mobil:</label>
        <textarea name="deskripsi_mobil" id="deskripsi"><?= htmlspecialchars($mobil['deskripsi']) ?></textarea>

        <label for="merk">Merk Mobil:</label>
        <input type="text" id="merk" name="merk" value="<?= htmlspecialchars($mobil['merk']) ?>" required>

        <label for="gambar">Gambar Mobil (URL):</label>
        <input type="url" id="gambar" name="gambar" value="<?= htmlspecialchars($mobil['gambar']) ?>" required>

        <label for="harga">Harga Mobil:</label>
        <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($mobil['harga']) ?>" required>

        <button type="submit">Perbarui Data</button>
    </form>

</body>

</html>
