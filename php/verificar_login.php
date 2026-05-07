<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
require_once '../conexao.php';
$id_logado = $_SESSION['admin_id'];


?>