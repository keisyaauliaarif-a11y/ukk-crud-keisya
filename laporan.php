<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_login();
$items = $pdo->query('SELECT kode,nama,kategori,harga,stok,(harga*stok) AS nilai FROM barang ORDER BY nama ASC')->fetchAll();
$totalStok = 0; $totalNilai = 0;
foreach ($items as $item) { $totalStok += (int)$item['stok']; $totalNilai += (float)$item['nilai']; }
$pageTitle = 'Laporan Barang';
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h1 class="h2 page-title mb-1">Laporan Barang</h1><p class="text-secondary mb-0">Ringkasan persediaan saat ini.</p></div><button class="btn btn-primary" onclick="window.print()">Cetak / Simpan PDF</button></div>
<div class="card p-3 p-md-4">
  <div class="row g-3 mb-3"><div class="col-md-6"><div class="p-3 rounded bg-light"><div class="text-secondary small">Jumlah jenis barang</div><div class="h3 mb-0"><?= count($items) ?></div></div></div><div class="col-md-6"><div class="p-3 rounded bg-light"><div class="text-secondary small">Total unit stok</div><div class="h3 mb-0"><?= number_format($totalStok,0,',','.') ?></div></div></div></div>
  <div class="table-responsive"><table class="table table-bordered align-middle"><thead><tr><th>No.</th><th>Kode</th><th>Nama</th><th>Kategori</th><th class="text-end">Harga</th><th class="text-end">Stok</th><th class="text-end">Nilai stok</th></tr></thead><tbody>
  <?php foreach ($items as $i=>$item): ?><tr><td><?= $i+1 ?></td><td><?= e($item['kode']) ?></td><td><?= e($item['nama']) ?></td><td><?= e($item['kategori']) ?></td><td class="text-end"><?= e(rupiah($item['harga'])) ?></td><td class="text-end"><?= number_format((int)$item['stok'],0,',','.') ?></td><td class="text-end"><?= e(rupiah($item['nilai'])) ?></td></tr><?php endforeach; ?>
  <?php if (!$items): ?><tr><td colspan="7" class="text-center text-secondary">Belum ada data barang.</td></tr><?php endif; ?>
  </tbody><tfoot><tr class="fw-bold"><td colspan="5" class="text-end">Total</td><td class="text-end"><?= number_format($totalStok,0,',','.') ?></td><td class="text-end"><?= e(rupiah($totalNilai)) ?></td></tr></tfoot></table></div>
  <p class="small text-secondary mb-0">Untuk menyimpan sebagai PDF, pilih tujuan printer “Save as PDF” pada dialog cetak.</p>
</div>
<style>@media print { .app-navbar, footer, button { display:none !important; } body { background:white; } .card { box-shadow:none; } }</style>
<?php require __DIR__ . '/includes/footer.php'; ?>
