<?php
    session_start();
    //This will send the user back to the login-page if they try to enter a diary without having first been logged in
    if(!$_SESSION['email'])
    {
        header("Location:login-page.php");
    }
    //Waits until their is a submitted form(in this case it being logging out), it clears the session and then returns to the login-page
    if($_POST)
    {
        $_SESSION = [];
        header("Location:login-page.php");
    }

    $diaryContent = "";
    //This is the query that loads the users' diary so that they can be displayed in the textarea 
    $link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
    $query = "SELECT * FROM `users` WHERE email = '".$_SESSION['email']."'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    
    $diaryContent = $row["diary"];
?>