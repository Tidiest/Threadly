<?php
    require 'config.php';
    include 'header.php';
    session_start();
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
    $category_url = $_GET['category'] ?? '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

    $category_url = mysqli_real_escape_string($conn, $category_url);
    $q = 'SELECT * FROM category WHERE url_name = "'.$category_url.'" LIMIT 1;';
    $result = mysqli_query($conn, $q);
    $category = '';
    if ($result && mysqli_num_rows($result) > 0)
    {
      $category = mysqli_fetch_assoc($result);
    }

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
          <p class="text-center fs-1">Threads</p>
            <form class="d-flex justify-content-center" action="show_thread.php" method="GET" style="margin-right: 10px; margin-bottom:10px;">
                <select name="sort" class="form-control mr-2" style="width:130px;">
                  <option value="">Sort By</option>
                  <option value="name">Name</option>
                  <option value="date">Newest</option>
                  <option value="user_login">User</option>
                  <option value="popular">Most Popular</option>
                </select>
                <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">Sort</button>
            </form>
        <?php
            if (!empty($category_url))
            {
              echo '<p class="text-center fs-6">Category: '.$category['name'].'<p>';
              $q1 = 'SELECT * FROM threads WHERE name_category = "' . $category_url . '";';
            }
            else if (!empty($search))
            {
              $q1 = 'SELECT * FROM threads WHERE `name` LIKE "%' . $search . '%" OR `description` LIKE "%' . $search . '%" OR `user_login` LIKE "%' . $search . '%";';
            }
            else if (!empty($sort))
            {
              $q1 = 'SELECT * FROM threads WHERE 1 ORDER BY `'.$sort.'` ASC;';
              if ($sort == 'popular')
              {
                $q1 = 'SELECT threads.*, COUNT(posts.id_post) AS post_count FROM threads LEFT JOIN posts ON threads.url_name = posts.thread GROUP BY threads.url_name ORDER BY post_count DESC;';
              }
            }
            else
            {
              $q1 = 'select * from threads';
            }
            
            if (isset($_SESSION['user_login']))
            {
                echo '<p class="text-center"><a href="create_thread.php" class="btn btn-primary">Add Thread</a></p>';
            };
            
            //ADMIN PANEL
            if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 'admin')
            {
                echo '<p class="text-center"><a href="admin_panel.php" class="btn btn-warning">ADMIN PANEL</a></p>';
            };

            $threads = mysqli_query($conn, $q1);

            if (mysqli_num_rows($threads) == 0)
            {
                echo '<p class="fs-6 text-secondary text-center">No threads yet...</p>';
            }

            while($wi=mysqli_fetch_array($threads))
            {
                echo '<section class="row justify-content-center" style="padding: 20px;">
                  <div class="card text-center lblack-bg" style="max-width: 25rem; height: 11rem;">
                    <div class="card-body">
                        <a class="fs-6" href="profile.php?user='.$wi['user_login'].'" style="text-decoration: none; color: #D7DADC;">'.($wi['user_login']).'</a>
                        <span class="fs-6 text-secondary">'.($wi['date']).'</span>
                        <h5 class="card-title">'.$wi['name'].'</h5>
                        <p class="card-text text-truncate">'.$wi['description'].'</p>
                        <a href="thread.php?thread='.$wi['url_name'].'" class="btn btn-primary">Visit</a>
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