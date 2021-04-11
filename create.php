<?php
include 'head.php';
include 'validation.php';

// define variables and set to empty values
$firstName = $lastName = $email = $password = "";
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email = test_input($_POST["email"]);
  
  if (empty($_POST["firstName"])) {
    $firstNameErr = "* First name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
    $firstNameErr = "Only letters and white space allowed";
  }
  else {
    $firstName = test_input($_POST["firstName"]);
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "* Last name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
    $lastNameErr = "Only letters and white space allowed";
  }
  else {
    $lastName = test_input($_POST["lastName"]);
  }
  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
  }
  else {
    $email = test_input($_POST["email"]);
  }
  if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  // Check if validation is passed and user doesn't exist
  if ($firstName && $lastName && $email && $password){
    if(!file_exists('database/' . $firstName . $lastName)){

      $firstName = strtolower($_POST['firstName']);
      $lastName = strtolower($_POST['lastName']);
      $email = strtolower($_POST['email']);
      $password = md5($_POST['password']);

      $arrayData = [
          'firstName' => $firstName,
          'lastName' => $lastName,
          'email' => $email,
          'password' => $password
      ];

      file_put_contents('database/' . $arrayData['email'] . ".json", json_encode($arrayData));

      echo "<div class='container'><div class='row'><div class='col-xs-6'><div class='alert alert-success'>User created successfully</div></div></div></div>";  
    } else {
      echo "<div class='container'><div class='row'><div class='col-xs-6'><div class='alert alert-danger'>User already exists</div></div></div></div>";
    }
  }
 
}
?>

<body>
  <div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-xs-6">
              <div class="page-header">
                <h1>Zuri Form</h1>
              </div>
              <div class="clearfix">
                <div class="pull-right">
                  <a href="index.php" role="button" class="btn btn-info">Home</a>
                </div>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="form-group">
                  <label for="firstName">First name</label>
                  <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
                  <span class="error text-danger"><?php echo $firstNameErr;?></span>
                </div>
                <div class="form-group">
                  <label for="lastName">Last name</label>
                  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
                  <span class="error text-danger"><?php echo $lastNameErr;?></span>
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  <span class="error text-danger"><?php echo $emailErr;?></span>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  <span class="error text-danger"><?php echo $passwordErr;?></span>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>
    </div>
  </div>
</body>