<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Reserved Book</title>
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
            //error_reporting(E_ERROR | E_PARSE);
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
        <h2>View Your Reserved Books</h2>
        <!-- php: check for login -->
        <?php
            //check if user logged in
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                //take username
                $username = $_SESSION['Username'];
                //call reserved books of user
                $sql = "SELECT ISBN, UserName, ReservedDate FROM reservations WHERE UserName = '$username'";
                $result = $connection->query($sql);
                //check for results
                if($result->num_rows > 0)
                {
                    //store data
                    $i = 0;
                    $j = $result->num_rows;
                    $k = 0;
                    $store_isbn = array();
                    $store_date = array();
                    //fetch rows
                    while($row = $result->fetch_assoc())
                    {
                        //store isbn
                        $store_isbn[$i] = htmlentities($row["ISBN"]);
                        //store reserved date
                        $store_date[$i] = htmlentities($row["ReservedDate"]);
                        $i = $i + 1;
                    }//end while
                    //for loop to display results
                    echo '<table class="center">';
                    for($k = 0;$k < $j; $k++)
                    {
                        //query
                        $sql2 = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE ISBN = '$store_isbn[$k]'";
                        $result2 = $connection->query($sql2);
                        echo "<tr><td>";
                        while($row2 = $result2->fetch_assoc())
                        {
                            echo ("ISBN: " . htmlentities($row2["ISBN"]));
                            echo "</td><td>";
                            echo (htmlentities($row2["BookTitle"]));
                            echo "</td><td>";
                            echo (htmlentities($row2["Author"]));
                            echo "</td><td>";
                            echo ("Edition " . htmlentities($row2["Edition"]));
                            echo "</td><td>";
                            echo ("Published in " . htmlentities($row2["Year"]));
                            echo "</td><td>";
                            echo (htmlentities($row2["CategoryDesc"]));
                            echo "</td><td>";
                            echo ("Reserved: " . $store_date[$k]);
                            echo "</td><td>";
                            echo ('<a href="reserve_delete.php?id='.htmlentities($row2["ISBN"]).'">Delete</a>');
                        }//end while
                    }//end for
                    echo "</td></tr>\n";
                    //close table
                    echo "</table>";
                }//end if
                //if no books reserved
                else
                {
                    echo "No books currently reserved.";
                }
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