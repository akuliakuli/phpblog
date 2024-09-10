<?php
namespace App;

use Exception;
use PDO;



class Comment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addComment($articleId, $userName, $content, $parentId = null) {
        $depth = 0;
        if ($parentId) {
            $parent = $this->getComment($parentId);
            $depth = $parent['depth'] + 1;
            if ($depth > 10) {
                throw new Exception('Нельзя создавать более 10 уровней вложенности');
            }
        }

        $this->db->query("
            INSERT INTO comments (article_id, parent_id, user_name, content, depth)
            VALUES (:article_id, :parent_id, :user_name, :content, :depth)
        ", [
            ':article_id' => $articleId,
            ':parent_id' => $parentId,
            ':user_name' => $userName,
            ':content' => $content,
            ':depth' => $depth
        ]);
    }

    public function editComment($commentId, $content) {
        $this->db->query("
            UPDATE comments
            SET content = :content, updated_at = NOW()
            WHERE id = :id
        ", [
            ':id' => $commentId,
            ':content' => $content
        ]);
    }

    public function getComments($articleId) {
        return $this->db->query("
            SELECT * FROM comments
            WHERE article_id = :article_id
            ORDER BY created_at ASC
        ", [
            ':article_id' => $articleId
        ])->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getComment($commentId) {
        return $this->db->query("
            SELECT * FROM comments
            WHERE id = :id
        ", [
            ':id' => $commentId
        ])->fetch(PDO::FETCH_ASSOC);
    }
}
