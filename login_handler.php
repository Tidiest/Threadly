<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $password = $_POST['pass'];
    $email = $_POST['email'];

    $errors = [];

    $user_verif = 'SELECT * FROM `users` WHERE `email`="'.$email.'";';

    $result = mysqli_query($conn, $user_verif);
    if ($result && mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password']))
        {
            $_SESSION['user_login'] = $user['login'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_surname'] = $user['surname'];
            $_SESSION['user_role'] = $user['role'];
            header('location:show_thread.php');
            exit;
        }
        else
        {
            $errors[] = "Invalid password";
        }
    }
    else
    {
        $errors[] = "User not found";
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["login_data"] = ['email' => $email];
        header('location:login.php');
        exit;
    }

}
?>