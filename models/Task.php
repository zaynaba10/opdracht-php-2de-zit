<?php

class Task {
    private $id;
    private $list_id;
    private $title;
    private $deadline;
    private $is_done;
    private $created_at;

    public function getId() {
        return $this->id;
    }

    public function getListId() {
        return $this->list_id;
    }

    public function setListId($list_id) {
        $this->list_id = $list_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception('Task title cannot be empty.');
        }
        $this->title = $title;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function setDeadline($deadline) {
        $this->deadline = $deadline;
    }

    public function getIsDone() {
        return $this->is_done;
    }

    public function setIsDone($is_done) {
        $this->is_done = $is_done;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public static function create($pdo, $list_id, $title, $deadline) {
        $stmt = $pdo->prepare('INSERT INTO tasks (list_id, title, deadline) VALUES (:list_id, :title, :deadline)');
        if (!$stmt->execute(['list_id' => $list_id, 'title' => $title, 'deadline' => $deadline])) {
            throw new Exception('An error occurred while creating the task.');
        }
        return true;
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
        if (!$stmt->execute(['id' => $id])) {
            throw new Exception('An error occurred while deleting the task.');
        }
        return true;
    }

    public static function markAsDone($pdo, $id, $is_done) {
        $stmt = $pdo->prepare('UPDATE tasks SET is_done = :is_done WHERE id = :id');
        if (!$stmt->execute(['is_done' => $is_done, 'id' => $id])) {
            throw new Exception('An error occurred while updating the task.');
        }
        return true;
    }

    public static function getAllByList($pdo, $list_id) {
        $stmt = $pdo->prepare('SELECT * FROM tasks WHERE list_id = :list_id ORDER BY deadline ASC');
        $stmt->execute(['list_id' => $list_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __construct($list_id = null, $title = null, $deadline = null, $is_done = 0) {
        $this->setListId($list_id);
        $this->setTitle($title);
        $this->setDeadline($deadline);
        $this->setIsDone($is_done);
    }
}
?>
