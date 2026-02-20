<?php
header('Content-Type: application/json');
require 'config.php';

$url = trim($_POST['long_url'] ?? '');

if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    echo json_encode(['error' => 'Please enter a valid URL']);
    exit;
}

// Generate unique short code
do {
    $code = substr(bin2hex(random_bytes(5)), 0, 8);
    $stmt = $pdo->prepare("SELECT id FROM urls WHERE short_code = ?");
    $stmt->execute([$code]);
} while ($stmt->fetch());

$stmt = $pdo->prepare("INSERT INTO urls (long_url, short_code) VALUES (?, ?)");
$stmt->execute([$url, $code]);

echo json_encode([
    'short_url' => "http://localhost/shortly/$code"
]);