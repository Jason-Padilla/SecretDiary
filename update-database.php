<?php
    session_start();
    $link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASE);
    $query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE email = '".$_SESSION['email']."'";
    mysqli_query($link, $query)
?>