<?php

use App\Administration\Auth;
use App\Schemas\User;

require '../vendor/autoload.php';

session_start();

$attempt_login_error = false;
$redirect = $router->getRoute('Admin');


//If the user is already connected, he shouldn't access the log in page.
if (isset($_SESSION['username'])) {

    header("Location:$redirect");
    exit();
}

if (isset($_POST["username"], $_POST["password"])) {
    $auth = new Auth();
    $newUser = new User();
    $newUser->setUsername($_POST["username"]);
    $newUser->setPassword($_POST["password"]);

    try {
        $dbUser = $auth->getDbUser($newUser->getUsername());
        $isAuthenticated = $auth->authenticate($newUser, $dbUser) ?? false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    //     [$isAuthenticated, $auth_message] = $auth->authenticate($newUser);

    if ($isAuthenticated) {

        $role = $dbUser[0]->getRole();

        $_SESSION["username"] = $newUser->getUsername();
        $_SESSION["role"] = $role;
        header("Location:$redirect");
        exit();
    }
    $attempt_login_error = true;
    $auth_message = "Incorrect username or password.";
}

?>
<div class="d-block text-center">
    <?php if ($attempt_login_error): ?>
        <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
            <?= $auth_message ?>
            <button type='button' class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <h4 class='mt-1'>Log in</h4>
    <form class='w-25 d-inline-block mx-auto text-start' method="post">
        <div class="from-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>

        <div class="from-group mt-2">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password" required>
        </div>

        <div class="d-flex justify-content-center">
            <button class='btn btn-primary mt-4' type="submit">Login</button>
        </div>
    </form>
</div>