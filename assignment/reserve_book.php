<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Reserve Book</title>
        <link rel="stylesheet" href="assets/style/global.css"/>
    </head>
    <header>
        <h1>Library</h1>
        <!-- php header: check login -->
        <?php
            //session start
            session_start();
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
        <h2>Reserve A Book</h2>
        <!-- php: check for login -->
        <?php
            //check if user logged in
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                require_once "database.php";
                //check if page has been accessed from search
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $sql = "SELECT BookTitle, Author, Reserved FROM books WHERE ISBN = '$id'";
                    $result = $connection->query($sql);
                    if($result->num_rows > 0)
                    {
                        //fetching result
                        $row = $result->fetch_assoc();
                        //if not reserved
                        if($row['Reserved'] == "N")
                        {
                            //tell user book is being reserved
                            echo "Reserving Book... " . $row['BookTitle'] . " by " . $row['Author'];
                            //take variables to be passed
                            $a = $connection->real_escape_string($_GET['id']);
                            $b = $connection->real_escape_string($_SESSION['Username']);
                            $c = $connection->real_escape_string(date('Y-m-d'));
                            //query to insert into reservations
                            $sql2 = "INSERT INTO reservations VALUES ('$a','$b','$c')";
                            $connection->query($sql2);
                            //query to update main table
                            $sql3 = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$a'";
                            $connection->query($sql3);
                            //return user
                            echo ('<br><br><a href="view_book.php">View Reservations</a>');
                        }//end if
                        //if reserved
                        else
                        {
                            echo "<h5>The item you have entered has already been reserved. Please enter another!</h5>";
                        }//end else
                    }//end if
                    //no results
                    else if(strlen($_GET['id']) > 0)
                    {
                        echo "<h5>This item does not exist in our database! Please check your entered ISBN.</h5>";
                    }//end else
                }//end if
                //if page has been clicked from index
                else
                {
                    //enter book isbn
                    echo '
                    <form method="post">
                    <div class="form">
                        <label for = "ISBN">Enter ISBN:</label>
                        <input type = "text" id = "ISBN" name = "ISBN" value=""><br>
                        <br>
                        <input type = "submit" value="Submit" name="submit">
                    </div> ';
                    $id = $_POST['ISBN'];
                    $sql = "SELECT Reserved, BookTitle, Author FROM books WHERE ISBN = '$id'";
                    $result = $connection->query($sql);
                    if($result->num_rows > 0)
                    {
                        //fetching result
                        $row = $result->fetch_assoc();
                        //if not reserved
                        if($row['Reserved'] == "N")
                        {
                            //tell user book is being reserved
                            echo "Reserving Book... " . $row['BookTitle'] . " by " . $row['Author'];
                            //take variables to be passed
                            $a = $connection->real_escape_string($_POST['ISBN']);
                            $b = $connection->real_escape_string($_SESSION['Username']);
                            $c = $connection->real_escape_string(date('Y-m-d'));
                            //query to insert into reservations
                            $sql2 = "INSERT INTO reservations VALUES ('$a','$b','$c')";
                            $connection->query($sql2);
                            //query to update main table
                            $sql3 = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$a'";
                            $connection->query($sql3);
                            //return user
                            echo ('<br><br><a href="view_book.php">View Reservations</a>');
                        }//end if
                        //if reserved
                        else
                        {
                            echo "<h5>The item you have entered has already been reserved. Please enter another!</h5>";
                        }//end else
                    }//end if
                    //no results
                    else if(strlen($_POST['ISBN']) > 0)
                    {
                        echo "<h5>This item does not exist in our database! Please check your entered ISBN.</h5>";
                    }//end else
                }//end else
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