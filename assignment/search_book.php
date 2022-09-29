<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Search For Book</title>
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
        <h2>Search For Book</h2>
        <!-- php: check for login -->
        <?php
            //check if user logged in
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                //show form
                echo '
                <form method="post">
                <div class="form">
                    <label for = "book_title">Enter Book Title:</label>
                    <input type = "text" id = "book_title" name = "book_title" value=""><br>
                    <br>
                    <label for = "book_author">Enter Book Author:</label>
                    <input type = "text" id = "book_author" name = "book_author" value=""><br>
                    <br>
                    <label for = "book_category">Select Book Category:</label>
                    <select id = "book_category" name = "book_category">
                        <option value = ""></option>
                        <option value = "1">Health</option>
                        <option value = "2">Business</option>
                        <option value = "3">Biography</option>
                        <option value = "4">Technology</option>
                        <option value = "5">Travel</option>
                        <option value = "6">Self-Help</option>
                        <option value = "7">Cookery</option>
                        <option value = "8">Fiction</option>
                    </select><br>
                    <br>
                    <input type = "submit" value="Submit" name="submit">
                </div> ';
                //store variables
                $book_title = $connection->real_escape_string($_POST['book_title']);
                $book_author = $connection->real_escape_string($_POST['book_author']);
                $book_category = $connection->real_escape_string($_POST['book_category']);
                //search for title, author, category
                if((strlen($_POST["book_title"]) > 0) && (strlen($_POST["book_author"]) > 0) && is_numeric($_POST["book_category"]))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.BookTitle LIKE '%$book_title%') and (books.Author LIKE '%$book_author%') and (books.Category LIKE '%$book_category%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//endif
                //search for title, author
                else if((strlen($_POST["book_title"]) > 0) && (strlen($_POST["book_author"]) > 0))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.BookTitle LIKE '%$book_title%') and (books.Author LIKE '%$book_author%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //search for title, category
                else if((strlen($_POST["book_title"]) > 0) && is_numeric($_POST["book_category"]))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.BookTitle LIKE '%$book_title%') and (books.Category LIKE '%$book_category%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //search for author, category
                else if((strlen($_POST["book_author"]) > 0) && is_numeric($_POST["book_category"]))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.Author LIKE '%$book_author%') and (books.Category LIKE '%$book_category%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //search for title
                else if(strlen($_POST["book_title"]) > 0)
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.BookTitle LIKE '%$book_title%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //search for author
                else if(strlen($_POST["book_author"]) > 0)
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.Author LIKE '%$book_author%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //search for category
                else if(is_numeric($_POST["book_category"]))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID WHERE (books.Category LIKE '%$book_category%')";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else if
                //display all books when hitting submit
                else if(isset($_POST['submit']))
                {
                    //query
                    $sql = "SELECT books.ISBN, books.BookTitle, books.Author, books.Edition, books.Year, books.Reserved, categories.CategoryDesc FROM books INNER JOIN categories ON books.Category = categories.CategoryID";
                    $result = $connection->query($sql);
                    //allow table to be shown
                    $show = 1;
                }//end else
                //display table
                if($result->num_rows > 0 && $show == 1)
                {
                    //title
                    echo '<h4>Results:</h4>';
                    //print table in while loop
                    echo '<table class="center">';
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr><td>";
                        echo ("ISBN: " . htmlentities($row["ISBN"]));
                        echo "</td><td>";
                        echo (htmlentities($row["BookTitle"]));
                        echo "</td><td>";
                        echo (htmlentities($row["Author"]));
                        echo "</td><td>";
                        echo ("Edition " . htmlentities($row["Edition"]));
                        echo "</td><td>";
                        echo ("Published in " . htmlentities($row["Year"]));
                        echo "</td><td>";
                        echo (htmlentities($row["CategoryDesc"]));
                        echo "</td><td>";
                        //check if reserved
                        if($row["Reserved"] == "Y")
                        {
                            echo ("N/A");
                            echo "</td></tr>\n";
                        }//end if
                        //if not reserved
                        else
                        {   
                            //allow user to reserve
                            $_SESSION['Reserve'] = $row["ISBN"]; 
                            echo ('<a href="reserve_book.php?id='.htmlentities($row["ISBN"]).'">Reserve</a>');
                            echo "</td></tr>\n";
                        }//end else
                    }//end while
                    //close table
                    echo "</table>";
                }//end if
                //if no results
                else if($show == 1)
                {
                    //tell user no results
                    echo "0 Results.";
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