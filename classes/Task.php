<?php
class Task
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTasksByUser($userId, $sortColumn = 'created_at', $sortOrder = 'DESC', $searchQuery = '')
    {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";

        if (!empty($searchQuery)) {
            $sql .= " AND (title LIKE :query OR description LIKE :query)";
        }

        $sql .= " ORDER BY $sortColumn $sortOrder";
        $query = $this->db->prepare($sql);

        if (!empty($searchQuery)) {
            $query->execute(['user_id' => $userId, 'query' => "%$searchQuery%"]);
        } else {
            $query->execute(['user_id' => $userId]);
        }

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTask($title, $description, $userId, $tagId = 3)
    {
        $query = $this->db->prepare("INSERT INTO tasks (title, description, tag_id, user_id) VALUES (:title, :description, :tag_id, :user_id)");
        return $query->execute([
            'title' => $title,
            'description' => $description,
            'tag_id' => $tagId,
            'user_id' => $userId
        ]);
    }

    public function updateTask($taskId, $title, $description)
    {
        $query = $this->db->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id");
        return $query->execute([
            'title' => $title,
            'description' => $description,
            'id' => $taskId
        ]);
    }

    public function deleteTask($taskId)
    {
        $query = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        return $query->execute(['id' => $taskId]);
    }

    public function changeTaskTag($taskId, $tagId)
    {
        $query = $this->db->prepare("UPDATE tasks SET tag_id = :tag_id WHERE id = :id");
        return $query->execute(['tag_id' => $tagId, 'id' => $taskId]);
    }

    public function deleteAllTasksByUser($userId)
    {
        $query = $this->db->prepare("DELETE FROM tasks WHERE user_id = :user_id");
        return $query->execute(['user_id' => $userId]);
    }
	
   public function getTaskById($taskId, $userId)
{
    $query = $this->db->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
    $query->execute(['id' => $taskId, 'user_id' => $userId]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

}
