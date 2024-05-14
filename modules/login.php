<?php
include("components/navigation/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<?php
include("head.php");
?>

<body>
    <div class="page login-page">
        <div class="paper">
            <h2>Log In</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <input name="username" type="text" placeholder="Username" />
                <input name="password" type="password" placeholder="Password" />
                <input type="submit" value="Login" name="login" />
            </form>
        </div>
        <a href="?route=register">Register</a>
    </div>
</body>

</html>

<?php
include("database/connection.php");
function authenticate($conn)
{
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        echo "<script type='text/javascript'>alert('Username or password cannot be empty');</script>";
        return;
    }

    $sql = "SELECT * FROM USER WHERE USER_USERNAME = '{$username}';";
    try {
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['USER_PASSWORD'])) {
                $_SESSION['auth-token'] = "SECRET_TOKEN";
                $_SESSION['username'] = $username;
                echo '<script>window.location.href = window.location.pathname;</script>';
                return;
            } else {
                echo "<script type='text/javascript'>alert('Invalid username or password');</script>";
                return;
            }
        } else {
            echo "<script type='text/javascript'>alert('User not found');</script>";
            return;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        return;
    }
}

if (isset($_POST["login"])) {
    authenticate($conn);
}
?>