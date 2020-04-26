<?php 
    session_start();
    $errorMessage = "";
    //If the user has a logged in session and tries to go to the login page it will take them to the diary page.
    if($_SESSION['email'])
    {
        header("Location:diary-page.php");
    }
    //Waits till the user has submitted a form to be signed up or or logged in
    if($_POST)
    {
        //Empty input error handling for email and password incase jquery is not enabled
        if($_POST['email'] == "")
        {
            $errorMessage .= "<br>An email was not entered";
        }
        if($_POST['pass'] == "")
        {
            $errorMessage .= "<br>A password was not entered";
        }
        //If their are no errors than proceed to try and connect to the database
        if($errorMessage == "")
        {
            $link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
            if(mysqli_connect_error())
            {
                die("There was an error");
            }
            else
            {
                //Sign up query section
                if($_POST['login-type'] == "Sign Up")
                {
                    $query = "SELECT * FROM users WHERE email = '".$_POST['email']."'";
                    $result = mysqli_query($link,$query); 
                    $row = mysqli_fetch_array($result);
                    //If the size of the row is not zero that means there is already an account with that email in the database
                    if(sizeof($row) != 0)
                    {
                        $errorMessage = "Email already exists, please try another.";
                        $errorMessage = '<div class="alert alert-danger" role="alert"><strong>There were error(s): </strong><br>'.$errorMessage.'</div>';
                    }
                    else
                    {
                        //Hashes the user's password
                        $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                        $query = "INSERT INTO `users` (`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$hash)."')";
                        $result = mysqli_query($link,$query); 
                        $_SESSION['email'] = $_POST['email'];
                        header("Location:diary-page.php");
                    } 
                }
                else //Login query section
                {
                    $query = "SELECT * FROM users WHERE email = '".$_POST['email']."'";
                    $result = mysqli_query($link,$query); 
                    $row = mysqli_fetch_array($result);
                    //If there is an account with that email than proceed to verifying the password
                    if(array_key_exists("id",$row))
                    {
                        //Verify the password
                        if(password_verify($_POST['pass'],$row['password']))
                        {
                            $_SESSION['email'] = $_POST['email'];
                            header("Location:diary-page.php");
                        }
                        else
                        {
                            $errorMessage = "Incorrect password, please try again.";
                            $errorMessage = '<div class="alert alert-danger" role="alert"><strong>There were error(s): </strong><br>'.$errorMessage.'</div>';
                        } 
                    }
                    else
                    {
                        $errorMessage = "Email does not exist, please try again.";
                        $errorMessage = '<div class="alert alert-danger" role="alert"><strong>There were error(s): </strong><br>'.$errorMessage.'</div>';
                    } 
                }
            }
        }
        else
        {
            $errorMessage = '<div class="alert alert-danger" role="alert"><strong>There were error(s): </strong>'.$errorMessage.'</div>';
        }
    }
?>