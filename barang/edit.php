<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit('ID barang tidak valid.'); }
$stmt = $pdo->prepare('SELECT * FROM barang WHERE id = ?'); $stmt->execute([$id]); $data = $stmt->fetch();
if (!$data) { http_response_code(404); exit('Barang tidak ditemukan.'); }
$error = '';
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
            $stmt = $pdo->prepare('UPDATE barang SET kode=?,nama=?,kategori=?,harga=?,stok=? WHERE id=?');
            $stmt->execute([$data['kode'],$data['nama'],$data['kategori'],$data['harga'],$data['stok'],$id]);
            $_SESSION['flash'] = 'Perubahan barang berhasil disimpan.';
            header('Location: index.php'); exit;
        } catch (PDOException $e) {
            $error = $e->getCode()==='23000' ? 'Kode barang sudah digunakan.' : 'Perubahan gagal disimpan.';
        }
    }
}
$pageTitle = 'Edit Barang'; $submitLabel = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="h2 page-title mb-1">Edit Barang</h1><p class="text-secondary mb-4">Perbarui informasi barang yang dipilih.</p>
<?php require __DIR__ . '/form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
