<?php
$pageTitle = $pageTitle ?? 'Inventori Barang';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | Inventori Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="dashboard.php">Inventori Barang</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Buka navigasi">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
        <a class="nav-link" href="barang/index.php">Data Barang</a>
        <a class="nav-link" href="laporan.php">Laporan</a>
        <a class="nav-link" href="logout.php">Keluar</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</nav>
<main class="container py-4">
