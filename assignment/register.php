<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="assets/style/global.css"/>
    </head>
    <header>
        <h1>Library</h1>
        <!-- php header: check login -->
        <?php
            //session start
            session_start();
            //unsets user on register page
            unset($_SESSION["Username"]);
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
        <!-- php: check all entered data and confirm new user -->
        <?php
            require_once "database.php";
            //checking that all entries have been filled
	        if (isset($_POST["Username"]) && isset($_POST["Password"]) && isset($_POST["CPassword"]) && isset($_POST["Firstname"]) && isset($_POST["Surname"]) && isset($_POST["AddressLineOne"]) && isset($_POST["AddressLineTwo"]) && isset($_POST["City"]) && isset($_POST["Telephone"]) && isset($_POST["Mobile"])) 
            {
                //store user input
                $entered_user = $connection->real_escape_string($_POST['Username']);
                $entered_pass = $connection->real_escape_string($_POST['Password']);
                //run queries to check if username already in use
                $sql = "SELECT Username FROM users WHERE Username = '$entered_user'";
                //store results in variables
                $result = $connection->query($sql);
                //check to see if valid
                if(($result->num_rows == 0) && (is_numeric($_POST["Mobile"])) && (is_numeric($_POST["Telephone"])) && (strlen($_POST["Password"]) == 6) && ($_POST["Password"] == $_POST["CPassword"]) && strlen($_POST["Mobile"]) == 10)
                {
                    //store info in variables to be passed
                    $a = $connection->real_escape_string($_POST['Username']);
                    $b = $connection->real_escape_string($_POST['Password']);
                    $c = $connection->real_escape_string($_POST['Firstname']);
                    $d = $connection->real_escape_string($_POST['Surname']);
                    $e = $connection->real_escape_string($_POST['AddressLineOne']);
                    $f = $connection->real_escape_string($_POST['AddressLineTwo']);
                    $g = $connection->real_escape_string($_POST['City']);
                    $h = $connection->real_escape_string($_POST['Telephone']);
                    $i = $connection->real_escape_string($_POST['Mobile']);
                    //insert new user into database
                    $sql = "INSERT INTO users (Username, Password, Firstname, Surname, AddressLineOne, AddressLineTwo, City, Telephone, Mobile) VALUES ('$a','$b','$c','$d','$e','$f','$g','$h','$i')";
                    $connection->query($sql);
                    //store session
                    $_SESSION['Username'] = $entered_user;
                    $_SESSION['Password'] = $entered_pass;
                    //reset variables
                    $entered_user = 0;
                    $entered_pass = 0;
                    //allow user to proceed
                    echo '<h5>Registration Successful - '.'<a href="index.php">Proceed</a></h5>';
                }//end else
                //check if there are any usernames matching in database
                else if($result->num_rows > 0)
                {
                    //tell user they have entered a username already in use
                    echo '<h5>Username is in use. Please try again.</h5>';
                }//end else if
                //if password is not 6 characters
                else if(strlen($_POST["Password"]) != 6 && strlen($_POST["Password"]) > 0)
                {
                    //tell user they have entered a username already in use
                    echo '<h5>Password is not six characters long. Please try again.</h5>';
                }//end else if
                //if password and confirm password aren't equal
                else if(($_POST["Password"] != $_POST["CPassword"]))
                {
                    //tell user they have entered a username already in use
                    echo '<h5>Please confirm your password correctly. Please try again.</h5>';
                }//end else if
                //if the mobile number is not numeric
                else if(strlen($_POST["Mobile"]) > 0)
                {
                    //tell user they have entered an invalid phone number
                    echo '<h5>Please make sure your telephone / mobile numbers only include digits and that your mobile is ten digits long.</h5>';
                }//end else
                else
                {
                    //tell user they have to fill all fields
                    echo '<h5>Make sure you fill out all fields.</h5>';
                }
            }//end if
            //if all fields have not been filled
            else
            {
                //tell user they have to fill all fields
                echo '<h5>Make sure you fill out all fields.</h5>';
            }//end else
        ?>
        <!-- take user input for registration -->
        <form method="post">
        <div class="form">
            <label for = "Username">Enter Username:</label>
            <input type = "text" id = "Username" name = "Username"><br>
            <br>
            <label for = "Password">Enter Password:</label>
            <input type = "text" id = "Password" name = "Password"><br>
            <br>
            <label for = "CPassword">Confirm Password:</label>
            <input type = "text" id = "CPassword" name = "CPassword"><br>
            <br>
            <label for = "Firstname">Enter Firstname:</label>
            <input type = "text" id = "Firstname" name = "Firstname"><br>
            <br>
            <label for = "Surname">Enter Surname:</label>
            <input type = "text" id = "Surname" name = "Surname"><br>
            <br>
            <label for = "AddressLineOne">Enter Address (Line 1):</label>
            <input type = "text" id = "AddressLineOne" name = "AddressLineOne"><br>
            <br>
            <label for = "AddressLineTwo">Enter Address (Line 2):</label>
            <input type = "text" id = "AddressLineTwo" name = "AddressLineTwo"><br>
            <br>
            <label for = "City">Enter City:</label>
            <input type = "text" id = "City" name = "City"><br>
            <br>
            <label for = "Telephone">Enter Telephone:</label>
            <input type = "text" id = "Telephone" name = "Telephone"><br>
            <br>
            <label for = "Mobile">Enter Mobile:</label>
            <input type = "text" id = "Mobile" name = "Mobile"><br>
            <br>
            <input type = "submit" value="Register" name="submit">
        </div>
        <h5>Already have an account? <a href="login.php">Login</a></h5>
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