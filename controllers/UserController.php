<?php

namespace controllers;

class UserController
{
    public function __construct(private $model)
    {

    }

    public function showUsers()
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

    public function addUser($firstName, $lastName, $email)
    {
        $user = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email
        ];
        $this->model->addUser($user);
        echo "Пользователь {$firstName} {$lastName} добавлен.\n";
    }

    public function deleteUser($id)
    {
        $this->model->deleteUser($id);
        echo "Пользователь с ID {$id} удален.\n";
    }
}