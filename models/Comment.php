<?php

class Comment
{
    private $id;
    private $task_id;
    private $content;
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getTaskId()
    {
        return $this->task_id;
    }

    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        if (empty($content)) {
            throw new Exception('Comment content cannot be empty.');
        }
        $this->content = $content;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public static function create($pdo, $task_id, $content)
    {
        if (empty($content)) {
            throw new Exception('the given comment is empty, please fill in the title of the comment.');
        }
        $stmt = $pdo->prepare('INSERT INTO comments (task_id, content) VALUES (:task_id, :content)');
        if (!$stmt->execute(['task_id' => $task_id, 'content' => $content])) {
            throw new Exception('An error occurred while creating the comment.');
        }
        return true;
    }

    public static function getAllByTask($pdo, $task_id)
    {
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE task_id = :task_id ORDER BY created_at DESC');
        $stmt->execute(['task_id' => $task_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __construct($task_id = null, $content = null)
    {
        $this->setTaskId($task_id);
        $this->setContent($content);
    }
}
?>