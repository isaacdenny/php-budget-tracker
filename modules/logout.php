<?php
session_start();
$_SESSION = [];
session_destroy();

echo '<script>window.location.href = window.location.pathname;</script>';
exit;
