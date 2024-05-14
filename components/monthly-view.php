<?php
include("database/connection.php");
?>

<div class="paper">
    <h3>Monthly Budget</h3>
    <table>
        <thead>
            <tr>
                <th>CATEGORY</th>
                <th style='text-align:right;'>EXPECTED COST</th>
                <th style='text-align:right;'>TOTAL COST</th>
                <th style='text-align:right;'>COST DIFFERENCE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function get_monthly_view($conn)
            {
                $month = isset($_GET["month"]) ? $_GET["month"] : idate("m");
                $year = isset($_GET["year"]) ? $_GET["year"] : idate("Y");
                $san_month = filter_var($month, FILTER_SANITIZE_NUMBER_INT);
                $san_year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
                if (filter_var($san_month, FILTER_VALIDATE_INT) === false || filter_var($san_year, FILTER_VALIDATE_INT) === false) {
                    include("404.php");
                    exit;
                }

                $sql = "SELECT CAT_NAME,
                        ROUND(CAT_BUDGET_AMT, 2) AS EXPECTED_COST,
                        ROUND(SUM(LOG_COST), 2) AS ACTUAL_COST,
                        ROUND((CAT_BUDGET_AMT - SUM(LOG_COST)), 2) AS COST_DIFFERENCE
                        FROM LOG NATURAL JOIN CATEGORY
                        WHERE YEAR(LOG_TRANS_DATE) = {$year}
                        AND MONTH(LOG_TRANS_DATE) = {$month}
                        AND LOG_IS_INCOME = 0
                        GROUP BY CAT_NAME;";
                try {

                    $categories = mysqli_query($conn, $sql);
                    foreach ($categories as $row) {
                        $cd = $row['COST_DIFFERENCE'];
                        $cd_class = $cd < 0 ? "negative" : "positive";
                        echo "<tr name='log' key={$row['CAT_NAME']}>
                        <td>{$row['CAT_NAME']}</td>
                        <td style='text-align:right;'>{$row['EXPECTED_COST']}</td>
                        <td style='text-align:right;'>{$row['ACTUAL_COST']}</td>
                        <td style='text-align:right;'><strong class={$cd_class}>{$cd}</strong></td>
                        </tr>";
                    }
                } catch (mysqli_sql_exception) {
                    echo "Error executing query";
                }
            }
            get_monthly_view($conn);
            ?>
        </tbody>
    </table>
</div>