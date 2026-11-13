<?php
session_start();
session_destroy();
header("location:show_thread.php");
exit;
?>