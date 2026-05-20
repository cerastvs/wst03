<?php
$host = '127.0.0.1';
$port = '3307';
$dbName = 'jobseeker';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
