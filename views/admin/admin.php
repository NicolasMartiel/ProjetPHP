<?php

use App\DbHandler;
use App\Router;
use App\Schemas\Post;
use App\Schemas\Query;

session_start();

/** @var Router $router */
$redirect_login = $router->getRoute("LoginGet");
$redirect_logout = $router->getRoute("Logout");

if (!isset($_SESSION["username"])) {
    header("Location:$redirect_login");
    exit();
} else if ($_SESSION["role"] !== "admin") {
    $unauthorized = true;
}

$dbhandler = new DbHandler();


if (isset($_POST["deletePost"])) {

    $dbhandler->db_query_no_fetch(Query::QUERY_POST_DELETE, ["id" => $_POST["deletePost"]]);
}

$posts = $dbhandler->db_query(true, Post::class, Query::QUERY_POSTS_ADMIN)

?>
<?php if (isset($unauthorized)): ?>

    <div class="text-center d-flex flex-column">
        <strong>Unauthorized.</strong>
        <a href="<?= $redirect_logout ?>" class="btn btn-primary mt-2">Log out</a>
    </div>
<?php else: ?>
    <div class="">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Creation&nbsp;date</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <?php $modal_id = $post->getId() ?>
                    <tr class="table-secondary">
                        <th scope="row"><?= htmlentities($post->getId()) ?></th>
                        <th scope="row"><?= htmlentities($post->getTitle()) ?></th>
                        <th scope="row"><?= htmlentities($post->getExcerpt($post->getContent())) ?></th>
                        <th scope="row"><?= htmlentities($post->getCategories()) ?></th>
                        <th scope="row"><?= htmlentities($post->getDate()) ?></th>
                        <th scope="row"><a href="<?= $router->getRoute("EditGet", ["id" => $post->getId()]) ?>" class="btn btn-primary">Edit</a></th>
                        <th scope="row">
                            <button class="btn btn-danger" type="submit" data-bs-toggle="modal" data-bs-target=<?= "#$modal_id" ?>>Delete</button>
                        </th>
                    </tr>
                    <!------------------------------------------------------- Modal ----------------------------------------------------------->
                    <!-- Putting it here so we can keep track of which post we want to delete -->
                    <div class="modal fade" id=<?= $modal_id ?> tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Do you want to delete the post "<?= htmlentities($post->getTitle()) ?>" ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="" method="post">
                                        <input type="text" name="deletePost" hidden value="<?=  $post->getId() ?>">
                                        <button type="submit" class="btn btn-success">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!------------------------------------------------------------------------------------------------------------------------->
                <?php endforeach ?>
                <tr class="table-secondary">
                    <td colspan="7"><a href="" class="btn btn-primary">&#43;</a></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif ?>