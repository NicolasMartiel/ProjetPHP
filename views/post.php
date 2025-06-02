<?php

use App\DbHandler;
use App\Schemas\Post;
use App\Schemas\Query;

$id = explode("-", $_SERVER["REQUEST_URI"])[1];

$dbhandler = new DbHandler();
$post = $dbhandler->db_query(true, Post::class, Query::QUERY_FMT_CARD_POST, ["id" => $id])[0];
?>


<div class="row align-items-baseline">
    <div class="col-auto me-auto">
        <h2><?= $post->getTitle() ?></h2>
    </div>
    <div class="col-auto">
        <em><?= 'Created on ' .  $post->getDate() ?></em>
    </div>
    <hr>
    <p><?= $post->getContent() ?></p>
</div>