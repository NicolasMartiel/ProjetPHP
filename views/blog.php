<?php

require '../vendor/autoload.php';

use App\DbHandler;
use App\Schemas\Post;
use App\Schemas\Query;


// We want to display 12 articles per page
const BATCH_SIZE = 12;
$title = "Blog";
$page = $_GET["p"] ?? 1;

if ($page === '1') {
    header("Location: {$router->getRoute('Blog')}");
    http_response_code(301);
    exit();
} elseif (!filter_var($page, FILTER_VALIDATE_INT)) {
    throw new Exception("Invalid page");
} elseif ($page <=0) {
    throw new Exception("Invalid page");
}

$offset = BATCH_SIZE * ($page - 1);

// Display newest articles first.
$querystring = Query::QUERY_BLOG;
$parameters = [BATCH_SIZE, $offset];

$dbhandler = new DbHandler();

try {
    $rowNumber = $dbhandler->db_query(false, Post::class, Query::QUERY_BLOG_COUNT)[0];
    $posts = $dbhandler->db_query(true, Post::class, $querystring, $parameters);
} catch (PDOException $e) {
    echo $e;
}

$count = count($posts);

if ($count < BATCH_SIZE || $count * $page === $rowNumber) {
    $disabled = true;
}

?>
<div class="row align-items-baseline">
    <div class="col-auto me-auto">
        <h3 class='mb-4 p-0'>Posts</h3>
        
    </div>
    <div class="col-auto">
        <em><?= $rowNumber ?> Articles</em>
    </div>
    <hr class='mb-4'>
</div>
<?= Post::renderCards($posts, $router) ?>
<hr>
<div class="row mt-3">
    <div class="col-auto me-auto">
        <button class="btn btn-primary" <?= ($page - 1 > 0) ? "" : 'disabled' ?>>
            <a class='text-decoration-none text-light'
                href="./blog?p=<?= $page - 1 ?>">
                Previous Page
            </a>
        </button>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary" <?= isset($disabled) ? "disabled" : '' ?>>
            <a class="text-decoration-none text-light"
                href="./blog?p=<?= $page + 1 ?>">
                Next Page
            </a>
        </button>
    </div>
</div>

<br>