<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$post_id = $_GET['post'] ?? '';
$comment_id = $_GET['comment'] ?? '';
$thread = $_GET['thread'] ?? '';

//PIN
if ($post_id != '' && $thread != '')
{
    $check_post_exists = "SELECT * FROM posts WHERE `id_post` = '".$post_id."' LIMIT 1;";
    $check_thread_exists = "SELECT * FROM threads WHERE `url_name` = '".$thread."' LIMIT 1;";
    $result_post = mysqli_query($conn, $check_post_exists);
    $result_thread = mysqli_query($conn, $check_thread_exists);
    
    if (mysqli_num_rows($result_post) > 0 && mysqli_num_rows($result_thread) > 0)
    {
        $pin_post = "UPDATE `threads` SET `pinned_post` = '".$post_id."' WHERE `url_name` = '".$thread."'; ";
    
        $result = mysqli_query($conn, $pin_post);
        if ($result)
        {
            header('location:thread.php?thread='.$thread);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot pin the post. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    header('location:thread.php?thread='.$thread);
    exit;
}
//UNPIN
else if (empty($post_id))
{
    $check_thread_exists = "SELECT * FROM threads WHERE `url_name` = '".$thread."' LIMIT 1;";
    $result_thread = mysqli_query($conn, $check_thread_exists);
    
    if (mysqli_num_rows($result_thread) > 0)
    {
        $pin_post = "UPDATE `threads` SET `pinned_post` = 'NULL' WHERE `url_name` = '".$thread."'; ";
    
        $result = mysqli_query($conn, $pin_post);
        if ($result)
        {
            header('location:thread.php?thread='.$thread);
            mysqli_close($conn);
        }
        else
        {
            die("Cannot pin the post. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    header('location:thread.php?thread='.$thread);
    exit;
}

header('location:show_thread.php');
exit;

?>