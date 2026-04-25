<?php
session_start();
require_once '../conexao.php';

// IMPEDIR CACHE (Coloque isso em todas as páginas do diretório /php)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$id = $_SESSION['admin_id'];

$sql = "DELETE FROM administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

session_destroy();
header("Location: ../index.php");