<?php
class Tag
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllTags()
    {
        $query = $this->db->query("SELECT * FROM tasks_tags");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTagById($tagId)
    {
        $query = $this->db->prepare("SELECT * FROM tasks_tags WHERE id = :id");
        $query->execute(['id' => $tagId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>
