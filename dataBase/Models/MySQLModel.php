<?php

namespace App\Models;

use App\Interface\DataSourceInterface;
use PDO;
use PDOException;

class MySQLModel implements DataSourceInterface
{
    private PDO $db;

    public function __construct(
        private readonly string $host,
        private readonly string $dbName,
        private readonly string $user,
        private readonly string $password,
    ) {
        $dsn = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4";
        $this->db = new PDO($dsn, $this->user, $this->password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getUsers(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }

    public function addUser(array $user): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (firstName, lastName, email) VALUES (:firstName, :lastName, :email)");
            $stmt->execute($user);
            return true;
        } catch (PDOException $e) {
            error_log("Error adding user: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function saveUser(array $user): void
    {
        if (isset($user['id'])) {
            try {
                $stmt = $this->db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE id = :id");
                $stmt->execute([
                    'firstName' => $user['firstName'],
                    'lastName' => $user['lastName'],
                    'email' => $user['email'],
                    'id' => $user['id'],
                ]);
            } catch (PDOException $e) {
                error_log("Error updating user: " . $e->getMessage());
            }
        } else {
            $this->addUser($user);
        }
    }
}