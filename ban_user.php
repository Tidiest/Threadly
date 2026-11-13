<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$login = $_GET['user'] ?? '';

if ($_SESSION['user_login'] != 'admin')
{
    header("location:show_thread.php");
    exit;
}

$check_user_exists = "SELECT * FROM users WHERE `login` = '".$login."' LIMIT 1;";
$result = mysqli_query($conn, $check_user_exists);

if (mysqli_num_rows($result) > 0)
{
    $delete_user = "DELETE FROM users WHERE `login` = '".$login."';";

    $result = mysqli_query($conn, $delete_user);
    if ($result)
    {
        header('location:manage_users.php');
        mysqli_close($conn);
    }
    else
    {
        die("Cannot delete the user. ".mysqli_error($conn));
        mysqli_close($conn);
    }
}
header('location:admin_panel.php');
exit;

?>