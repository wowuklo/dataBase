<?php

namespace App\Models;

class UserModel
{


    public function __construct(private readonly string $filePath = 'dataBase/data/user.json')
    {

    }

    public function getUsers() : array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }

    public function saveUser(array $users): void
    {
        file_put_contents($this->filePath, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function addUser(array $user): void
    {
        $users = $this->getUsers();
        $user['id'] = count($users) + 1;
        $users[] = $user;
        $this->saveUser($users);
    }

    public function deleteUser(int $id): void
    {
        $users = $this->getUsers();
        foreach ($users as $key => $user) {
            if ($user['id'] == $id) {
                unset($users[$key]);
                break;
            }
        }
        $this->saveUser(array_values($users));
    }
}