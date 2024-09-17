<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($email, $name, $dob, $password)
    {
        $query = $this->db->prepare("INSERT INTO users (email, name, dob, password, group_id) VALUES (:email, :name, :dob, :password, :group_id)");
        return $query->execute([
            'email' => $email,
            'name' => $name,
            'dob' => $dob,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'group_id' => 2, // Default user group
        ]);
    }

    public function login($email, $password)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['id'];
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    public function getUserData($userId)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute(['id' => $userId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

