<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user_login = $_SESSION['user_login'];

    $description = trim($_POST['desc']); //remove all of the leading whitespaces
    $description = str_replace("\r\n","\n", $description); //replace php new line with new line

    $no_whitespace_description_check = str_replace(["\n","\r"," "],'', $description);//count the total number of characters without whitespace

    $errors = [];

    if (empty($no_whitespace_description_check))
    {
        $errors[] = "Description cannot be empty or consist only of whitespaces.";
    }

    $newlines_in_description = substr_count($description, "\n"); // count the number of new lines in the description

    if ($newlines_in_description > 1)
    {
        $errors[] = "Description has too many newlines.";
    }

    $whitespaces_in_description = substr_count($description, "\r") + substr_count($description, "\n") + substr_count($description, " "); // count the number of new lines in the description

    if ($whitespaces_in_description > strlen($description) / 2)
    {
        $errors[] = "Description has too many whitespaces.";
    }

    if (strlen($description) > 100)
    {
        $errors[] = 'Description is too long.';
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION['about'] = $description;
        header('Location:change_about.php');
        die();
        mysqli_close($conn);
    }

    $change_about = "UPDATE `users` SET `about` = '".htmlspecialchars($description)."' WHERE `login` = '".$user_login."'; ";
    $result = mysqli_query($conn, $change_about);
    if($result)
    {
        header("location:profile.php?user=".$user_login);
        mysqli_close($conn);
    }
    else
    {
        die("Cannot change the 'about'.");
    }
}
?>