<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { $_SESSION['flash'] = 'ID barang tidak valid.'; header('Location: index.php'); exit; }
$stmt = $pdo->prepare('DELETE FROM barang WHERE id = ?');
$stmt->execute([$id]);
$_SESSION['flash'] = $stmt->rowCount() ? 'Barang berhasil dihapus.' : 'Barang tidak ditemukan.';
header('Location: index.php'); exit;
