<?php
session_start();
unset($_SESSION['nick']);
session_write_close();
session_destroy();
header("Location:index.php");
?>