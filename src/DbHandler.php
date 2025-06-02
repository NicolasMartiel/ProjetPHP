<?php

namespace App;

use \PDO;

define('DBHOST', 'localhost');
define('DBUSER', 'blogadmin');
define('DBPASS', 'blogadminsuperstrongpass');
define('DBNAME', 'blog');

class DbHandler
{

    private PDO $pdo;

    public function __construct()
    {
        $pdo = new PDO(
            "mysql:host=" . DBHOST . ";
                   dbname=" . DBNAME,
            DBUSER,
            DBPASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        $this->pdo = $pdo;
    }
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param string $table_class Refers to the Class name that represents the table we want to format the fetched data from.     
     * Example : Post::class.
     * @param string $querystring The SQL query to run. May contain parameters specified with : or ?.
     * @param ?array $parameters Optional array that binds the parameters passed in the querystring to a value. 
     */
    public function db_query(bool $fetch_all ,string $table_class, string $querystring, ?array $parameters = null): array
    {
        $query = $this->pdo->prepare($querystring);
        $query->execute($parameters);
        return $fetch_all 
                    ? $query->fetchAll(PDO::FETCH_CLASS, $table_class)
                    : $query->fetch();
    }

    public function db_query_no_fetch(string $querystring, ?array $parameters=null): void
    {

        $query = $this->pdo->prepare($querystring);
        $query->execute($parameters);
    }
}
