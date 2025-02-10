<?php

namespace App\Interface;
interface DataSourceInterface
{
    public function getUsers() : array;
    public function saveUser(array $user) : void;
    public function addUser(array $user) : void;
    public function deleteUser(int $id) : void;
}