<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$post_id = $_GET['post'] ?? '';
$comment_id = $_GET['comment'] ?? '';
$thread = $_GET['thread'] ?? '';
$category = $_GET['category'] ?? '';

if ($comment_id != '')
{
    $check_comment_exists = "SELECT * FROM comments WHERE `id_comment` = '".$comment_id."' LIMIT 1;";
    $result = mysqli_query($conn, $check_comment_exists);
    
    if (mysqli_num_rows($result) > 0)
    {
        $delete_comment = "DELETE FROM comments WHERE `comments`.`id_comment` = ".$comment_id.";";
    
        $result = mysqli_query($conn, $delete_comment);
        if ($result)
        {
            header('location:post.php?post='.$post_id);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot delete the comment. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    header('location:post.php?post='.$post_id);
    exit;
}
else if ($post_id != '')
{
    $check_post_exists = "SELECT * FROM posts WHERE `id_post` = '".$post_id."' LIMIT 1;";
    $result = mysqli_query($conn, $check_post_exists);
    
    if (mysqli_num_rows($result) > 0)
    {
        $is_pinned_in_thread = "SELECT * FROM threads WHERE `pinned_post` = '".$post_id."' LIMIT 1;";
        $result_is_pinned = mysqli_query($conn, $is_pinned_in_thread);
        
        if (mysqli_num_rows($result_is_pinned) > 0)
        {
            $delete_pinned_post = "UPDATE `threads` SET `pinned_post` = NULL WHERE `pinned_post` = ".$post_id."; ";
            $result = mysqli_query($conn, $delete_pinned_post);
            if (!$result)
            {
                die("Cannot unpin the post. ".mysqli_error($conn));
                mysqli_close($conn);
            }
        }

        $delete_post = "DELETE FROM posts WHERE `id_post` = ".$post_id.";";
    
        $result = mysqli_query($conn, $delete_post);
        if ($result)
        {
            header('location:thread.php?thread='.$thread);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot delete the post. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    if (empty($thread))
    {
        header('location:show_thread.php');
        exit;
    }
    else
    {
        header('location:thread.php?thread='.$thread);
        exit;
    }
}
else if ($thread != '')
{
    $check_thread_exists = "SELECT * FROM threads WHERE `url_name` = '".$thread."' LIMIT 1;";
    $result = mysqli_query($conn, $check_thread_exists);
    
    if (mysqli_num_rows($result) > 0)
    {
        $delete_thread = "DELETE FROM threads WHERE `url_name` = '".$thread."';";
    
        $result = mysqli_query($conn, $delete_thread);
        if ($result)
        {
            header('location:show_thread.php');
            mysqli_close($conn);
        }
        else
        {
            die("Cannot delete the thread. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    header('location:show_thread.php');
    exit;
}
else if ($category != '')
{
    $check_category_exists = "SELECT * FROM category WHERE `url_name` = '".$category."' LIMIT 1;";
    $result = mysqli_query($conn, $check_category_exists);
    
    if (mysqli_num_rows($result) > 0)
    {
        $delete_category = "DELETE FROM category WHERE `url_name` = '".$category."';";
    
        $result = mysqli_query($conn, $delete_category);
        if ($result)
        {
            header('location:change_category.php');
            mysqli_close($conn);
        }
        else
        {
            die("Cannot delete the category. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    header('location:change_category.php');
    exit;
}

header('location:show_thread.php');
exit;

?>