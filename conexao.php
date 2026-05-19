<?php

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db   = $_ENV['DB_NAME'] ?? 'bd_casadacrianca';
$port = $_ENV['DB_PORT'] ?? '3306';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>