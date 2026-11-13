<?php
require 'config.php';
include 'header.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$post_id = $_GET['post'] ?? '';
$q1 = 'SELECT * FROM `posts` WHERE `id_post`="'.$post_id.'";';
$post = mysqli_query($conn, $q1);
$post = mysqli_fetch_assoc($post);
if (!$post)
{
    header("location:show_thread.php");
}
$post_title = $post['title'];
$is_post_admin = false;

$user_login = (isset($_SESSION['user_login'])) ? $_SESSION['user_login'] : '';
$user_role = (isset($_SESSION['user_role'])) ? $_SESSION['user_role'] : '';

if(isset($_SESSION['user_login']))
{
    if($_SESSION['user_login'] == $post['user_login'] || $user_role == 'admin')
    {
        $is_post_admin = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>
        <?php
        if ($post_title) 
        {
            echo ''.$post_title.'';
        }
        ?>
    </title>
</head>
<body>
    
<section class="row justify-content-center light">
    <?php
        echo create_header();
        if (!isset($_SESSION['user_login']))
        {
            notloggedin();
        }
        else
        {
            loggedin($_SESSION['user_login']);
        }
        echo end_header();
    ?>
    
    <section class="row justify-content-center">
    <!-- BACK BUTTON -->
     <div class="d-flex" style= "margin:5px; position:sticky; z-index:999; top:60px;">
        <a href="<?php echo "thread.php?thread=".$post['thread']; ?>" class="btn btn-secondary">To Thread</a>
     </div>

        <?php

            echo '<section class="row justify-content-center" style="padding: 20px;">
                <div class="card lblack-bg" style="max-width: 70rem; max-height: 100rem;">
                    <div class="card-body">
                        <a class="fw-6" href="profile.php?user='.$post['user_login'].'" style="text-decoration: none; color: #D7DADC;">'.($post['user_login']).'</a>
                        <span class="fw-6 text-secondary">'.($post['date']).'</span>';
                        if ($is_post_admin)
                        {
                            echo '<a href="create_post.php?post='.$post['id_post'].'" class="btn btn-primary" style="margin:2px;">Edit Post</a>';
                            echo '<a href="delete.php?post='.$post['id_post'].'" class="btn btn-danger" style="margin:2px;">Delete</a>';
                        }
                        echo '<h5 class="card-title" style="white-space:pre-wrap;">'.$post['title'].'</h5>
                        <p class="card-text" style="white-space:pre-wrap;">'.$post['content'].'</p>
                        ';
                        if (isset($_SESSION['user_login']))
                        {
                            echo '<a href="like_post.php?post='.$post['id_post'].'" class="btn btn-primary">'.$post['rate'].'</a>';
                            if (!$post['closed_comments'])
                            {
                                echo '<a href="create_comment.php?post='.$post_id.'" class="btn btn-primary" style="margin:2px;">Comment</a>';
                            }
                            else
                            {
                                echo '<a href="" class="btn btn-danger" style="margin:2px;">Comments Closed</a>';
                            }
                        }
                        else
                        {
                            echo '<a class="btn btn-primary">'.$post['rate'].'</a>';
                        }
                    echo '</div>
                </div>
                </section>';
            
            $comments_query = "SELECT * FROM `comments` WHERE `post_id`='".$post_id."' ORDER BY `date` DESC;";
            $comments = mysqli_query($conn, $comments_query);

            if (mysqli_num_rows($comments) == 0)
            {
                echo '<p class="fs-6 text-secondary text-center">No comments yet...</p>';
            }

            while($comment=mysqli_fetch_array($comments))
            {
                echo '<section class="row justify-content-center" style="padding: 20px;">
                <div class="card lblack-bg" style="max-width: 50rem; max-height: 50rem;">
                    <div class="card-body">
                        <a class="fs-6" href="profile.php?user='.$comment['user_login'].'" style="text-decoration: none; color: #D7DADC;">'.($comment['user_login']).'</a>
                        <span class="fs-6 text-secondary">'.($comment['date']).'</span>';
                        if ($user_login == $comment['user_login'] || $user_role == 'admin')  //creator can edit their comments
                        {
                            echo '<a href="create_comment.php?post='.$post_id."&comment=".$comment['id_comment'].'" class="btn btn-primary" style="margin:2px;">Edit</a>';
                            echo '<a href="delete.php?post='.$post_id."&comment=".$comment['id_comment'].'" class="btn btn-danger" style="margin:2px;">Delete</a>';
                        };
                        echo '<p class="card-text" style="white-space:pre-wrap;">'.($comment['content']).'</p>
                    </div>
                </div>
                </section>';
            }

            mysqli_close($conn);

            ?>
        </section>
     </section>

</body>
</html>