<?php
require_once 'config.php';
$pageTitle = 'History';
$pdo = db();
$games = $pdo->query(
    "SELECT g.*, gd.answer, gd.category
     FROM games g
     JOIN game_data gd ON gd.id = g.data_id
     ORDER BY g.created_at DESC"
)->fetchAll();

require 'includes/header.php';
?>
<header class="navbar">
    <a class="brand" href="index.php">MLBB <span>IMPOSTER</span></a>
    <a class="btn btn-primary" href="start.php">Start Game</a>
</header>

<div class="panel">
    <h1 class="panel-title">Game History</h1>
    <p class="panel-subtitle">Every started round is recorded with its squad, answer and selected imposter.</p>
    <?php if (!$games): ?>
        <div class="empty">No games yet. Start your first 5-player round.</div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Squad</th><th>Players</th><th>Imposter</th><th>Topic</th><th>Answer</th><th>Played At</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($games as $g):
                $players = [$g['player1'],$g['player2'],$g['player3'],$g['player4'],$g['player5']];
                $imposter = $players[(int)$g['imposter_index']];
            ?>
                <tr>
                    <td><strong><?= e($g['squad_name']) ?></strong></td>
                    <td><?= e(implode(', ', $players)) ?></td>
                    <td><span class="imposter-badge"><?= e($imposter) ?></span></td>
                    <td><?= e($g['category']) ?></td>
                    <td><?= e($g['answer']) ?></td>
                    <td><?= e(date('d M Y, h:i A', strtotime($g['created_at']))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php require 'includes/footer.php'; ?>
