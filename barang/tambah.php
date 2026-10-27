<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$data = ['kode'=>'','nama'=>'','kategori'=>'','harga'=>'','stok'=>'']; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    foreach (['kode','nama','kategori'] as $field) { $data[$field] = trim($_POST[$field] ?? ''); }
    $data['harga'] = $_POST['harga'] ?? ''; $data['stok'] = $_POST['stok'] ?? '';
    if ($data['kode']==='' || $data['nama']==='' || $data['kategori']==='' || $data['harga']==='' || $data['stok']==='') {
        $error = 'Semua kolom wajib diisi.';
    } elseif (!is_numeric($data['harga']) || (float)$data['harga'] < 0 || !filter_var($data['stok'], FILTER_VALIDATE_INT, ['options'=>['min_range'=>0]])) {
        $error = 'Harga harus angka positif dan stok harus bilangan bulat minimal 0.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO barang (kode,nama,kategori,harga,stok) VALUES (?,?,?,?,?)');
            $stmt->execute([$data['kode'],$data['nama'],$data['kategori'],$data['harga'],$data['stok']]);
            $_SESSION['flash'] = 'Barang berhasil ditambahkan.';
            header('Location: index.php'); exit;
        } catch (PDOException $e) {
            $error = $e->getCode()==='23000' ? 'Kode barang sudah digunakan.' : 'Data gagal disimpan.';
        }
    }
}
$pageTitle = 'Tambah Barang'; $submitLabel = 'Simpan Barang';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="h2 page-title mb-1">Tambah Barang</h1><p class="text-secondary mb-4">Masukkan informasi barang dengan benar.</p>
<?php require __DIR__ . '/form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
