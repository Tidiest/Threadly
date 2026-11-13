<?php
require 'config.php';
session_start();
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die('Nie można się połączyć z bazą');

if (isset($_SESSION['user_login']))
{
    $user_login = $_SESSION['user_login'];
}
else
{
    $user_login = '';
}

$thread = $_GET['thread'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $url_name = trim($_POST['url_name']);
    $url_name = str_replace("\r\n","\n", $url_name);
    $name = str_replace("\r\n","\n", $name);
    $description = str_replace("\r\n","\n", $description); //replace php new line with new line

    $name = str_replace("\n", '', $name);
    $name_no_whitespace = str_replace(["\r", " "], '', $name);
    $description_no_whitespace = str_replace(["\r", "\n", " "], '', $description);
    $url_name = str_replace(["\r", "\n", " "], '', $url_name);

    $errors = [];

    if (empty($name_no_whitespace) || empty($description_no_whitespace) || empty($url_name))
    {
        $errors[] = "Fields cannot be empty or consist only of whitespaces.";
    }

    $newlines_in_description = substr_count($description,"\n");

    if (($newlines_in_description > strlen($description)/2 || $newlines_in_description > 10))
    {
        $errors[] = "Fields can't have too many newlines.";
    }

    if (strlen($name) > 100)
    {
        $errors[] = 'Name is too long.';
    }

    if (strlen($url_name) > 30)
    {
        $errors[] = 'Url Name is too long.';
    }

    if (strlen($description) > 700)
    {
        $errors[] = 'Description is too long.';
    }

    if (!preg_match('/^[A-Za-z0-9]+$/', $url_name))
    {
        $errors[] = 'Url Name can only contain letters and numbers.';
    }

    $check_existing_threads = 'SELECT * FROM `threads` WHERE `url_name` = "'.htmlspecialchars($url_name).'" OR `name` = "'.htmlspecialchars($name).'"';
    $existing_threads = mysqli_query($conn, $check_existing_threads);
    $existing_threads = mysqli_fetch_all($existing_threads, MYSQLI_ASSOC);

    if (count($existing_threads) > 0)
    {
        $errors[] = 'Thread with the same name or URL name already exists.';
    }

    if (!empty($errors))
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["thread_data"] = ['name' => $name, 'url_name' => $url_name, 'description' => $description];
        if ($thread != '')
        {
            header('Location:create_thread.php?thread='.$thread);
        }
        else
        {
            header('Location:create_thread.php');
        }
        die();
        mysqli_close($conn);
    }

    $check_thread_exists = "SELECT * FROM threads WHERE `url_name` = '".htmlspecialchars($thread)."' LIMIT 1;";
    $result = mysqli_query($conn, $check_thread_exists);

    if (mysqli_num_rows($result) > 0 && $thread != '')
    {
        //EDIT thread
        $edit_thread = "UPDATE `threads` SET `name` = '".htmlspecialchars($name)."',`url_name` = '".htmlspecialchars($url_name)."', `description` = '".htmlspecialchars($description)."' WHERE `threads`.`url_name` = '".htmlspecialchars($thread)."';";

        $result = mysqli_query($conn, $edit_thread);
        if ($result)
        {
            //CHANGE 'thread_name' on POSTs
            $change_posts_thread = "SELECT * FROM posts WHERE `thread` = '".htmlspecialchars($thread)."';";
            $result_change_posts_thread = mysqli_query($conn, $change_posts_thread);
            while ($row_change_posts_thread = mysqli_fetch_assoc($result_change_posts_thread))
            {
                $update_comment_thread = "UPDATE `posts` SET `thread` = '".htmlspecialchars($url_name)."' WHERE `id_post` = ".$row_change_posts_thread['id_post'].";";

                $result = mysqli_query($conn, $update_comment_thread);
                if(!$result)
                {
                    die("Cannot update post's thread. ".mysqli_error($conn));
                    mysqli_close($conn);
                    break;
                }
            }
            header('location:thread.php?thread='.htmlspecialchars($url_name));
            mysqli_close($conn);
        }
        else
        {
            die("Cannot edit a thread. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    else if (empty($thread))
    {
        $create_thread = "INSERT INTO `threads`(`name`, `url_name`, `description`, `user_login`, `name_category`) VALUES ('".htmlspecialchars($name)."','".htmlspecialchars($url_name)."','".htmlspecialchars($description)."', '".htmlspecialchars($user_login)."', '".$category."')";

        $result = mysqli_query($conn, $create_thread);
        if ($result)
        {
            header('location:show_thread.php');
            mysqli_close($conn);
        }
        else
        {
            die("Cannot make a thread. ".mysqli_error($conn));
            mysqli_close($conn);
        }
    }
    else
    {
        die("Thread doesn't exist");
    }

    

}
?>