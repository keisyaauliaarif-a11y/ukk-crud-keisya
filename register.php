<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($nama === '' || $username === '' || $password === '') {
        $error = 'Semua kolom wajib diisi.';
    } elseif (strlen($username) > 50 || strlen($nama) > 100 || strlen($password) < 8) {
        $error = 'Periksa panjang nama/username. Password minimal 8 karakter.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (nama, username, password) VALUES (?, ?, ?)');
            $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT)]);
            $_SESSION['flash'] = 'Registrasi berhasil. Silakan masuk.';
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = $e->getCode() === '23000' ? 'Username sudah digunakan.' : 'Registrasi gagal. Coba lagi.';
        }
    }
}
$pageTitle = 'Registrasi';
require __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap">
  <div class="card p-4 p-md-5">
    <h1 class="h3 page-title mb-2">Buat akun</h1>
    <p class="text-secondary mb-4">Daftarkan akun untuk mengelola data barang.</p>
    <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="mb-3"><label class="form-label" for="nama">Nama lengkap</label><input class="form-control" id="nama" name="nama" maxlength="100" required value="<?= e($_POST['nama'] ?? '') ?>"></div>
      <div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" maxlength="50" required value="<?= e($_POST['username'] ?? '') ?>"></div>
      <div class="mb-3"><label class="form-label" for="password">Password (minimal 8 karakter)</label><input class="form-control" type="password" id="password" name="password" minlength="8" required></div>
      <button class="btn btn-primary w-100" type="submit">Registrasi</button>
    </form>
    <p class="text-secondary small mt-3 mb-0">Sudah punya akun? <a href="login.php">Login</a></p>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
