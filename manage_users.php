<?php
    require 'config.php';
    include 'header.php';
    session_start();
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
    $category_url = $_GET['category'] ?? '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

    $user;
    $user_login = (isset($_SESSION['user_login'])) ? $user_login = $_SESSION['user_login'] : '';
    $user_verif = 'SELECT * FROM `users` WHERE `login`="'.$user_login.'";';
    $result = mysqli_query($conn, $user_verif);
    if ($result && mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_login'] = $user['login'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_surname'] = $user['surname'];
        $_SESSION['user_role'] = $user['role'];
    }
    if ($user_login != "admin")
    {
        header("location:show_thread.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threadly - Space for talk and sharing.</title>
    <script src="popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
    
    <!-- Content -->
    <section class="row justify-content-center">
      <?php
         create_header();
        if (!isset($_SESSION['user_login']))
        {
            notloggedin();
        }
        else
        {
            loggedin($user_login);
        }
         end_header();
      ?>
      
        <section class="row justify-content-center black-bg">
            <!-- BACK BUTTON -->
            <div class="d-flex" style= "margin:5px; position:sticky; z-index:999; top:60px;">
               <a href="admin_panel.php" class="btn btn-secondary">Back</a>
            </div>
            <p class="text-center fs-1">Manage Users</p>
        <?php

            $q = 'SELECT * FROM users ORDER BY name ASC;';
            $result = mysqli_query($conn, $q);
            while ($user = mysqli_fetch_assoc($result))
            {
                echo '<section class="row justify-content-center" style="padding: 20px;">
                  <div class="card text-center lblack-bg" style="max-width: 25rem; max-height: 15rem;">
                    <div class="card-body">
                        <img src="uploads/pfp/'.$user['pfp'].'" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                        <h5 class="card-title">'.$user['login'].'</h5>
                        <p class="fs-6 text-secondary">'.$user['name']." ".$user['surname'].'</p>
                        <p class="fs-6 text-secondary">'.$user['email'].'</p>';
                        echo '<a href="profile.php?user='.$user['login'].'" class="btn btn-primary" style="margin-right:5px;">Profile</a>';
                        if ($user['login'] != 'admin')
                        {
                            echo '<a href="ban_user.php?user='.$user['login'].'" class="btn btn-danger">Ban</a>';
                        };
                    echo '</div>
                  </div>
                </section>';
            };

        ?>
        
        </section>
     </section>

    

</body>
</html>