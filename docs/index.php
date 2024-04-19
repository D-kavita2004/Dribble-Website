<?php
require_once "config.php";

$name = $username = $email = $password = "";
$name_err = $username_err = $email_err = $password_err = "";
$showAlert = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

   // check if username is empty
   if(empty(trim($_POST['username']))) {
      $username_err = "username cannot be blank";
   }
   elseif(!preg_match('/^[a-zA-Z0-9]{3,15}$/', trim($_POST['username']))){
      $username_err = "Username can contain alphabets and numbers only, and must be between 3 and 15 characters long";
  }
   else{
      $sql ="SELECT id FROM users WHERE username = ?";
      $stmt = mysqli_prepare($conn,$sql);
      if($stmt){
         mysqli_stmt_bind_param($stmt,"s",$param_username);
         //set the value of param username
         $param_username = trim($_POST['username']);

         //try to execute the statement 
         if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt)==1){
               $username_err = "This username is already taken";
            }
            else{
               $username = trim($_POST['username']);
            }
         }
         mysqli_stmt_close($stmt);
      }
      // $conn->close();
      
   }
      //check for email
   if(empty(trim($_POST['email']))){
      $email_err = "Email can't be blank";
   }
   elseif(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
   } else{
      $sql ="SELECT id FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn , $sql);
      if($stmt){
         mysqli_stmt_bind_param($stmt, "s", $param_email);
         //set the value of param username
         $param_email = trim($_POST['email']);

         //try to execute the statement 
         if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt)==1){
               $email_err = "Email is already registered";
            }
            else{
               $email = trim($_POST['email']);
            }
         }
         mysqli_stmt_close($stmt);
      }
      
   }

   //check for name
   if(empty(trim($_POST["name"]))){
      $name_err = "Name can't be blank";
   }
   elseif (!preg_match('/^[a-zA-Z\s]{3,25}$/', trim($_POST['name']))) {
      $name_err = "Only Alphabets and and length must be between 3 and 25";
   }
   else{
      $name = trim($_POST['name']);
   }

   //check for password
   if(empty(trim($_POST["password"]))){
      $password_err = "password can't be blank";
   }
   elseif(!preg_match('/^[a-zA-Z0-9!@#$%^&*()-_=+{};:,<.>]{3,12}$/', trim($_POST['password']))){
      $password_err = "password should be strong and must be between 3 and 15 characters long";
   }
   else{
      $password = trim($_POST['password']);
   }

   // If there are no errors ,then insert into the database
   if(empty($username_err) && empty($email_err) && empty($password_err) && empty($name_err)){
      $sql = 'INSERT INTO users (name, username, email, password) VALUES(?, ?, ?, ?)';
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
         mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_username, $param_email, $param_password);

         //setting the parameters
         $param_name = $name;
         $param_username = $username;
         $param_email = $email;
         $param_password = password_hash($password, PASSWORD_DEFAULT);

         //Trying to execute 
         if(mysqli_stmt_execute($stmt)){
            header("Location: SignIn.php");
         }
         // else{
         //    echo "Something went wrong... cannot redirect";
         // }
         mysqli_stmt_close($stmt);
      }
      $showAlert = true;
   }
   else{
      // echo "$name_err";
      // echo "$username_err";
      // echo "$email_err";
      // echo "$password_err";
      // echo "Data not sent to database";
   }

mysqli_close($conn);
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="robots" content="index, follow" />
   <meta name="description" content="Sign Up Here">
   <meta name="author" content="D kavita">
   <title>Sign Up Page</title>
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
            <p >Already a member? <a id="SignInPage" href="SignIn.php">Sign In</a></p>
         </div>
        <div class="SignUp-form">
         <h2>Sign Up to Dribbble</h2>
         <form action=" " method="POST">
            <div id="name-container">
               <div style="width: 50%;">
                  <label for="name">Name</label>
                  <br>
                  <input type="text" name="name" id="name" required style="width: 90%;">
                  <span class="error"><?php echo $name_err; ?></span>
               </div>
               <div style="width: 50%; ">
                  <label for="username">Username</label>
                  <br>
                  <input type="text" name="username" id="username" placeholder="user123" required style="width: 90%;">
                  <span class="error"><?php echo $username_err; ?></span>
               </div>
            </div>
            <br><br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required style="width: 95%;">
            <span class="error"><?php echo $email_err; ?></span>
            <br><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required style="width: 95%;">
            <span class="error"><?php echo $password_err; ?></span>
            <br><br>
           <label id="checkbox" ><input type="checkbox" name="check" required >Creating an account means you're okay with our <span class="text">Terms of Service, Privacy Policy,</span> and our default <span class="text">Notification Settings.</span></label>
         <br><br>
         <button type="submit">Create Account</button>
         </form>
         <br>
         <p>This site is protected by reCAPTCHA and the Google <span class="text">Privacy Policy</span> and <span class="text">Terms of Service</span>apply.</p>
        </div>
      </section>
</body>
</html>