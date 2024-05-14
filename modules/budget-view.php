<?php
include("components/navigation/header.php");
include("database/connection.php");

$month = isset($_GET["month"]) ? $_GET["month"] : idate("m");
$year = isset($_GET["year"]) ? $_GET["year"] : idate("Y");
$san_month = filter_var($month, FILTER_SANITIZE_NUMBER_INT);
$san_year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
if (filter_var($san_month, FILTER_VALIDATE_INT) === false || filter_var($san_year, FILTER_VALIDATE_INT) === false) {
    include("404.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
include("head.php");
?>

<body>
    <div class="page">
        <h1>
            Budget View <?php if (isset($san_month) && isset($san_year)) echo "{$san_month}/{$san_year}" ?>
        </h1>
        <?php include("components/available-months.php"); ?>
        <div style="display: grid; grid-template-columns: auto auto; gap: 1rem;">
            <div class="paper">
                <?php
                function get_sql_data($conn, $month, $year)
                {
                    $sql = "SELECT
                    (SELECT ROUND(SUM(LOG_COST), 2) FROM LOG 
                            WHERE YEAR(LOG_TRANS_DATE) = {$year}
                            AND MONTH(LOG_TRANS_DATE) = {$month} 
                            AND LOG_IS_INCOME = 0) 
                            AS ACTUAL_COST,
                    (SELECT ROUND(SUM(LOG_COST), 2) FROM LOG 
                            WHERE YEAR(LOG_TRANS_DATE) = {$year} 
                            AND MONTH(LOG_TRANS_DATE) = {$month}
                            AND LOG_IS_INCOME = 1) 
                            AS ACTUAL_INCOME,
                    (SELECT ROUND(SUM(CAT_BUDGET_AMT), 2) FROM CATEGORY WHERE CAT_IS_INCOME = 0) AS EXPECTED_COST,
                    (SELECT ROUND(SUM(CAT_BUDGET_AMT), 2) FROM CATEGORY WHERE CAT_IS_INCOME = 1) AS EXPECTED_INCOME;";
                    $result = null;
                    try {
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_assoc($result);
                        if ($data) {
                            $ec = $data['EXPECTED_COST'];
                            $ac = $data['ACTUAL_COST'];
                            $ei = $data['EXPECTED_INCOME'];
                            $ai = $data['ACTUAL_INCOME'];
                            $id = $ai - $ei;
                            $cd = $ec - $ac;
                            echo  "<p>EXPECTED COST: {$ec}</p>";
                            echo  "<p>ACTUAL COST: {$ac}</p>";
                            echo  "<p>COST DIFF: {$cd}</p>";
                            echo  "<p>EXPECTED INCOME: {$ei}</p>";
                            echo  "<p>ACTUAL_INCOME: {$ai}</p>";
                            echo  "<p>INCOME DIFF: {$id}</p>";
                        } else {
                            echo "No data found for the specified month and year.";
                        }
                    } catch (mysqli_sql_exception) {
                        echo "Error executing query";
                    }
                }

                get_sql_data($conn, $san_month, $san_year);
                ?>
            </div>
            <?php include("components/monthly-view.php"); ?>
            <div class="paper">
                <table>
                    <thead>
                        <tr>
                            <th>DESCRIPTION</th>
                            <th>COST</th>
                            <th>TRANSACTION DATE</th>
                            <th>CATEGORY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function get_sql_data2($conn, $month, $year)
                        {
                            $sql = "SELECT * 
                                    FROM LOG NATURAL JOIN CATEGORY 
                                    WHERE YEAR(LOG_TRANS_DATE) = {$year} 
                                    AND MONTH(LOG_TRANS_DATE) = {$month} 
                                    ORDER BY LOG_TRANS_DATE;";
                            try {
                                $result = mysqli_query($conn, $sql);
                                foreach ($result as $log) {
                                    echo "<tr name='log' ariaLabel={$log['LOG_NUM']} key={$log['LOG_NUM']}>
                                          <td>{$log['LOG_DESCRIPTION']}</td>
                                          <td>{$log['LOG_COST']}</td>
                                          <td>{$log['LOG_TRANS_DATE']}</td>
                                          <td>{$log['CAT_NAME']}</td>
                                          </tr>";
                                }
                            } catch (mysqli_sql_exception) {
                                echo "Error executing query";
                            }
                        }
                        get_sql_data2($conn, $san_month, $san_year);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>