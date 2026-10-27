<?php
// Form bersama untuk tambah dan edit barang.
?>
<div class="card p-3 p-md-4">
  <?php if (!empty($error)): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="row g-3">
      <div class="col-12 col-md-6"><label class="form-label" for="kode">Kode barang</label><input class="form-control" id="kode" name="kode" maxlength="30" required value="<?= e($data['kode'] ?? '') ?>"></div>
      <div class="col-12 col-md-6"><label class="form-label" for="nama">Nama barang</label><input class="form-control" id="nama" name="nama" maxlength="120" required value="<?= e($data['nama'] ?? '') ?>"></div>
      <div class="col-12 col-md-6"><label class="form-label" for="kategori">Kategori</label><input class="form-control" id="kategori" name="kategori" maxlength="80" required value="<?= e($data['kategori'] ?? '') ?>"></div>
      <div class="col-12 col-md-3"><label class="form-label" for="harga">Harga (Rp)</label><input class="form-control" type="number" id="harga" name="harga" min="0" step="1" required value="<?= e($data['harga'] ?? '') ?>"></div>
      <div class="col-12 col-md-3"><label class="form-label" for="stok">Stok</label><input class="form-control" type="number" id="stok" name="stok" min="0" step="1" required value="<?= e($data['stok'] ?? '') ?>"></div>
    </div>
    <div class="d-flex gap-2 mt-4"><button class="btn btn-primary" type="submit"><?= e($submitLabel ?? 'Simpan') ?></button><a class="btn btn-outline-secondary" href="index.php">Batal</a></div>
  </form>
</div>
