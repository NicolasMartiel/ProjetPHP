<?php
require 'vendor/autoload.php';

use App\DbHandler;
use App\Schemas\Post;
use App\Schemas\User;

try {
    $dbhandler = new DbHandler();
    $table = User::class;
    $content = "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi esse, cumque odit odio inventore exercitationem obcaecati nostrum laborum ab itaque excepturi facilis debitis, non ea ducimus fugiat. Ab, nostrum placeat!";

    // for ($i = 32; $i < 62; $i++) {
        // $querystring = "INSERT INTO post (title,slug,content,created_at) VALUES (?, ?, ?, NOW())";
        // $dbhandler->db_query_no_fetch("DELETE FROM post");
        // $querystring = "INSERT INTO post_category (post_id,category_id) VALUES (113,2)";
        // $dbhandler->db_query_no_fetch($querystring);
    // }

    $user1 = "user";
    $pass1 = password_hash($user1,PASSWORD_BCRYPT);
    $user2 = "admin";
    $pass2 = password_hash($user2,PASSWORD_BCRYPT);
    // $dbhandler->db_query_no_fetch("ALTER TABLE user add role varchar(255)");
    $dbhandler->db_query_no_fetch("DELETE FROM user");
    $dbhandler->db_query_no_fetch("INSERT INTO user (username,password,role) VALUES (?,?,?)",[$user1,$pass1,"user"]);
    $dbhandler->db_query_no_fetch("INSERT INTO user (username,password,role) VALUES (?,?,?)",[$user2,$pass2,"admin"]);
} catch (PDOException $e) {
    echo $e->getMessage();
}
