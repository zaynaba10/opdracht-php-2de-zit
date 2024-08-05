<?php

class TaskList
{
    private $id;
    private $name;
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name)) {
            throw new Exception('List name cannot be empty.');
        }
        $this->name = $name;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public static function create($pdo, $user_id, $name)
    {
        $stmt = $pdo->prepare('INSERT INTO lists (user_id, name) VALUES (:user_id, :name)');
        if (!$stmt->execute(['user_id' => $user_id, 'name' => $name])) {
            throw new Exception('An error occurred while creating the list.');
        }
        return true;
    }

    public static function delete($pdo, $id)
    {
        $stmt = $pdo->prepare('DELETE FROM lists WHERE id = :id');
        if (!$stmt->execute(['id' => $id])) {
            throw new Exception('An error occurred while deleting the list.');
        }
        return true;
    }

    public static function getAll($pdo)
    {
        $stmt = $pdo->query('SELECT * FROM lists ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __construct($name = null)
    {
        $this->setName($name);
    }
}
?>