<?php
session_start();
$modules = [
    "" => "modules/home.php",
    "home" => "modules/home.php",
    "register" => "modules/register.php",
    "login" => "modules/login.php",
    "logout" => "modules/logout.php",
    "budget-view" => "modules/budget-view.php",
    "404" => "modules/404.php"
];

if (!isset($_SESSION["auth-token"])) {
    if (isset($_GET["route"]) && in_array($_GET["route"], ["login", "register"])) {
        include($modules[$_GET["route"]]);
        exit;
    } else {
        include($modules["login"]);
        exit;
    }
}

// If logged in, continue with routing
if (isset($_GET["route"])) {
    $route = $_GET["route"];
    if (array_key_exists($route, $modules)) {
        include($modules[$route]);
    } else {
        include($modules["404"]);
    }
} else {
    include($modules["home"]);
}
