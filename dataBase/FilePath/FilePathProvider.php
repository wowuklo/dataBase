<?php

namespace App\FilePath;

class FilePathProvider
{
    public  function __construct(private readonly string $filepath = __DIR__ . '/../storage/user.json')
    {

    }

    public function getFilePath(): string
    {
        return $this->filepath;
    }
}