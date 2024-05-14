<?php
function post_new_log($conn)
{
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);
    $cost = filter_input(INPUT_POST, "cost", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT);
    $income = isset($_POST["income"]) ? 1 : 0; // Correctly check if income is set

    $date = date_create($date);
    $date = date_format($date, "Y-m-d H:i:s");

    // Prepare the statement to prevent SQL injection
    $sql = "INSERT INTO LOG (LOG_DESCRIPTION, LOG_TRANS_DATE, LOG_COST, CAT_ID, LOG_IS_INCOME) VALUES (?, ?, ?, ?, ?)";

    try {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdii', $description, $date, $cost, $category, $income);
        mysqli_stmt_execute($stmt);

        $rowsAffected = mysqli_stmt_affected_rows($stmt);

        if ($rowsAffected > 0) {
            echo "Inserted new log";
        } else {
            echo "Failed to insert new log";
        }

        mysqli_stmt_close($stmt);
        echo '<script>window.location.href = window.location.pathname;</script>';
        exit();
    } catch (mysqli_sql_exception $e) {
        echo "Error executing query: " . $e->getMessage();
    }
}

if (isset($_POST["submit"])) {
    post_new_log($conn);
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("new-log").reset();
    });
</script>
<div class="paper">
    <h3>New Log</h3>
    <form id="new-log" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <input type="text" name="description" placeholder="Description" />
        <input type="date" name="date" />
        <input type="number" step=0.01 name="cost" placeholder="Cost" />
        <select name="category">
            <?php
            function get_categories($conn)
            {
                $sql = "SELECT CAT_ID, CAT_NAME FROM CATEGORY;";
                try {
                    $result = mysqli_query($conn, $sql);
                    foreach ($result as $row) {
                        $id = $row["CAT_ID"];
                        $name = $row["CAT_NAME"];
                        echo "<option key={$id} value={$id}>{$name}</option>";
                    }
                } catch (mysqli_sql_exception) {
                    echo "Error executing query";
                }
            }
            get_categories($conn);
            ?>
        </select>
        <label>Income
            <input name="income" type="checkbox" />
        </label>
        <input name="submit" type="submit" value="Add" />
    </form>
</div>