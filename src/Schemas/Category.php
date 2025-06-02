<?php

namespace App\Schemas;

class Category {

    private int $id;
    private string $name;
    private string $slug;

    public function getName(): string
    {
        return $this->name;
    }
}