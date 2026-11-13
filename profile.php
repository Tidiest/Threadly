<?php
    require 'config.php';
    include 'header.php';

    session_start();
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

    $user_login = $_GET['user'] ?? '';
    $user_login = trim($user_login);
    
    $user;
    $user_verif = 'SELECT * FROM `users` WHERE `login`="'.$user_login.'";';
    $result = mysqli_query($conn, $user_verif);

    $this_user = false;
    if ($result && mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);
        $this_user = isset($_SESSION['user_login']) && $_SESSION['user_login'] == $user['login'] ? true : false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($user['name'])) 
    {
        echo $user['name'];
     }
     else
     {
        echo "Deleted User";
     } 
     ?></title>
    <script src="popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
<body>
    
    <section class="row justify-content-center">
      <?php
         create_header();
         if (!isset($_SESSION['user_login']))
         {
             notloggedin();
         }
         else
         {
             loggedin($_SESSION['user_login']);
         }
         end_header();
      ?>
      
        <section class="row justify-content-center black-bg">
          
        <?php
            if (empty($user))
            {
                echo "<h1 class='text-center'>DELETED USER</h1>";
            }
            else
            {

            
            echo '<section class="row justify-content-center" style="padding: 20px;">
                <h5 class="fs-1">Your Threads</h5>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="card text-center lblack-bg" style="max-width: 90rem; padding: 5px; border: 1px solid #333;">
                        <div class="card-body">
                           <section class="row justify-content-center">
                            ';
                           $result = mysqli_query($conn, "SELECT * FROM threads WHERE user_login = '".$user['login']."'");
                           if (mysqli_num_rows($result) <= 0) 
                           {
                            echo '<p class="fs-6 text-secondary text-center">No threads yet...</p>';
                           }
                           while($wi = mysqli_fetch_assoc($result))
                           {
                            echo '<section class="row justify-content-center" style="padding: 20px;">
                            <div class="card text-center black-bg" style="max-width: 18rem; max-height: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">'.$wi['name'].'</h5>
                                    <p class="card-text text-truncate">'.$wi['description'].'</p>
                                    <a href="thread.php?thread='.$wi['url_name'].'" class="btn btn-primary">Visit</a>
                                </div>
                            </div>
                            </section>';
                           }
                           echo '</section>
                        </div>
                    </div>
                    <h5 class="fs-1">Your Posts</h5>  
                    <div class="card text-center lblack-bg" style="max-width: 90rem; padding: 5px; margin-top:10px; border: 1px solid #333;">
                        <div class="card-body">
                           <section class="row justify-content-center">
                           ';
                           $result = mysqli_query($conn, "SELECT * FROM posts WHERE user_login = '".$user['login']."'");
                           if (mysqli_num_rows($result) <= 0) 
                           {
                            echo '<p class="fs-6 text-secondary text-center">No posts yet...</p>';
                           }
                           while($post = mysqli_fetch_assoc($result))
                           {
                            echo '<section class="row justify-content-center" style="padding: 20px;">
                                    <div class="card black-bg" style="max-width: 50rem; max-height: 50rem;">
                                        <div class="card-body">
                                            <span class="fs-6 text-secondary">'.($post['date']).'</span>';
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
                           echo '</section>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    
                    <div class="card text-center lblack-bg" style="max-width: 30rem; max-height: 50rem; padding: 5px; position:sticky; z-index:999; top:60px; border: 1px solid #333;">
                        <div class="card-body">
                          <img src="uploads/pfp/'.$user['pfp'].'" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                          <h5 class="card-title fs-1">'.$user['name']." ".$user['surname'].'</h5>
                          <section class="row justify-content-center">
                            <p class="card-text fs-6"><b>About Me</b><br>'; 
                            
                            if (!empty($user['about']))
                            {
                                echo '<text class="text-secondary" style="white-space:pre-wrap;">'.$user['about'].'</text>';
                            } 
                            else
                            {
                                echo '<i class="text-secondary">No description yet...</i>';
                            }
                            
                            echo '</p>
                          </section>
                           <section class="row justify-content-center">
                            <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Login</b><br>'.$user['login'].'</p>
                            </section>
                            <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Birthday</b><br>'.$user['birth_date'].'</p>
                            </section>
                           </section>
                           ';
                           if ($this_user)
                           {
                                echo '<section class="row justify-content-center" style="margin-top: 20px;">
                                <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Email</b><br>'.$user['email'].'</p>
                            </section>
                            <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Password</b><br><a href="change_password.php" style="text-decoration:none;">Change Password</a></p>
                            </section>
                            </section>
                           <section class="row justify-content-center" style="margin-top: 20px;">
                             <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Profile Picture</b><br><a href="upload_pfp.php" style="text-decoration:none;">Change PFP</a></p>
                             </section>
                             <section class="col-6">
                                <p class="card-text text-truncate fs-6"><b>Profile description</b><br><a href="change_about.php" style="text-decoration:none;">Edit</a></p>
                             </section>';
                           }
                            
                           echo'</section>
                            </section>
                        </div>
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