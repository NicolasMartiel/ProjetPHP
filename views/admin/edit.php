<?php

use App\DbHandler;
use App\Router;
use App\Schemas\Post;
use App\Schemas\Query;

/** @var Router $router */

$id = (int)explode('-', $_SERVER["REQUEST_URI"])[1];
$dbhandler = new DbHandler();
$success_msg = "Post edited successfully";
$gobackbtn = "Cancel";

if (isset($_POST["title"], $_POST["content"])) {
    try {

        $params = ["title" => $_POST["title"], "content" => $_POST["content"], "id" => $id];
        $dbhandler->db_query_no_fetch(Query::QUERY_POST_EDIT, $params);
        $success = true;
        $gobackbtn = "Go Back";
        $btnPrimary = true;
    } catch (PDOException $e) {
        $err = "An error occured while trying to update the database: " . $e->getMessage();
    }
}

/** @var Post $post */
$post = $dbhandler->db_query(true, Post::class, Query::QUERY_FMT_CARD_POST, ["id" => $id])[0];


?>
<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <div class="">
            <?= $success_msg ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (isset($err)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <div class="">
            <?= $err ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>


<h2>Edit post</h2>
<form action="" method="post" class="mt-4">
    <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" type="text" id="title" name="title" value="<?= htmlentities($post->getTitle()) ?>">
    </div>

    <div class="form-group mt-4">
        <label for="content">Content</label>
        <textarea class="form-control" type="text" id="content" name="content"><?= htmlentities($post->getContent()) ?></textarea>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button class="btn btn-success" type="submit">Confirm changes</button>
        <a class="btn <?= isset($btnPrimary) ? 'btn-primary' : 'btn-danger' ?>" href="<?= $router->getRoute("Admin") ?>"><?= $gobackbtn ?></a>
    </div>
</form>