<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Comment;
use Dotenv;

// Загрузка переменных окружения
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Подключение к базе данных
$db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$commentModel = new Comment($db);

// Идентификатор статьи (например, статичная статья с ID 1)
$articleId = 1;

// Получаем все комментарии для данной статьи
$comments = $commentModel->getComments($articleId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment System</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<h1>Comments</h1>

<form action="add_comment.php" method="POST">
    <input type="text" name="username" placeholder="Your name" required><br>
    <textarea name="content" placeholder="Your comment" required></textarea><br>
    <input type="hidden" name="article_id" value="<?= $articleId ?>">
    <input type="hidden" name="parent_id" value="0">
    <button type="submit">Submit Comment</button>
</form>

<hr>

<div id="comments">
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment" style="margin-left: <?= $comment['depth'] * 20 ?>px;">
                <p><strong><?= htmlspecialchars($comment['user_name']) ?></strong> (<?= $comment['created_at'] ?>)</p>
                <p><?= htmlspecialchars($comment['content']) ?></p>
                <form action="add_comment.php" method="POST">
                    <input type="text" name="username" placeholder="Your name" required><br>
                    <textarea name="content" placeholder="Reply" required></textarea><br>
                    <input type="hidden" name="article_id" value="<?= $articleId ?>">
                    <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                    <button type="submit">Reply</button>
                </form>
                <form action="edit_comment.php" method="POST" style="display:inline;">
                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                    <textarea name="content"><?= htmlspecialchars($comment['content']) ?></textarea><br>
                    <button type="submit">Edit</button>
                </form>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
</div>

<script src="assets/js/app.js"></script>
</body>
</html>
