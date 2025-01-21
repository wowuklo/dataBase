<?php

namespace App\Controllers;

class UserController
{
    public function __construct(private $model)
    {

    }

    public function showUsers() : void
    {
        $users = $this->model->getUsers();
        if (empty($users))
        {
            echo "No users found. \n";
            return;
        }
        foreach ($users as $user)
        {
            echo "ID: {$user['id']}, Имя: {$user['firstName']}, Фамилия: {$user['lastName']}, Email: {$user['email']}\n";
        }
    }

    public function addUser(string $firstName,string $lastName,string $email) : void
    {
        $user = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email
        ];
        $this->model->addUser($user);
        echo "Пользователь {$firstName} {$lastName} добавлен.\n";
    }

    public function deleteUser(string $id) : void
    {
        $this->model->deleteUser($id);
        echo "Пользователь с ID {$id} удален.\n";
    }
}