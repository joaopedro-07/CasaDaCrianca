<?php

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USERNAME'] ?? 'usuario';
$pass = $_ENV['DB_PASSWORD'] ?? 'senha123';
$db   = $_ENV['DB_DATABASE'] ?? 'db_casadacrianca';
$port = $_ENV['DB_PORT'] ?? '3306';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>