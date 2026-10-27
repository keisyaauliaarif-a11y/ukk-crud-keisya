<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_login();
$jumlah = (int)$pdo->query('SELECT COUNT(*) FROM barang')->fetchColumn();
$totalStok = (int)$pdo->query('SELECT COALESCE(SUM(stok),0) FROM barang')->fetchColumn();
$totalNilai = (float)$pdo->query('SELECT COALESCE(SUM(harga * stok),0) FROM barang')->fetchColumn();
$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div><h1 class="h2 page-title mb-1">Dashboard</h1><p class="text-secondary mb-0">Selamat datang, <?= e($_SESSION['nama'] ?? 'Pengguna') ?>.</p></div>
  <a class="btn btn-primary" href="barang/tambah.php">+ Tambah Barang</a>
</div>
<div class="row g-3 mb-4">
  <div class="col-12 col-md-4"><div class="card card-stat p-4 h-100"><div class="text-secondary">Jumlah barang</div><div class="display-6 fw-bold"><?= $jumlah ?></div><div class="small text-secondary">Jenis barang terdaftar</div></div></div>
  <div class="col-12 col-md-4"><div class="card card-stat p-4 h-100"><div class="text-secondary">Total stok</div><div class="display-6 fw-bold"><?= number_format($totalStok, 0, ',', '.') ?></div><div class="small text-secondary">Seluruh unit barang</div></div></div>
  <div class="col-12 col-md-4"><div class="card card-stat p-4 h-100"><div class="text-secondary">Total nilai stok</div><div class="h2 fw-bold mt-2"><?= e(rupiah($totalNilai)) ?></div><div class="small text-secondary">Harga dikali jumlah stok</div></div></div>
</div>
<div class="card p-4"><h2 class="h5">Mulai bekerja</h2><p class="text-secondary mb-3">Kelola kode, nama, kategori, harga, dan stok barang dari menu Data Barang.</p><div><a class="btn btn-outline-primary" href="barang/index.php">Buka Data Barang</a> <a class="btn btn-outline-secondary" href="laporan.php">Lihat Laporan</a></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
