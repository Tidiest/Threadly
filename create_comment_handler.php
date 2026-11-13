<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$post_id = $_GET['post'] ?? '';
$comment_id = $_GET['comment'] ?? '';

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
    $content = trim($_POST['content']); //remove all of the leading whitespaces
    $content = str_replace("\r\n","\n", $content); //replace php new line with new line

    $no_whitespace_content_check = str_replace(["\n","\r"," "],'', $content);//count the total number of characters without whitespace

    $errors = [];

    if (empty($no_whitespace_content_check))
    {
        $errors[] = "Comment cannot be empty or consist only of whitespaces.";
    }

    $newlines_in_content = substr_count($content,"\n"); //count the number of new lines

    if ($newlines_in_content > strlen($content)/2 || $newlines_in_content > 10)
    {
        $errors[] = "Comment has too many newlines.";
    }

    if (strlen($content) > 1000)
    {
        $errors[] = 'Content is too long.'.strlen($content);
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        if ($comment_id != '')
        {
            header('Location:create_comment.php?post='.$post_id.'&comment='.$comment_id);
        }
        else
        {
            header('Location:create_comment.php?post='.$post_id);
        }
        
        die();
        mysqli_close($conn);
    }

    $check_comment_exists = "SELECT * FROM comments WHERE `id_comment` = '".$_GET['comment']."' LIMIT 1;";
    $result = mysqli_query($conn, $check_comment_exists);
    if (mysqli_num_rows($result) > 0 && $comment_id != '')
    {
        $create_comment = "UPDATE `comments` SET `content` = '".$content."' WHERE `comments`.`id_comment` = ".$comment_id."; ";

        $result = mysqli_query($conn, $create_comment);
        if ($result)
        {
            header('location:post.php?post='.$post_id);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot edit the comment. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    else if (empty($comment_id))
    {
        $create_comment = "INSERT INTO `comments`(`user_login`, `post_id`, `content`) VALUES ('".htmlspecialchars($user_login)."','".$post_id."','".htmlspecialchars($content)."')";

        $result = mysqli_query($conn, $create_comment);
        if ($result)
        {
            header('location:post.php?post='.$post_id);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot make a comment. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    else
    {
        die("Comment doesn't exist");
    }

}
?>