<?php
require 'config.php';

$code = $_GET['c'] ?? '';

$stmt = $pdo->prepare("SELECT long_url FROM urls WHERE short_code = ?");
$stmt->execute([$code]);
$url = $stmt->fetch();

if (!$url) {
    http_response_code(404);
    echo "Short URL not found";
    exit;
}

$pdo->prepare("UPDATE urls SET clicks = clicks + 1 WHERE short_code = ?")
    ->execute([$code]);

header("Location: {$url['long_url']}");
exit;