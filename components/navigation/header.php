<?php
$username = "";
$isLoggedIn = false;
if (isset($_SESSION["auth-token"])) {
    $username = $_SESSION["username"];
    $isLoggedIn = true;
}
?>

<header>
    <div class="nav-container">
        <nav>
            <?php
            if ($isLoggedIn) {
                echo "<h3>Welcome, {$username}!</h3> <ul>
                <li><a href='?route=home'>Dashboard</a></li>
                <li><a href='?route=profile'>Profile</a></li>
                <li><a href='?route=logout'>Log Out</a></li>
                </ul>";
            } else {
                echo "<h2>Welcome!</h2> <ul>
                <li><a href='?route=register'>Register</a></li>
                <li><a href='?route=login'>Login</a></li>
                </ul>";
            };
            ?>
        </nav>
    </div>
</header>