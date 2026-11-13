<?php
    require 'config.php';
    include 'header.php';
    session_start();
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

    if (!isset($_SESSION['user_login']))
    {
        header("location:show_thread.php");
    }
    
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
    <title>Change Profile Picture</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
<body>

    <!-- Content -->
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
            <form action="upload_pfp_handler.php" method="POST" enctype="multipart/form-data">
                <div class="lblack-bg">
                  <div class="row mb-3">
                    <label for="picture" class="col-sm-2 col-form-label">Upload Profile Picture</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="picture" accept="image/*">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </section>
     </section>

    

</body>
</html>