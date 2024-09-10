<?php

use App\Comment;
use App\Database;



$db = new Database('localhost', 'mydb', 'root', '');
$comment = new Comment($db);

$comments = $comment->getComments(1);

function displayComments($comments, $parentId = null, $level = 0) {
    if ($level > 10) return;
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parentId) {
            echo "<div style='margin-left: ".($level * 20)."px;'>";
            echo "<strong>{$comment['user_name']}</strong>: {$comment['content']}";
            echo "<button class='reply-btn' data-id='{$comment['id']}'>Ответить</button>";
            echo "<button class='edit-btn' data-id='{$comment['id']}'>Редактировать</button>";
            displayComments($comments, $comment['id'], $level + 1);
            echo "</div>";
        }
    }
}

displayComments($comments);
