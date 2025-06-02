<?php 

namespace App\Administration;

use App\DbHandler;
use App\Schemas\Query;
use App\Schemas\User;

class Auth {

    public function authenticate(User $user, ?array $dbUser) {
        
        if (!$dbUser) {
            return false;
        } else if (password_verify($user->getPassword(),$dbUser[0]->getPassword())) {
            return true;
        }
    }

    public function getDbUser(string $username) {

        $dbhandler = new DbHandler();
        $dbUser = $dbhandler
                    ->db_query(
                        true,
                        User::class,
                        Query::QUERY_USER,
                        ["username"=> $username]
                    );
        return $dbUser;
    }

}