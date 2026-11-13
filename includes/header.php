<?php
require_once __DIR__ . '/../config.php';
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> · <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app-shell">
