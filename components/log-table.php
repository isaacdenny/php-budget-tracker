<?php
include("database/connection.php");
$sql = "SELECT LOG_NUM, LOG_DESCRIPTION, LOG_COST, LOG_TRANS_DATE, CAT_NAME FROM LOG NATURAL JOIN CATEGORY WHERE MONTH(LOG_TRANS_DATE) = MONTH(CURRENT_TIMESTAMP);";
try {
    $logs = mysqli_query($conn, $sql);
} catch (mysqli_sql_exception) {
    echo "Error executing query";
}
?>

<div class="paper">
    <!-- <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', init, false);

        function init() {
            const rows = document.getElementsByName("log");
            console.log(rows)
            rows.forEach((row) => row.addEventListener("click", function() {
                console.log(row.attributes.key.value)
                window.location.href = `/logs/log.php?LOG_NUM=${row.attributes.key.value}`;
            }));
        }
    </script> -->
    <h3>Recent Expenses</h3>
    <table>
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>COST</th>
                <th>DATE</th>
                <th>CATEGORY</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($logs as $log) {
                echo "<tr name='log' ariaLabel={$log['LOG_NUM']} key={$log['LOG_NUM']}>
                <td>{$log['LOG_DESCRIPTION']}</td>
                <td>{$log['LOG_COST']}</td>
                <td>{$log['LOG_TRANS_DATE']}</td>
                <td>{$log['CAT_NAME']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>