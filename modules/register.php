<?php
include("components/navigation/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<?php
include("head.php");
?>

<body>
    <div class="page">
        <div class="paper">
            <h2>Register</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?route=register" ?>" method="POST">
                <input name="username" type="text" placeholder="Username" />
                <input name="password" type="password" placeholder="Password" />
                <input type="submit" value="Register" name="register" />
            </form>
        </div>
        <a href="?route=login">Login</a>
    </div>
</body>

</html>

<?php
include("database/connection.php");

function register_user($conn)
{
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        echo "Username or password cannot be empty";
        return;
    }
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO USER (USER_USERNAME, USER_PASSWORD) VALUES ('{$username}', '{$hashed_pass}');";
    try {
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script type='text/javascript'>alert('Successfully Registered');</script>";
            echo '<script>window.location.href = window.location.pathname;</script>';
        } else {
            echo "<script type='text/javascript'>alert('Failed to register new user');</script>";
        }
    } catch (mysqli_sql_exception) {
        echo "Error registering user";
    }
}
if (isset($_POST["register"])) {
    register_user($conn);
}
?>