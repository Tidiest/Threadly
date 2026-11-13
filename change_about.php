<?php
require 'config.php';
include 'header.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if (!isset($_SESSION['user_login']))
    {
        header("location:show_thread.php");
    }

$user;
$user_verif = 'SELECT * FROM `users` WHERE `login`="'.$_SESSION['user_login'].'";';
$result = mysqli_query($conn, $user_verif);
if ($result && mysqli_num_rows($result) > 0)
{
    $user = mysqli_fetch_assoc($result);
}

if (isset($_SESSION['errors']))
{
    foreach ($_SESSION['errors'] as $error)
    {
        echo '<p style="color:red;">'. $error .'</p>';
    }
    unset($_SESSION['errors']);
}

$description = isset($_SESSION['about']) ? htmlspecialchars($_SESSION['about']) : $user['about'];
unset($_SESSION['about']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Change About Me</title>
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
            <p class="text-center fs-1">Write Your Description<p>
            <form action="change_about_handler.php" method="POST">
                <div class="mb-3">
                  <label for="desc" class="form-label" id="content_label">Description content: (100 max)</label>
                  <textarea class="form-control" id="desc" name="desc" rows="2" required><?php echo $description; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
          
        <?php

          mysqli_close($conn);

        ?>
        </section>
     </section>

     <script>
        let content_area = document.getElementById("desc");
        content_area.addEventListener("change", () => 
        {
            let content_label = document.getElementById("content_label");
            let content_lenght = content_area.value.length;
            content_label.textContent = "Description content: (" + content_lenght + "/100)";
        });
     </script>
</body>
</html>