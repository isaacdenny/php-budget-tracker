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
        <h3>Denny Family</h3>
        <h1>Budget Tracker: In PHP!</h1>
        <?php
        include("components/available-months.php");
        ?>
        <div style="display: grid; grid-template-columns: auto auto; gap: 1rem;">
            <?php
            include("components/user-table.php");
            include("components/monthly-view.php");
            include("components/log-table.php");
            include("components/category-table.php");
            include("components/new-log.php");
            ?>
        </div>
    </div>
</body>

</html>