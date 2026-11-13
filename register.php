<?php
    session_start();
    require 'config.php';
    include 'header.php';
    
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

    if (isset($_SESSION['errors']))
    {
        foreach ($_SESSION['errors'] as $error)
        {
            echo '<p style="color:red;">'. $error .'</p>';
        }
        unset($_SESSION['errors']);
    }

    $name = isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : '';
    $surname = isset($_SESSION['form_data']['surname']) ? htmlspecialchars($_SESSION['form_data']['surname']) : '';
    $email = isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '';
    $birthdate = isset($_SESSION['form_data']['birthdate']) ? htmlspecialchars($_SESSION['form_data']['birthdate']) : '';
    unset($_SESSION['form_data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <form action="register_handler.php" method="POST">
                <div class="lblack-bg">
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" value='<?php echo $name; ?>' required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="surname" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="surname" value='<?php echo $surname; ?>' required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" value='<?php echo $email; ?>' required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="pass" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="pass" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="conf_pass" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="conf_pass" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="birthdate" class="col-sm-2 col-form-label">Birth Date</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="birthdate" value='<?php echo $birthdate; ?>' required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>

            <?php

                $q1 = 'select * from users';
                $r1 = mysqli_query($conn, $q1);


                mysqli_close($conn);

                ?>
        </section>
     </section>

    

</body>
</html>