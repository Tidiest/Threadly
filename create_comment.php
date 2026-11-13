<?php
require 'config.php';
include 'header.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if (!isset($_SESSION['user_login']))
    {
        header("location:show_thread.php");
    }

$post_id = $_GET['post'] ?? '';
$comment_id = $_GET['comment'] ?? '';

if (isset($_SESSION['errors']))
{
    foreach ($_SESSION['errors'] as $error)
    {
        echo '<p style="color:red;">'. $error .'</p>';
    }
    unset($_SESSION['errors']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Create Comment</title>
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
            <p class="text-center fs-1">Write Your Comment<p>
            <form action=<?php echo "create_comment_handler.php?post=".$post_id."&comment=".$comment_id ?> method="POST">
                <div class="mb-3">
                  <label for="content" class="form-label" id="content_label">Comment content: (1000 max)</label>
                  <textarea class="form-control" id="content" name="content" rows="3"></textarea>
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
            content_label.textContent = "Comment content: (" + content_lenght + "/1000)";
        });
     </script>
</body>
</html>