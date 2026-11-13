<?php
session_start();
require 'config.php';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['pass'];
    $email = $_POST['email'];
    $conf_password = $_POST['conf_pass'];
    $birthdate = $_POST['birthdate'];

    $errors = [];
    if(empty($name) || empty($surname) || empty($password) || empty($email) || empty($conf_password) || empty($birthdate))
    {
        $errors[] = 'Fields cannot be empty.';
    }
    if (!preg_match('/^[A-Za-z]+$/', $name))
    {
        $errors[] = 'First name must contain only letters.';
    }
    if (!preg_match('/^[A-Za-z]+$/', $surname))
    {
        $errors[] = 'Last name must contain only letters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $errors[] = 'Invalid email address.';
    }
    //BIRTHDATE validation
    $today = date("Y-m-d");
    $diff = date_diff(date_create($birthdate), date_create($today));
    
    if($diff->format('%y%') < 13)
    {
        $errors[] = "You are too young to register. Min age is 13 years.";
    }

    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{8,}$/';
    if (!preg_match($password_pattern, $password))
    {
        $errors[] = 'Password must contain at least one Upparcase letter, one lowercase letter, one number and one special character.';
    }
    if (strlen($password) < 8)
    {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($password != $conf_password)
    {
        $errors[] = "Passwords don't match!";
    }

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $check_existing_users = 'SELECT * FROM `users` WHERE `email`="'.$email.'";';
    $result = mysqli_query($conn, $check_existing_users);
    if ($result && mysqli_num_rows($result) > 0)
    {
        $errors[] = "Email already exists!";
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["form_data"] = ['name' => $name, 'surname' => $surname, 'email' => $email, 'birthdate' => $birthdate];
        header('Location:register.php');
        die();
    }
    

    $base_login = $name.$surname;
    $login = $base_login;

    $counter = 1;
    while(true)
    {
        $iftaken = 'SELECT * FROM `users` WHERE `login`="'.$login.'" ';
        $result = mysqli_query($conn, $iftaken);
        if (mysqli_num_rows($result) == 0)
        {
            break; //login is unique
        }
        else
        {
            $login = $base_login.$counter; //add number after login
        }
        $counter++;
    }

    $add_user = "INSERT INTO `users` (`login`, `name`, `surname`, `email`, `password`, `birth_date`) VALUES ('".$login."', '".$name."', '".$surname."', '".$email."', '".$hashed_pass."', '".$birthdate."');";
    if(mysqli_query($conn, $add_user))
    {
        header("Location:login.php");
    }
    else
    {
        die("Something went wrong!".mysqli_error($conn));
    }

}
?>