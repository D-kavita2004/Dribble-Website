<?php
session_start();

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
   header('Location:SignIn.php');
}
require_once "config.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/"; // Directory where uploaded images will be stored
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" &&
        $imageFileType != "jpeg" && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is OK, try to upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

            // Sanitize user input for location
            $user_location = mysqli_real_escape_string($conn, trim($_POST['Location']));
            $username = $_SESSION['username']; // Assuming you have already started the session

            // Prepare SQL statement for updating data
            $stmt = $conn->prepare("UPDATE users SET image_path = ?, Location = ? WHERE username = ?");
            if ($stmt === false) {
                echo "Error preparing SQL statement: " . $conn->error;
            } else {
                // Bind parameters and execute statement
                $stmt->bind_param("sss", $imagePath, $user_location, $username);
                $imagePath = $target_file; // Use the uploaded file path
                if ($stmt->execute()) {
                    echo "Records updated successfully.";
                    $_SESSION["imagePath"] =  $imagePath;
                    header('Location:purpose.php');
                    exit;
                } else {
                    echo "Error executing SQL statement: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Profile creation with Dribble">
    <meta name="author" content="D.kavita">
    <title>Create Profile</title>
   <style>
       *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        html,body{
            height: 100vh;
            width: 100vw;
            display: flex;
         align-items: center;
         justify-content: center;
        }
        .CreateProfile{
         width: 60%;
         height: 85%;
         /* background-color: aqua; */
         position: relative;
         margin-top: 30px;
        }
        h1{
         font-size: 7vmin;
        }
        #logo {
         position: absolute; 
         top: 1px; 
         left: 10px;
         width: 15vmin;
         height: 7vmin;
         mix-blend-mode: multiply;
        }
        #logout{
         position: absolute; 
         top: 10px; 
         right: 10px;
         text-decoration: none;
         color: #db286d;
         font-size: 4vmin;
        }
        p{
         margin-top: 6px;
         font-size: 3.5vmin;
        }
        .profile-pic img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        } 
        .profile-pic{
         width: 200px;
         height: 200px;
         border-radius: 50%;
         margin-top:20px;
         margin-bottom: 20px;
         border: 2px dashed black;
        }
        h2{
         margin-top: 20px;
         font-size: 4vmin;
        }
        #image-container{
         width: 100%;
         /* background-color: #db286d; */
         display: flex;
         align-items: center ;
         justify-content: space-between;
        }
        #image-container input{
         font-size: 4vmin;
        }
        .profile-pic input[type="file"] {
    position: absolute; /* Changed position to absolute */
    top: 0; /* Positioned at the top */
    left: 0; /* Positioned at the left */
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    opacity: 0; /* Hide the input visually */
    cursor: pointer;
    
}
      #location-container{
         margin-top: 5vh;
         font-size: 5vmin;
         display: flex;
         flex-direction: column;
      }
      #location{
         margin-top: 3vmin;
         border: none;
         border-bottom: 2px solid black;
         height: 6vmin;
         outline: none;
         font-size: 5vmin;
      }
      button{
         margin-top: 3vmin;
         height: 7vmin;
         width: 20vmin;
         font-size: larger;
         border-radius: 10px;
         background-color: rgba(219, 40, 109, 0.5);
         color: white;
         margin-top: 3vmin;
      }
        @media (max-width:800px) {
         .CreateProfile{
            width: 90%;
            height: 85%;
         }
         .CreateProfile p{
            font-size: 6vmin;
            margin-top: 2.5vh;
         }
         #image-container{
         width: 100%;
         display: flex;
         flex-direction: column;
         justify-content:center;
        }
        #image-container input{
         margin-left: 13vmax;
        }
        h2{
         text-align: center;
         font-size: 6vmin;
         margin-top: 9vmin;
        }
        h1{
         margin-top:3vmin;
         font-size: 10vmin;
        }
        .profile-pic{
         width: 170px;
         height: 170px;
        }
        button{
         height:10vmin;
         width: 25vmin;
         margin-top:6vmin
        }
        #logo{
         height: 14vmin;
         width: 24vmin;
        }
        #logout{
         font-size: 7vmin;
        }
        #location-container label{
         font-size: 7vmin;
        }
      }
   </style>
</head>
<body>
   <img id ="logo" src="pink-logo-dribbble.webp" alt="dribble-logo">
   <a id="logout" href="logout.php">LogOut</a>
   <section class="CreateProfile">
      <h1>Welcome! Let's create your profile</h1>
      <p>Let others get to know you better! You can do these later</p>
      <h2>Add an avatar</h2>
      <form action="" method="post" enctype="multipart/form-data">
         <div id="image-container">
            <div class="profile-pic">
               <img id="uploaded-image" src="#">
            </div>
            <input type="file" accept="image/*" id="upload-input" name="image" required>
      </div>
         <div id="location-container">
               <label for="location">Add Your Location</label>
               <input type="text" id="location" name="Location" placeholder="Enter a location" required minlength="3">
         </div>
     <a href="purpose.php"><button id="submit-button" type="submit" disabled>Next</button></a>
      </form>
     
   </section>
   <script>
   const locationInput = document.getElementById('location');
   const uploadInput = document.getElementById('upload-input');
   const uploadedImage = document.getElementById('uploaded-image');
   const submitButton = document.getElementById('submit-button');

      uploadInput.addEventListener('change', function(event) {
         const file = event.target.files[0];
         const reader = new FileReader();

         reader.onload = function(e) {
            uploadedImage.src = e.target.result;
         };
         reader.readAsDataURL(file);
      });

      document.addEventListener('DOMContentLoaded', function() {

   locationInput.addEventListener('input', checkFields);
   uploadInput.addEventListener('input', checkFields);

   function checkFields() {
      const locationValue = locationInput.value.trim();
      const file = uploadInput.files[0];

      if (locationValue !== '' && file!=="") {
         submitButton.disabled = false;
         submitButton.style.backgroundColor ="rgb(219, 40, 109)";
      } else {
         submitButton.disabled = true;
      }
   }
   checkFields();
});

   </script>
</body>
</html>