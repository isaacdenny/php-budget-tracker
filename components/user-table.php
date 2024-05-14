<?php
include("database/connection.php");
$sql = "SELECT * FROM USER;";
$users = mysqli_query($conn, $sql)
?>

<div class="paper">
    <h3>Program Users</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>USERNAME</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                echo "<tr><td>{$user['USER_ID']}</td><td>{$user['USER_USERNAME']}</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>