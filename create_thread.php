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

if (isset($_SESSION['errors']))
{
    foreach ($_SESSION['errors'] as $error)
    {
        echo '<p style="color:red;">'. $error .'</p>';
    }
    unset($_SESSION['errors']);
}
$_thread;
$thread_verif = 'SELECT * FROM `threads` WHERE `url_name`="'.$thread.'" LIMIT 1;';
$result = mysqli_query($conn, $thread_verif);
if ($result && mysqli_num_rows($result) > 0)
{
    $_thread = mysqli_fetch_assoc($result);
}

$name = isset($_SESSION['thread_data']['name']) ? htmlspecialchars($_SESSION['thread_data']['name']) : (!empty($_thread['name']) ? $_thread['name'] : '');
$description = isset($_SESSION['thread_data']['description']) ? htmlspecialchars($_SESSION['thread_data']['description']) : (!empty($_thread['name']) ? $_thread['description'] : '');
$url_name = isset($_SESSION['thread_data']['url_name']) ? htmlspecialchars($_SESSION['thread_data']['url_name']) : (!empty($_thread['name']) ? $_thread['url_name'] : '');
unset($_SESSION['thread_data']);
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
            <p class="text-center fs-1">Create Your Thread<p>
            <form action=<?php echo "create_thread_handler.php?thread=".$thread; ?> method="POST">
                <div class="mb-3">
                  <label for="name" class="form-label" id="name_label">Thread Name: (100 max)</label>
                  <textarea class="form-control" id="name" name="name" rows="1" ><?php echo $name; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="url_name" class="form-label" id="url_name_label">Url Name: (30 max)</label>
                  <textarea class="form-control" id="url_name" name="url_name" rows="1" ><?php echo $url_name; ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label" id="description_label">Thread Description: (700 max)</label>
                  <textarea class="form-control" id="description" name="description" rows="3"><?php echo $description; ?></textarea>
                </div>
                <div class="mb-3">
                <label for="category" class="form-label" id="category_label">Category: </label>
                <?php 
                $q = 'SELECT * FROM category;';
                $result = mysqli_query($conn, $q);
                echo '<select name="category" class="form-control mr-2" style="width:10%;">
                <option value="">All Categories</option>';
                while ($row = mysqli_fetch_assoc($result))
                {
                  echo '<option value="'.$row['url_name'].'">'.$row['name'].'</option>';
                };
              echo '</select>';
                ?>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
          
          <?php

            mysqli_close($conn);

          ?>
        </section>
     </section>

     <script>
        let name_area = document.getElementById("name");
        name_area.addEventListener("change", () => 
        {
            let name_label = document.getElementById("name_label");
            let name_lenght = name_area.value.length;
            name_label.textContent = "Thread Name: (" + name_lenght + "/100)";
        });

        let url_name_area = document.getElementById("url_name");
        url_name_area.addEventListener("change", () => 
        {
            let url_name_label = document.getElementById("url_name_label");
            let url_name_lenght = url_name_area.value.length;
            url_name_label.textContent = "Url Name: (" + url_name_lenght + "/30)";
        });

        let description_area = document.getElementById("description");
        description_area.addEventListener("change", () => 
        {
            let description_label = document.getElementById("description_label");
            let description_lenght = description_area.value.length;
            description_label.textContent = "Thread Description: (" + description_lenght + "/700)";
        });
     </script>
</body>
</html>