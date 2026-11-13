<?php

require 'config.php';
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

function create_header()
{
    echo '<section class="row justify-content-center header">
    <nav class="navbar navbar-expand-lg lblack-bg">
      <div class="container-fluid">
          <a class="navbar-brand text-info" href="show_thread.php">Threadly</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"\>';
}

function notloggedin()
{
  echo '<li class="nav-item">
  <a href="login.php" class="btn btn-primary">Log In</a>
</li> ';
}

function loggedin($user_login)
{
  require 'config.php';
  $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
  $q = 'SELECT * FROM users WHERE `login` = "'.$user_login.'";';
  $result = mysqli_query($conn, $q);
  $user = mysqli_fetch_assoc($result);
  echo '
  <li class="nav-item">
    <a class="nav-link text-light" href="profile.php?user='.$user_login.'"><img src="uploads/pfp/'.$user['pfp'].'" style="width: 25px; height: 25px; border-radius: 50%;"></a>
  </li>
  <li class="nav-item">
    <a href="logout.php" class="btn btn-danger">Log Out</a>
  </li>';
}

function end_header()
{
    require 'config.php';
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');
    $q = 'SELECT * FROM category ORDER BY name ASC;';
    $result = mysqli_query($conn, $q);
    echo '</ul>
    <form class="d-flex" action="show_thread.php" method="GET" style="margin-right: 10px;">
              <select name="category" class="form-control mr-2">
                <option value="">All Categories</option>';
                while ($row = mysqli_fetch_assoc($result))
                {
                  echo '<option value="'.$row['url_name'].'">'.$row['name'].'</option>';
                };
              echo '</select>
              <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">Search</button>
        </form>
            <form class="d-flex" role="search" action="show_thread.php" method="GET">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
      </div>
    </nav>
  </section>';
}

?>

