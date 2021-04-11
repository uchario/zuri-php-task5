<?php
include 'head.php';
include 'validation.php';

// define variables and set to empty values
$email = $password = '';
$emailErr = $passwordErr = '';

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
            $myFile = fopen($fileName, "r+") or die("Unable to open file!");
            $userData = fread($myFile, filesize($fileName));
            $userArray = json_decode($userData, true);
            $newUserData = [
                'firstName' => strtolower($userArray['firstName']),
                'lastName' => strtolower($userArray['lastName']),
                'email' => strtolower($userArray['email']),
                'password' => $password
            ];
            fclose($myFile);

            file_put_contents('database/' . $newUserData['email'] . ".json", json_encode($newUserData));

            echo "<div class='container'><div class='row'><div class='col-xs-6'><div class='alert alert-success'>Password changed successfully</div></div></div></div>"; 

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
                        <div class="page-header text-danger">
                            <h2>Password Reset</h2>
                        </div>
                        <div class="clearfix">
                            <div class="pull-right">
                                <p><a href="index.php" role="button" class="btn btn-info">Home</a></p>
                            </div>
                        </div>
                        <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                    <span class="error text-danger"><?php echo $emailErr;?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">New password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="New password">
                                    <span class="error text-danger"><?php echo $passwordErr;?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger" name="submitted">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>