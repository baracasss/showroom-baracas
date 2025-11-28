<?php
require "./koneksi.php";

// Jika ada request delete
if (isset($_GET['delete_id'])) {
  $delete_id = (int)$_GET['delete_id'];
  mysqli_query($koneksi, "DELETE FROM mobil WHERE id = $delete_id");
  echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
  exit;
}

// Ambil semua data mobil
$mobils = [];
if (isset($_GET['cari'])) {
  mysqli_real_escape_string($koneksi, $_GET['cari']);
  $stmt = mysqli_prepare($koneksi, "SELECT id, nama, gambar, harga, merk FROM mobil WHERE nama LIKE ? ORDER BY id DESC");
  $stmt->bind_param("s", $_GET['cari']);
  $stmt->execute();
  $stmt->bind_result($id, $nama, $gambar, $harga, $merk);
  while ($stmt->fetch()) {
    $mobils[] = compact("id", "nama", "gambar", "harga", "merk");
  }
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM mobil ORDER BY id DESC");
  while ($row = mysqli_fetch_assoc($query)) {
    $mobils[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Showroom Mobil Baracas</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
    }
    .card {
      background: #fff;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 1rem;
      text-align: center;
      transition: transform 0.2s;
      position: relative;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      border-radius: 0.5rem;
      object-fit: cover;
      height: 150px;
    }

    .card h3 {
      margin: 0.5rem 0;
      font-size: 1.1rem;
      color: #111827;
    }

    .card p {
      margin: 0.3rem 0;
      color: #6b7280;
    }

    .card .actions {
      margin-top: 0.5rem;
      display: flex;
      justify-content: center;
      gap: 0.5rem;
    }

    .card .actions a {
      text-decoration: none;
      padding: 0.4rem 0.7rem;
      border-radius: 0.4rem;
      font-size: 0.85rem;
      color: #fff;
      transition: background-color 0.2s;
    }

    .card .actions .detail {
      background-color: #38bd4e;
    }

    .card .actions .detail:hover {
      background-color: #369946;
    }

    .card .actions .edit {
      background-color: #2563eb;
    }

    .card .actions .edit:hover {
      background-color: #1d4ed8;
    }

    .card .actions .delete {
      background-color: #ef4444;
    }

    .card .actions .delete:hover {
      background-color: #b91c1c;
    }

    /* Search box styling */
    .search-box {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 1rem 0 1.5rem;
    }

    .search-box input {
      flex: 1;
      padding: 0.6rem 0.9rem;
      border-radius: 0.4rem;
      border: 1px solid #d1d5db;
      font-size: 0.95rem;
    }

    .search-box button {
      padding: 0.6rem 1rem;
      border: none;
      background-color: #2563eb;
      color: white;
      border-radius: 0.4rem;
      cursor: pointer;
      font-size: 0.9rem;
      transition: background-color 0.2s;
    }

    .search-box button:hover {
      background-color: #1d4ed8;
    }

    .search-box .reset-btn {
      padding: 0.55rem 0.9rem;
      background-color: #6b7280;
      color: #fff;
      border-radius: 0.4rem;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .search-box .reset-btn:hover {
      background-color: #4b5563;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <h1>Showroom Mobil Baracas</h1>
    <nav>
      <a href="/tambah.php">Tambah data</a>
      <a href="#katalog">Katalog</a>
      <a href="#tentang">Tentang</a>
      <a href="#kontak">Kontak</a>
    </nav>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h2>Temukan Mobil Impian Anda</h2>
    <p>Harga Terjangkau • Kualitas Terjamin • Layanan Terbaik</p>
  </section>

  <!-- Katalog Mobil -->
  <section id="katalog" class="container">
    <h2>Katalog Mobil</h2>
    <form class="search-box">
      <input type="text" name="cari" id="cari" placeholder="Cari nama mobil...">
      <button type="submit">Cari</button>
      <a href="/" class="reset-btn">Reset</a>
    </form>
    <div class="grid">
      <?php if (count($mobils) > 0): ?>
        <?php foreach ($mobils as $mobil): ?>
          <div class="card">
            <img src="<?= htmlspecialchars($mobil['gambar']) ?>" alt="<?= htmlspecialchars($mobil['nama']) ?>">
            <h3><?= htmlspecialchars($mobil['nama'] . ' (' . $mobil['merk'] . ')') ?></h3>
            <p>Harga: Rp <?= number_format($mobil['harga'], 0, ',', '.') ?></p>
            <div class="actions">
              <a href="detail.php?id=<?= $mobil['id'] ?>" class="detail">Detail</a>
              <a href="edit.php?id=<?= $mobil['id'] ?>" class="edit">Edit</a>
              <a href="?delete_id=<?= $mobil['id'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus mobil ini?')">Delete</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Belum ada data mobil.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Tentang -->
  <section id="tentang" class="container">
    <h2>Tentang Kami</h2>
    <p>Showroom Mobil Baracas hadir untuk memberikan pengalaman terbaik dalam membeli mobil. Kami menawarkan berbagai pilihan mobil baru dan bekas dengan kualitas terbaik serta harga yang bersaing.</p>
  </section>

  <!-- Kontak -->
  <section id="kontak" class="container">
    <h2>Kontak</h2>
    <p>📍 Alamat: Jl. Sukabumi</p>
    <p>📞 Telp: 0813-8533-9525</p>
    <p>📧 Email: showroom@example.com</p>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Showroom Mobil Baracas. Semua Hak Dilindungi.</p>
  </footer>
</body>
</html>
