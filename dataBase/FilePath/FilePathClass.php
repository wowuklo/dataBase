<?php

namespace App\FilePath;

class FilePathClass
{
    public  function __construct(private readonly string $filepath = '/../storage/user.json')
    {

    }

    public function getFilePath(): string
    {
        return $this->filepath;
    }
}