<?php

namespace App\Models;

use App\Interface\DataSourceInterface;

use PDO;
class MySQLModel implements DataSourceInterface
{
    private  PDO $db;


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

    public function getDb(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveUser(array $user): void
    {
        if (isset($user['id'])) {
            $stmt = $this->db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE id = :id");
            $stmt->execute([
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'email' => $user['email'],
                'id' => $user['id'],
            ]);
        } else {
            $this->addUser($user);
        }
    }

    public function addUser(array $user): void
    {
        $stmt = $this->db->prepare("INSERT INTO users (firstName, lastName, email) VALUES (:firstName, :lastName, :email)");
        $stmt->execute($user);
    }

    public function deleteUser(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

}