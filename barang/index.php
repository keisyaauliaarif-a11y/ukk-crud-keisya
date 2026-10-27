<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $stmt = $pdo->prepare('SELECT * FROM barang WHERE kode LIKE ? OR nama LIKE ? OR kategori LIKE ? ORDER BY id DESC');
    $like = '%' . $q . '%'; $stmt->execute([$like, $like, $like]); $items = $stmt->fetchAll();
} else {
    $items = $pdo->query('SELECT * FROM barang ORDER BY id DESC')->fetchAll();
}
$pageTitle = 'Data Barang';
require __DIR__ . '/../includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h1 class="h2 page-title mb-1">Data Barang</h1><p class="text-secondary mb-0">Cari dan kelola persediaan barang.</p></div><a class="btn btn-primary" href="tambah.php">+ Tambah Barang</a></div>
<?php if (!empty($_SESSION['flash'])): ?><div class="alert alert-success"><?= e($_SESSION['flash']); unset($_SESSION['flash']); ?></div><?php endif; ?>
<div class="card p-3 p-md-4">
  <form class="row g-2 mb-3" method="get"><div class="col"><input class="form-control" name="q" placeholder="Cari kode, nama, atau kategori..." value="<?= e($q) ?>"></div><div class="col-auto"><button class="btn btn-outline-primary">Cari</button><?php if ($q !== ''): ?> <a class="btn btn-outline-secondary" href="index.php">Reset</a><?php endif; ?></div></form>
  <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>No.</th><th>Kode</th><th>Nama</th><th>Kategori</th><th class="text-end">Harga</th><th class="text-end">Stok</th><th class="text-end">Nilai stok</th><th>Aksi</th></tr></thead><tbody>
  <?php if (!$items): ?><tr><td colspan="8" class="text-center text-secondary py-4">Data barang belum tersedia.</td></tr><?php endif; ?>
  <?php foreach ($items as $i => $item): ?><tr><td><?= $i + 1 ?></td><td><?= e($item['kode']) ?></td><td class="fw-semibold"><?= e($item['nama']) ?></td><td><?= e($item['kategori']) ?></td><td class="text-end"><?= e(rupiah($item['harga'])) ?></td><td class="text-end"><?= number_format((int)$item['stok'],0,',','.') ?></td><td class="text-end"><?= e(rupiah($item['harga'] * $item['stok'])) ?></td><td><div class="d-flex gap-1"><a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= (int)$item['id'] ?>">Edit</a><form method="post" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus barang ini?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></td></tr><?php endforeach; ?>
  </tbody></table></div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
