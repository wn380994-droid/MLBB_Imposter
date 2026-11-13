<?php
require_once 'config.php';
$pageTitle = 'Dashboard';
require 'includes/header.php';
?>
<header class="navbar">
    <a class="brand" href="index.php">MLBB <span>IMPOSTER</span></a>
    <a class="nav-link" href="history.php">Game History</a>
</header>

<section class="hero">
    <div class="eyebrow">5 Players · One Imposter</div>
    <h1>Who is the <span style="color:var(--gold)">Imposter?</span></h1>
    <p>Pass the card to each player. Hover or tap to secretly reveal their role. Four players receive the exact answer while the imposter receives only a subtle hint.</p>
    <div class="actions">
        <a class="btn btn-primary" href="start.php">Start Game</a>
        <a class="btn btn-secondary" href="history.php">History</a>
    </div>
</section>

<section class="card-grid">
    <div class="info-card"><h3>🎮 5 Players</h3><p>Every round requires exactly five players and one randomly selected imposter.</p></div>
    <div class="info-card"><h3>🕵️ Secret Role</h3><p>The imposter sees a hint only. Everyone else sees the exact MLBB answer.</p></div>
    <div class="info-card"><h3>📚 50 Topics</h3><p>25 heroes, 15 items and 10 battle spells are included in the starter database.</p></div>
</section>

<p class="footer-note">Built with PHP + MySQL · Designed for XAMPP</p>
<?php require 'includes/footer.php'; ?>
