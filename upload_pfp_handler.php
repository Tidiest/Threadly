<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!isset($_FILES['picture']))
    {
        $errors[] = 'Cannot upload an empty picture.';
        $_SESSION["errors"] = $errors;
        header('location:upload_pfp.php');
        die();
        mysqli_close($conn);
    }
    $user_login = $_SESSION['user_login'];

    $picture = $_FILES['picture'];
    $allowed_types = ['image/png', 'image/jpeg'];

    if ($picture['error'] != UPLOAD_ERR_OK)
    {
        die('Upload error: '.$picture['error']);
    }

    if (!in_array($picture['type'], $allowed_types))
    {
        $errors[] = 'Invalid image type. Only .png, .jpeg are allowed.';
    }

    $upload_dir = 'uploads/pfp/';

    if (!is_dir($upload_dir))
    {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = uniqid().'_'.basename($picture['name']);
    $file_path = $upload_dir.$file_name;

    if (move_uploaded_file($picture['tmp_name'], $file_path))
    {
        $upload_sql = 'UPDATE users SET pfp = "'.$file_name.'" WHERE login = "'.$user_login.'";';
        $result = mysqli_query($conn, $upload_sql);
        if($result)
        {
            header('location:show_thread.php');
        }
        else
        {
            $errors[] = 'Cannot upload the picture.';
        }
    }
    else
    {
        $errors[] = 'Cannot upload the picture.';
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        //header('location:upload_pfp.php');
        die();
        mysqli_close($conn);
    }
}
?>