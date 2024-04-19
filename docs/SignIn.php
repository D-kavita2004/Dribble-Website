<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["username"])) {
    header('Location: welcome.php');
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = "Please enter username";
    } else {
        $username = trim($_POST['username']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter password";
    } else {
        $password = trim($_POST['password']);
    }

    // Proceed with login if no errors
    if (empty($username_err) && empty($password_err)) {
        $sql = 'SELECT id, username, password FROM users WHERE username = ?';
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Set session variables
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedIn"] = true;
                            echo $_SESSION["username"];
                            echo $_SESSION["loggedIn"];

                            // Redirect to welcome page
                            header('Location: welcome.php');
                            exit; // End script after redirect
                        } else {
                            $password_err = "Invalid Password";
                        }
                    }
                } else {
                    $username_err = "User not found";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="robots" content="index, follow" />
   <meta name="description" content="Sign In Here">
   <meta name="author" content="D kavita">
   <title>Sign Ip Page</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
      <section id="image-section">
            <img id="logo" src="dribbble_logo.webp" loading="lazy" alt="LOGO">
            <h1>Discover the World's Top Designers & Creatives</h1>
            <img id="art" src="Dribble_art.webp" loading="lazy" alt="Art Work">
            <p>Art by Peter Tarka</p>
      </section>
      <section id="SignUp-Section">
         <div class="member">
            <p >Not Registered? <a id="SignInPage" href="index.php">Sign Up</a></p>
         </div>
        <div class="SignUp-form">
         <h2>Sign In to Dribbble</h2>
         <form action="" method="post">
            <div id="name-container">
               <div style="width: 100%; ">
                  <label for="username">Username</label>
                  <br>
                  <input type="text" name="username" id="username" required style="width: 95%;" placeholder="Enter Your Username Here....">
                  <span class="error"><?php echo "$username_err"; ?></span>
               </div>
            </div>
            <br><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required style="width: 95%;" placeholder ="Enter Password">
            <span class="error"><?php echo "$password_err"; ?></span>
            <br><br>
         <button type="submit">Sign In</button>
         </form>
         <br>
         <p>This site is protected by reCAPTCHA and the Google <span>Privacy Policy</span> and <span>Terms of Service</span>apply.</p>
        </div>
      </section>
</body>
</html>