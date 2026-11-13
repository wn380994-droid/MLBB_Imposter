<?php
declare(strict_types=1);

const DB_HOST = '***.*.*.*';
const DB_NAME = 'mlbb_imposter';
const DB_USER = 'root';
const DB_PASS = '';
const APP_NAME = 'MLBB Imposter';

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
    return $pdo;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never {
    header('Location: ' . $url);
    exit;
}

function require_game(): void {
    if (empty($_SESSION['game'])) {
        redirect('index.php');
    }
}
