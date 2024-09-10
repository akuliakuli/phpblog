<?php

use App\Comment;
use App\Database;


$db = new Database('localhost', 'mydb', 'root', '');
$comment = new Comment($db);

$commentId = $_POST['id'];
$content = $_POST['content'];

$comment->editComment($commentId, $content);
