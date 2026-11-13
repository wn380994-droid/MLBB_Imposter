<?php
require_once 'config.php';
require_game();
$game =& $_SESSION['game'];
$current = max(0, min(4, (int)($game['current'] ?? 0)));
$player = $game['players'][$current];
$isImposter = $current === (int)$game['imposter'];
$isLast = $current === 4;
$pageTitle = 'Game · ' . $game['squad_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'next' && $current < 4) {
        $game['current'] = $current + 1;
        redirect('game.php');
    }
    if ($action === 'play_again') {
        $pdo = db();
        $stmt = $pdo->query('SELECT id, answer, hint, category FROM game_data ORDER BY RAND() LIMIT 1');
        $data = $stmt->fetch();
        $newImposter = random_int(0, 4);

        // Finish the current round so History keeps one row per played round.
        $finish = $pdo->prepare("UPDATE games SET status='completed', updated_at=NOW() WHERE id=?");
        $finish->execute([$game['id']]);

        // Create a new round using the same squad/player names.
        $insert = $pdo->prepare(
            'INSERT INTO games (squad_name, player1, player2, player3, player4, player5, imposter_index, data_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $insert->execute([
            $game['squad_name'],
            $game['players'][0], $game['players'][1], $game['players'][2],
            $game['players'][3], $game['players'][4],
            $newImposter, $data['id']
        ]);

        $game['id'] = (int)$pdo->lastInsertId();
        $game['imposter'] = $newImposter;
        $game['data_id'] = (int)$data['id'];
        $game['answer'] = $data['answer'];
        $game['hint'] = $data['hint'];
        $game['category'] = $data['category'];
        $game['current'] = 0;
        redirect('game.php');
    }
    if ($action === 'end') {
        $pdo = db();
        $stmt = $pdo->prepare("UPDATE games SET status='completed', updated_at=NOW() WHERE id=?");
        $stmt->execute([$game['id']]);
        unset($_SESSION['game']);
        redirect('index.php');
    }
}
require 'includes/header.php';
?>
<header class="navbar">
    <a class="brand" href="index.php">MLBB <span>IMPOSTER</span></a>
    <span class="nav-link"><?= e($game['squad_name']) ?></span>
</header>

<div class="game-head">
    <div>
        <div class="muted">Current turn</div>
        <h1><?= e($player) ?></h1>
    </div>
    <div class="progress">Player <?= $current + 1 ?> / 5</div>
</div>

<div class="notice center">Pass the screen to <strong><?= e($player) ?></strong>. Hover the card (or tap it) to reveal the secret.</div>

<div class="card-stage">
    <div class="player-card" tabindex="0" aria-label="Secret card for <?= e($player) ?>">
        <div class="card-inner">
            <div class="card-face card-front">
                <div class="card-kicker">Secret Card</div>
                <h2><?= e($player) ?></h2>
                <div class="muted">Hover / tap to reveal</div>
            </div>
            <div class="card-face card-back">
                <?php if ($isImposter): ?>
                    <span class="imposter-badge">IMPOSTER</span>
                    <h2>🕵️ You are the Imposter</h2>
                    <p class="card-hint"><strong>Hint:</strong> <?= e($game['hint']) ?></p>
                <?php else: ?>
                    <span class="answer-badge"><?= e($game['category']) ?></span>
                    <h2><?= e($game['answer']) ?></h2>
                    <p class="card-hint">Remember this answer. Do not show the next player.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<form method="post" class="game-actions">
    <?php if (!$isLast): ?>
        <button class="btn btn-primary" name="action" value="next" type="submit">Next →</button>
    <?php else: ?>
        <button class="btn btn-gold" name="action" value="play_again" type="submit">Play Again ↻</button>
    <?php endif; ?>
    <button class="btn btn-danger" name="action" value="end" type="submit" data-confirm="End this game and return to the dashboard?">End Game</button>
</form>
<p class="footer-note">The exact answer is hidden from the imposter; only the hint is shown.</p>
<?php require 'includes/footer.php'; ?>
