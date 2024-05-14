<?php
include("database/connection.php");
$sql = "SELECT * FROM CATEGORY;";
$categories = mysqli_query($conn, $sql)
?>

<div class="paper">
    <h3>Program Categories</h3>
    <table>
        <thead>
            <tr>
                <th>NAME</th>
                <th>DESCRIPTION</th>
                <th>BUDGET AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($categories as $cat) {
                echo "<tr>
                <td>{$cat['CAT_NAME']}</td>
                <td>{$cat['CAT_DESCRIPTION']}</td>
                <td>{$cat['CAT_BUDGET_AMT']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>