<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $password = $_POST['pass'];
    $repassword = $_POST['repass'];
    $email = $_POST['email'];

    $errors = [];

    $user_verif = 'SELECT * FROM `users` WHERE `email`="'.$email.'";';

    $result = mysqli_query($conn, $user_verif);
    if ($result && mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);
        $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{8,}$/';
        if (!preg_match($password_pattern, $password))
        {
            $errors[] = 'Password must contain at least one Upparcase letter, one lowercase letter, one number and one special character.';
        }
        if (strlen($password) < 8)
        {
            $errors[] = 'Password must be at least 8 characters long.';
        }
    
        if ($password != $repassword)
        {
            $errors[] = "Passwords don't match!";
        }
    
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        $q = "UPDATE `users` SET `password` = '".$hashed_pass."' WHERE `login` = '".$user['login']."'; ";

        if(mysqli_query($conn, $q))
        {
            header("Location:show_thread.php");
        }
        else
        {
            die("Something went wrong!".mysqli_error($conn));
        }
    }
    else
    {
        $errors[] = "User not found";
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["change_data"] = ['email' => $email];
        header('location:change_password.php');
        exit;
    }

}
?>