<?php
require 'config.php';
include 'header.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if (!isset($_SESSION['user_login']))
    {
        header("location:show_thread.php");
    }

$thread = $_GET['thread'] ?? '';
$post = $_GET['post'] ?? '';

if (isset($_SESSION['errors']))
{
    foreach ($_SESSION['errors'] as $error)
    {
        echo '<p style="color:red;">'. $error .'</p>';
    }
    unset($_SESSION['errors']);
}

$check_post_exists = "SELECT * FROM posts WHERE `id_post` = '".$post."' LIMIT 1;";
$result = mysqli_query($conn, $check_post_exists);
$post_assoc = mysqli_fetch_assoc($result);

$title = isset($_SESSION['post_data']['title']) ? htmlspecialchars($_SESSION['post_data']['title']) : (isset($post_assoc['title']) ? $post_assoc['title'] : '');
$content = isset($_SESSION['post_data']['content']) ? htmlspecialchars($_SESSION['post_data']['content']) : (isset($post_assoc['content']) ? $post_assoc['content'] : '');

unset($_SESSION['post_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
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

        <section class="row justify-content-center black-bg">
            <p class="text-center fs-1">Write Your Post<p>
            <form action=<?php echo "create_post_handler.php?thread=".$thread."&post=".$post ?> method="POST">
                <div class="mb-3">
                  <label for="title" class="form-label" id="title_label">Title: (100 max)</label>
                  <textarea class="form-control" id="title" name="title" rows="1" ><?php echo $title; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="content" class="form-label" id="content_label">Post content: (700 max)</label>
                  <textarea class="form-control" id="content" name="content" rows="3"><?php echo $content; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="closed" class="form-label" id="closed_label">Close comments?: </label>
                  <input class="form-check-input" type="checkbox" <?php if ( isset($post_assoc['closed_comments']) && $post_assoc['closed_comments']!=0) echo "checked"; ?> aria-label="Checkbox for following text input" id="closed" name="closed">
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
            
        <?php


            mysqli_close($conn);

            ?>
        </section>
     </section>

     <script>
        let content_area = document.getElementById("content");
        content_area.addEventListener("change", () => 
        {
            let content_label = document.getElementById("content_label");
            let content_lenght = content_area.value.length;
            content_label.textContent = "Post content: (" + content_lenght + "/700)";
        });
        let title_area = document.getElementById("title");
        title_area.addEventListener("change", () => 
        {
            let title_label = document.getElementById("title_label");
            let title_lenght = title_area.value.length;
            title_label.textContent = "Title: (" + title_lenght + "/100)";
        });
     </script>
</body>
</html>