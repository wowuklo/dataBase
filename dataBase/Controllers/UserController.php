<?php

namespace App\Controllers;

use App\Interface\DataSourceInterface;


class UserController
{
    public function __construct(private readonly DataSourceInterface $model)
    {
    }

    public function showUsers(): void
    {
        $users = $this->model->getUsers();
        if (empty($users)) {
            echo json_encode(['status' => 'success', 'message' => 'No users found.', 'data' => []]);
            return;
        }
        echo json_encode(['status' => 'success', 'data' => $users]);
    }

    public function addUser(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid JSON']);
            return;
        }

        $result = $this->model->addUser($data);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'User created']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create user']);
        }
    }

    public function deleteUser(int $id): void
    {
        $result = $this->model->deleteUser($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    }
}