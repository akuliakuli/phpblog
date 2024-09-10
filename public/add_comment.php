<?php

use App\Comment;
use App\Database;


$db = new Database('localhost', 'mydb', 'root', '');
$comment = new Comment($db);

$userName = $_POST['user_name'];
$content = $_POST['content'];
$parentId = $_POST['parent_id'] ?? null;

$comment->addComment(1, $userName, $content, $parentId);
