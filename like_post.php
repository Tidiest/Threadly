<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$post_id = $_GET['post'] ?? '';
$q1 = 'SELECT * FROM `user_likes` WHERE `id_post`="'.$post_id.'" AND `user_login` = "'.$_SESSION['user_login'].'";';
$like = mysqli_query($conn, $q1);
if (mysqli_num_rows($like) == 0) 
{   
    echo 'You can like!';
    $add_like = "INSERT INTO `user_likes`(`user_login`, `id_post`) VALUES ('".$_SESSION['user_login']."','".$post_id."')";
    $get_post = 'SELECT * FROM `posts` WHERE `id_post`="'.$post_id.'";';
    $post = mysqli_query($conn, $get_post);
    $post = mysqli_fetch_assoc($post);
    $update_likes = "UPDATE `posts` SET `rate`= (".$post['rate']." + 1) WHERE `id_post`='".$post_id."'; ";
    mysqli_query($conn, $add_like);
    mysqli_query($conn, $update_likes);
    echo $post['rate'];
}
else
{
    $remove_like = "DELETE FROM `user_likes` WHERE `id_post`='".$post_id."' AND `user_login` = '".$_SESSION['user_login']."';";
    $get_post = 'SELECT * FROM `posts` WHERE `id_post`="'.$post_id.'";';
    $post = mysqli_query($conn, $get_post);
    $post = mysqli_fetch_assoc($post);
    $update_likes = "UPDATE `posts` SET `rate`= (".$post['rate']." - 1) WHERE `id_post`='".$post_id."'; ";
    mysqli_query($conn, $remove_like);
    mysqli_query($conn, $update_likes);
    echo $post['rate'];
}
header('location:post.php?post='.$post_id);
exit;
?>
