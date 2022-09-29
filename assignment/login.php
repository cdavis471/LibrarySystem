<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="assets/style/global.css"/>
    </head>
    <header>
        <h1>Library</h1>
        <!-- php header: check login -->
        <?php
            //session start
            session_start();
            //unsets user on login page
            unset($_SESSION["Username"]);
            //connecting to database
            require_once "database.php";
            error_reporting(E_ERROR | E_PARSE);
            //check login
            if(isset($_SESSION['Username']) && isset($_SESSION['Password']))
            {
                //tell user who they are logged in as
                echo '<h4>Logged in as: ' . $_SESSION['Username'] . ' - <a href="login.php">Logout</a> / <a href="register.php">Register</a>' . '</h4>';
            }//end if 
            //if not logged in
            else
            {
                //display login / register
                echo '<h4><a href="login.php">Login</a> / <a href="register.php">Register</a>' . '</h4>';
            }//end else
        ?>
    </header>
    <body>
        <!-- php: check if user entered login details -->
        <?php
            //checking login credentials
	        if (isset($_POST["Username"]) && isset($_POST["Password"])) 
            { 
                //store user input
                $entered_user = $_POST['Username'];
                $entered_pass = $_POST['Password'];
                //run queries to check for valid username then user password
                $sql = "SELECT Username FROM users WHERE Username = '$entered_user'";
                $sql2 = "SELECT Password FROM users WHERE Username = '$entered_user' and Password = '$entered_pass'";
                //store results in variables
                $result = $connection->query($sql);
                $result2 = $connection->query($sql2);
                //check to see if there is a result for valid username
                if($result->num_rows > 0)
                {
                    //check to see if a valid password has been entered for that username
                    if($result2->num_rows > 0)
                    {
                        //store session
                        $_SESSION['Username'] = $entered_user;
                        $_SESSION['Password'] = $entered_pass;
                        //reset variables
                        $entered_user = 0;
                        $entered_pass = 0;
                        //allow user to proceed
                        echo '<h5>Login Successful - '.'<a href="index.php">Proceed</a></h5>';
                    }//end if
                    //if an invalid password was entered for the valid username
                    else
                    {
                        //tell user they have entered an invalid password
                        echo '<h5>Invalid Password! Please try again.</h5>';
                    }//end else
                }//end else
                //if an invalid username is entered
                else
                {
                    //tell user they have entered an invalid username
                    echo '<h5>Invalid Username! Please try again.</h5>';
                }//end else
            }//end if
        ?>
        <!-- take user input for login -->
        <form method="post">
        <div class="form">
            <label for = "Username">Enter Username:</label>
            <input type = "text" id = "Username" name = "Username"><br>
            <br>
            <label for = "Password">Enter Password:</label>
            <input type = "text" id = "Password" name = "Password"><br>
            <br>
            <input type = "submit" value="Login" name="submit">
        </div>
        <h5>No Account? <a href="register.php">Register</a></h5>
    </form>
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