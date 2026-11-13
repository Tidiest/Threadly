<?php
require 'config.php';
include 'header.php';

session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

$thread_name = htmlspecialchars($_GET['thread']) ?? '';

$q1 = 'SELECT * FROM `threads` WHERE `url_name`="'.$thread_name.'";';
$thread = mysqli_query($conn, $q1);
$thread = mysqli_fetch_assoc($thread);
if (!$thread)
{
    header("location:show_thread.php");
}
$thread_name = $thread['name'];
$admin = $thread['user_login'];
$is_thread_admin = false;

$user_login = (isset($_SESSION['user_login'])) ? $user_login = $_SESSION['user_login'] : '';
$user_role = (isset($_SESSION['user_role'])) ? $user_role =  $_SESSION['user_role'] : '';

if(isset($_SESSION['user_login']))
{
    if($user_login == $thread['user_login'] || $user_role == 'admin')
    {
        $is_thread_admin = true;
    }
}

function display_post($post, $is_pinned = false)
{
    global $user_role, $user_login, $conn, $is_thread_admin, $thread;
    echo '<section class="row justify-content-center" style="padding: 20px;">
                <div class="card lblack-bg" style="max-width: 50rem; max-height: 50rem;">
                    <div class="card-body">
                        ';
                        if ($is_pinned)
                        {
                            echo '<h5 class="card-title" style="color: #FFA07A;"> Pinned post</h5>';
                        };

                        echo '<a class="fs-6" href="profile.php?user='.$post['user_login'].'" style="text-decoration: none; color: #D7DADC;">'.($post['user_login']).'</a>
                        <span class="fs-6 text-secondary">'.($post['date']).'</span>';

                        // CHANGE OPTIONS IF ADMIN, THREAD ADMIN OR CREATOR
                        if (($user_login == $post['user_login'] || $user_role == 'admin'))
                        {
                            echo '<a href="create_post.php?post='.$post['id_post'].'" class="btn btn-primary" style="margin:2px;">Edit Post</a>';
                        }
                        if ($is_thread_admin)
                        {
                            if (!$is_pinned)
                            {
                                echo '<a href="pin_post.php?post='.$post['id_post']."&thread=".$_GET['thread'].'" class="btn btn-warning" style="margin:2px;">Pin</a>';
                            }
                            else
                            {
                                echo '<a href="pin_post.php?'."&thread=".$_GET['thread'].'" class="btn btn-info" style="margin:2px;">Unpin</a>';
                            }
                        }
                        if (($user_login == $post['user_login'] || $user_role == 'admin') || $is_thread_admin)
                        {
                            echo '<a href="delete.php?post='.$post['id_post']."&thread=".$_GET['thread'].'" class="btn btn-danger" style="margin:2px;">Delete</a>';
                        }
                        

                        echo '<h4 class="card-title" style="white-space:pre-wrap;"><b>'.($post['title']).'</b></h4>
                        <p class="card-text text-truncate">'.($post['content']).'</p>';
                        echo '<span class="fs-6">Likes: '.($post['rate']).';</span>';
                        $comments_query = "SELECT * FROM `comments` WHERE `post_id`='".$post['id_post']."' ORDER BY `date` DESC;";
                        $comments = mysqli_query($conn, $comments_query);
                        echo '<span class="fs-6" style="margin:2px;">Comments: '.mysqli_num_rows($comments).'</span>
                        <a href="post.php?post='.$post['id_post'].'" class="btn btn-primary">Visit</a>
                    </div>
                </div>
                </section>';
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
            echo ''.$thread_name.'';
        ?>
    </title>
</head>
<body>
<section class="row justify-content-center">
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
            <?php
            

            if (empty($thread_name))
            {
                echo "Error: Thread name is required.";
            }

            echo '<section class="row justify-content-center" style="padding: 20px;">
                <div class="card text-center lblack-bg" style="max-width: 50rem; max-height: 50rem;">
                    <div class="card-body">
                        <h1 class="card-title">'.($thread_name).'</h1>
                        <p class="card-text ">'.($thread['description']).'</p>
                        ';
                        if (isset($_SESSION['user_login']))
                        {
                            echo '<a href="create_post.php?thread='.$thread['url_name'].'" class="btn btn-primary">Add Post</a>';
                        };
                        if ($is_thread_admin)
                        {
                            echo '<a href="create_thread.php?thread='.$thread['url_name'].'" class="btn btn-primary" style="margin:2px;">Edit Thread</a>';
                            echo '<a href="delete.php?thread='.$_GET['thread'].'" class="btn btn-danger" style="margin:2px;">Delete</a>';
                        }
                    echo '</div>
                </div>
                </section>';
            echo "<p class='text-center fs-3'>Community Posts<p>";

            $q2 = 'SELECT p.user_login, p.date, p.id_post, p.title, p.content, p.rate FROM posts AS p LEFT JOIN threads ON threads.pinned_post = p.id_post WHERE p.thread="'.$thread['url_name'].'" ORDER BY (p.id_post = threads.pinned_post) DESC, p.date DESC;';
           
            $posts = mysqli_query($conn, $q2);

            if (mysqli_num_rows($posts) == 0)
            {
                echo '<p class="fs-6 text-secondary text-center">No posts yet...</p>';
            }
            if(!empty($thread['pinned_post']))
            {

                $post=mysqli_fetch_array($posts);
                display_post($post, true);
            }

            while($post=mysqli_fetch_array($posts))
            {
                display_post($post);
            }
            ?>
        </section>

</body>
</html>