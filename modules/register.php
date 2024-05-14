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
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <label>Username</label>
                <input name="username" type="text" />
                <label>Password</label>
                <input name="password" type="password" />
                <input type="submit" value="Register" name="register" />
            </form>
        </div>
    </div>
</body>

</html>

<?php
include("database/connection.php");
$username = "";
$password = "";
if (isset($_POST["register"])) {

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    if (empty($username) || empty($password)) {
        echo "Username or password cannot be empty";
        return;
    }
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO USER (USER_USERNAME, USER_PASSWORD) VALUES ('{$username}','{$hashed_pass}');";
    try {
        $result = mysqli_query($conn, $sql);
        echo $result;
    } catch (mysqli_sql_exception) {
        echo "Error registering user";
    }
}

?>