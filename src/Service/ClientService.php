<?php

namespace App\Service;

use App\Entity\User;

class ClientService {
    public function addUser(array $data, User $user): void {
        dd($user);
    }
}