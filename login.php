<?php
// Start a session
session_start();

include 'head.php';
include 'validation.php';

// define variables and set to empty values
$email = $password = "";
$emailErr = $passwordErr = "";

if (isset($_POST['submitted']))
{
    $email = test_input($_POST["email"]);

    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
    } else {
    $email = test_input($_POST["email"]);
    }
    
    if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
    } else {
    $password = md5(test_input($_POST["password"]));
    }

    // Check is the user details passes validation
    if ($email && $password)
    {
        $fileName = 'database/' . $email . ".json";

        // Checks if the user exists
        if (!file_exists($fileName))
        {
            echo "<div class='container'><div class='row'><div class='col-xs-6'><div class='alert alert-danger'>User doesn't exist</div></div></div></div>";
        } else {
            //Opens the user file
            $myFile = fopen($fileName, "r") or die("Unable to open file!");
            $userData = fread($myFile, filesize($fileName));
            $userArray = json_decode($userData, true);
            fclose($myFile);

            // Check if the input password matches the user password
            if ($password == $userArray['password'])
            {
                $_SESSION['isLogged'] = "1";
                $_SESSION['email'] = $email;
                
                if (isset($_SESSION['email']))
                {
                    header("Location:home.php");
                }
            } else {
                echo "<div class='container'><div class='row'><div class='col-xs-6'><div class='alert alert-danger'><p>Password doesn't match</p></div></div></div></div>";
            }
        }
        
        
    }
    
    
}
?>

<html>
    <body>
        <div class="container">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="page-header">
                            <h1>User login</h1>
                        </div>                  
                        <div class="clearfix">
                            <div class="pull-right">
                                <p><a href="index.php" role="button" class="btn btn-info">Home</a></p>
                            </div>
                        </div>  
                    </div>
                </div> 
                <div class="row"> 
                    <div class="col-xs-6">              
                        <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                    <span class="error text-danger"><?php echo $emailErr;?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                    <span class="error text-danger"><?php echo $passwordErr;?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <a href="passwordreset.php" class="text-warning">Password reset</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="submitted">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>  
</html>