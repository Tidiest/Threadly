<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if (isset($_SESSION['user_login']))
{
    $user_login = $_SESSION['user_login'];
}
else
{
    $user_login = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = trim($_POST['name']);
    $url_name = trim($_POST['url_name']);
    $url_name = str_replace("\r\n","\n", $url_name);
    $name = str_replace("\r\n","\n", $name);

    $name = str_replace("\n", '', $name);
    $name_no_whitespace = str_replace(["\r", " "], '', $name);
    $url_name = str_replace(["\r", "\n", " "], '', $url_name);

    $errors = [];

    if (empty($name_no_whitespace) || empty($url_name))
    {
        $errors[] = "Fields cannot be empty or consist only of whitespaces.";
    }

    if (strlen($name) > 50)
    {
        $errors[] = 'Name is too long.';
    }

    if (strlen($url_name) > 30)
    {
        $errors[] = 'Url Name is too long.';
    }

    if (!preg_match('/^[A-Za-z]+$/', $name))
    {
        $errors[] = 'Name can only contain letters.';
    }

    if (!preg_match('/^[A-Za-z]+$/', $url_name))
    {
        $errors[] = 'Url Name can only contain letters.';
    }

    $check_existing_category = 'SELECT * FROM `category` WHERE `url_name` = "'.htmlspecialchars($url_name).'" OR `name` = "'.htmlspecialchars($name).'"';
    $existing_category = mysqli_query($conn, $check_existing_category);
    $existing_category = mysqli_fetch_all($existing_category, MYSQLI_ASSOC);

    if (count($existing_category) > 0)
    {
        $errors[] = 'Category with the same name or URL name already exists.';
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["category_data"] = ['name' => $name, 'url_name' => $url_name];
        header('Location:add_category.php');
        die();
        mysqli_close($conn);
    }
    
    $create_category = "INSERT INTO `category`(`url_name`, `name`) VALUES ('".htmlspecialchars($url_name)."','".htmlspecialchars($name)."')";
    $result = mysqli_query($conn, $create_category);
    if ($result)
    {
        header('location:change_category.php');
        mysqli_close($conn);
    }
    else
    {
        die("Cannot make a category. ".mysqli_error($conn));
        mysqli_close($conn);
    }

}
?>