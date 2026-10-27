<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, nama, username, password FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Username atau password tidak sesuai.';
}
$pageTitle = 'Login';
require __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap">
  <div class="card p-4 p-md-5">
    <h1 class="h3 page-title mb-2">Login</h1>
    <p class="text-secondary mb-4">Masuk untuk melanjutkan ke aplikasi inventori.</p>
    <?php if (!empty($_SESSION['flash'])): ?><div class="alert alert-success"><?= e($_SESSION['flash']); unset($_SESSION['flash']); ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" maxlength="50" required value="<?= e($_POST['username'] ?? '') ?>"></div>
      <div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" type="password" id="password" name="password" required></div>
      <button class="btn btn-primary w-100" type="submit">Masuk</button>
    </form>
    <p class="text-secondary small mt-3 mb-0">Belum punya akun? <a href="register.php">Registrasi</a></p>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
