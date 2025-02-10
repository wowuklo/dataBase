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