<?php


$uri = $_SERVER["REQUEST_URI"];
$nav_title = str_contains($uri,"blog") ? "Cool Website" : "Administration";
$nav_items = [
    "Blog" => $router->generate("Blog"),
    "Categories" => $router->generate("Categories"),
    // "Administration" => $router->generate("Admin"),
    // "Login" => $router->generate("LoginGet")
];

// if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
//     $nav_items["Admin"] = $router->generate("Admin");
// }

?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Blog' ?></title>
    <link type="text/css" rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="h-100 d-flex flex-column">
    <nav class="navbar navbar-expand-sm bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $nav_title==="Administration" ? "" : "/blog" ?>"><?= $nav_title ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php foreach($nav_items as $label => $route): ?>
                        <li class="nav-item">
                            <a href="<?= $route ?>" class="nav-link <?= $uri === $route || (str_contains($uri,$route) && str_contains($uri,"?")) ? 'active' : '' ?>">
                                <?= $label ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="text-center bg-light py-4 mt-auto footer">
        Page generated in <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>