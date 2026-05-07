<?php
include 'verificar_login.php';

$id = $_SESSION['admin_id'];

$sql = "DELETE FROM administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

session_destroy();
header("Location: ../index.php");