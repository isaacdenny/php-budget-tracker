<?php
$result = "";
include("database/connection.php");
$sql = "SELECT MONTH(LOG_TRANS_DATE) AS MONTH, 
            YEAR(LOG_TRANS_DATE) AS YEAR 
            FROM LOG 
            GROUP BY MONTH(LOG_TRANS_DATE), YEAR(LOG_TRANS_DATE) 
            ORDER BY LOG_TRANS_DATE;";
try {
    $result = mysqli_query($conn, $sql);
} catch (mysqli_sql_exception) {
    echo "Error executing query";
}
?>

<div>
    <ul class="months-list">
        <?php
        $i = 0;
        foreach ($result as $row) {
            $i++;
            $month = $row["MONTH"];
            $year = $row["YEAR"];
            echo "<li key='{$month}/{$year}'>
                        <a href='?month={$month}&year={$year}'>{$month}/{$year}</a>  
                      </li>";
        }
        ?>
    </ul>
</div>