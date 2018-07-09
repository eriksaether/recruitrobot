<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Recruit Robot - Sign Up</title>
  <link rel="stylesheet" type="text/css" href="signup.css" />
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
    <h1 class="centerh1 white"> &#9784 Recruit Robot </h1>

<?php
  require_once('appvars.php');
  require_once('connectvars2.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
     header("Refresh:3; url=login.php");
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM mismatchuser WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO mismatchuser (username, first_name, last_name, password, join_date) VALUES ('$username', '$firstname','$lastname', SHA('$password1'), NOW())";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p class="mirror">Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="mirror">An account already exists for this username. Please use a different address.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="mirror">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }

  mysqli_close($dbc);

  //add later <label for="email">Email</label><br><input placeholder="foo@veryhighbar.com" type="text" name='email' id='email'/><br>
?>


  <div class="formblock">
    <h2 class="centerh2">Registration Info</h1>
    <form class="formlines" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" placeholder="e.g. bugsbunny"  /><br />
                <label for="firstname">First name:</label>
        <input type="text" id="" name="firstname" value="<?php if (!empty($firstname)) echo $firstname; ?>" placeholder=""  /><br />
        <label for="lastname">Last name:</label>
        <input type="text" id="" name="lastname" value="<?php if (!empty($lastname)) echo $firstname; ?>" placeholder=""  /><br />
        <label for="password1">Password:</label>
        <input type="password" id="password1" name="password1" /><br />
        <label for="password2">Password (retype):</label>
        <input type="password" id="password2" name="password2" /><br />
        <input type="submit" class="spacing buttonset" value="Sign Up" name="submit" />
        <i class="inote">Please note: this website does not need your email address</i>
    </form>
  </div>

  <p class="loginbelow">Already have an account?<a href="login.php">Login</a>></p>
</body> 
</html>

