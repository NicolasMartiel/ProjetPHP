<?php

namespace App\Schemas;

class User
{

    private int $id;
    private string $username;
    private string $password;
    private string $role;

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setUsername(string $newUsername)
    {
        $this->username = $newUsername;
    }

    public function setPassword(string $newPassword)
    {
        $this->password = $newPassword;
    }
}
