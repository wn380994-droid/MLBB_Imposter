<?php
require_once 'config.php';
$pageTitle = 'Start Game';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $squad = trim($_POST['squad_name'] ?? '');
    $players = array_map(fn($x) => trim((string)$x), $_POST['players'] ?? []);

    if ($squad === '' || strlen($squad) > 60) {
        $error = 'Please enter a squad name (1–60 characters).';
    } elseif (count($players) !== 5 || in_array('', $players, true)) {
        $error = 'Please enter all 5 player names.';
    } elseif (count(array_unique(array_map('mb_strtolower', $players))) !== 5) {
        $error = 'Player names must be unique.';
    } elseif (max(array_map('strlen', $players)) > 30) {
        $error = 'Each player name must be 30 characters or fewer.';
    } else {
        $pdo = db();
        $stmt = $pdo->prepare('SELECT id, answer, hint, category FROM game_data ORDER BY RAND() LIMIT 1');
        $stmt->execute();
        $data = $stmt->fetch();

        $imposterIndex = random_int(0, 4);

        $insert = $pdo->prepare(
            'INSERT INTO games (squad_name, player1, player2, player3, player4, player5, imposter_index, data_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $insert->execute([
            $squad, $players[0], $players[1], $players[2], $players[3], $players[4],
            $imposterIndex, $data['id']
        ]);

        $_SESSION['game'] = [
            'id' => (int)$pdo->lastInsertId(),
            'squad_name' => $squad,
            'players' => $players,
            'imposter' => $imposterIndex,
            'data_id' => (int)$data['id'],
            'answer' => $data['answer'],
            'hint' => $data['hint'],
            'category' => $data['category'],
            'current' => 0,
        ];
        redirect('game.php');
    }
}
require 'includes/header.php';
?>
<header class="navbar">
    <a class="brand" href="index.php">MLBB <span>IMPOSTER</span></a>
    <a class="nav-link" href="history.php">History</a>
</header>
<div class="form-wrap panel">
    <h1 class="panel-title">Create a Squad</h1>
    <p class="panel-subtitle">Enter one squad name and exactly five unique player names.</p>
    <?php if ($error): ?><div class="notice"><?= e($error) ?></div><?php endif; ?>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="squad_name">Squad Name</label>
            <input class="input" id="squad_name" name="squad_name" maxlength="60" required value="<?= e($_POST['squad_name'] ?? '') ?>" placeholder="e.g. Mythic Squad">
        </div>
        <div class="players">
            <?php for ($i=0; $i<5; $i++): ?>
            <div class="form-group player-field">
                <label for="player<?= $i ?>">Player <?= $i+1 ?></label>
                <input class="input player-name" id="player<?= $i ?>" name="players[]" maxlength="30" required value="<?= e($_POST['players'][$i] ?? '') ?>" placeholder="Player <?= $i+1 ?>">
                <span class="counter" data-count="<?= $i ?>">0/30</span>
            </div>
            <?php endfor; ?>
        </div>
        <div class="actions">
            <a class="btn btn-secondary" href="index.php">Cancel</a>
            <button class="btn btn-primary" type="submit">Start Game</button>
        </div>
    </form>
</div>
<?php require 'includes/footer.php'; ?>
