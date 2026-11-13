<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$thread = $_GET['thread'] ?? '';
$post = $_GET['post'] ?? '';

if (isset($_SESSION['user_login'])) 
{
    $user_login = $_SESSION['user_login'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $title = str_replace("\r\n","\n", $title);
    $content = str_replace("\r\n","\n", $content);

    $no_whitespace_title_check = str_replace(["\n","\r"," "],'', $title);
    $no_whitespace_content_check = str_replace(["\n","\r"," "],'', $content);

    $errors = [];

    if (empty($no_whitespace_content_check) || empty($no_whitespace_title_check))
    {
        $errors[] = "Fields cannot be empty or consist only of whitespaces.";
    }

    $newlines_in_title = substr_count($title,"\n");
    $newlines_in_content = substr_count($content,"\n");

    if (($newlines_in_content > strlen($content)/2 || $newlines_in_content > 10) ||
    ($newlines_in_title > strlen($title)/2 || $newlines_in_title > 1))
    {
        $errors[] = "Fields can't have too many newlines.";
    }

    if (strlen($title) > 100)
    {
        $errors[] = 'Title is too long.';
    }

    if (strlen($content) > 700)
    {
        $errors[] = 'Content is too long.';
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["post_data"] = ['title' => $title, 'content' => $content];
        if ($post != '')
        {
            header('Location:create_post.php?post='.$post);
        }
        else
        {
            header('Location:create_post.php?thread='.$thread);
        }
        
        die();
    }

    $check_existing_threads = 'SELECT * FROM `threads` WHERE `url_name` = "'.htmlspecialchars($thread).'";';
    $existing_threads = mysqli_query($conn, $check_existing_threads);
    $existing_threads = mysqli_fetch_all($existing_threads, MYSQLI_ASSOC);

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["thread_data"] = ['name' => $name, 'url_name' => $url_name, 'description' => $description];
        if ($thread != '')
        {
            header('Location:create_thread.php?thread='.$thread);
        }
        else
        {
            header('Location:create_thread.php');
        }
        die();
        mysqli_close($conn);
    }

    $check_post_exists = "SELECT * FROM posts WHERE `id_post` = '".$post."' LIMIT 1;";
    $result = mysqli_query($conn, $check_post_exists);
    if (mysqli_num_rows($result) > 0 && $post != '')
    {
        $edit_post = "UPDATE `posts` SET `title` = '".htmlspecialchars($title)."', `content` = '".htmlspecialchars($content)."', `closed_comments` = '".isset($_POST['closed'])."' WHERE `id_post` = ".$post."; ";
        
        $result = mysqli_query($conn, $edit_post);
        if ($result)
        {
            header('Location:post.php?post='.$post);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot edit a post. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    else if (empty($comment_id) && count($existing_threads) > 0)
    {
        $create_post = "INSERT INTO `posts`(`title`, `content`, `user_login`,`thread`, `closed_comments`) VALUES ('".htmlspecialchars($title)."','".htmlspecialchars($content)."','".$user_login."','".htmlspecialchars($thread)."', '".isset($_POST['closed'])."')";

        $result = mysqli_query($conn, $create_post);
        if ($result)
        {
            header('Location:thread.php?thread='.$thread);
        }
        else
        {
            die("Cannot make a post. ".mysqli_error($conn));
        }
    }
    else
    {
        die("Post doesn't exist");
    }

    

}
?>