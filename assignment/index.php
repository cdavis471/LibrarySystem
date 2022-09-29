<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link rel="stylesheet" href="assets/style/global.css"/>
    </head>
    <header>
        <h1>Library</h1>
        <!-- php header: check login -->
        <?php
            //session start
            session_start();
            //connecting to database
            //connecting to database
            require_once "database.php";
            error_reporting(E_ERROR | E_PARSE);
            //check login
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                //tell user who they are logged in as
                echo 'Logged in as: <b>' . $_SESSION['Username'] . '</b> - <a href="login.php">Logout</a> / <a href="register.php">Register</a>' . '';
            }//end if 
            //if not logged in
            else
            {
                //display login / register
                echo '<b><a href="login.php">Login</a> / <a href="register.php">Register</a>' . '</b>';
            }//end else
        ?>
    </header>
    <body>
        <!-- php: check for login -->
        <?php
            //check if user logged in
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                //display options
                echo '<h4><a href="search_book.php">Search For Book</a></h4>';
                echo '<h4><a href="reserve_book.php">Reserve A Book</a></h4>';
                echo '<h4><a href="view_book.php">View Your Reserved Books</a></h4>';
            }//end if
            //if user not logged in
            else
            {
                //tell user they have must be logged in
                echo '<h4>Please <a href="login.php">Login</a> or <a href="register.php">Register</a></h4>';
            }//end else
        ?>
    </body>
    <footer>
        <!-- return to home -->
        <h4><a href="index.php">Home</a></h4>
        <h6>C20441826 - 2021</h6>
        <!-- close database connection -->
        <?php
            require_once "close.php";
        ?>
    </footer>
</html>