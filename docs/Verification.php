<?php
session_start();

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
   header('Location:SignIn.php');
}
require_once "config.php";

// Assuming you have already started the session
$username = $_SESSION['username'];

$sql = "SELECT email FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $email = $row["email"];
        // Store email in session for later use
        $_SESSION['email'] = $email;
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Dribble Email Verification">
    <meta name="author" content="D kavita">
    <title>Verify Here</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
   *{
       margin: 0;
       padding: 0;
       box-sizing: border-box;
       font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
   }
   html,body{
       height: 100%;
       width: 100%;
   }
   header,main{
       width: 100%;
   }
  #my_nav_bar {
       width: 100%;
       display: flex;
       align-items: center;
       justify-content: space-between;
       padding-left:2vw;
       box-shadow:3px 3px 6px black ;
       height: 8vmin;
       box-sizing: border-box;
   }
   nav ul{
       list-style-type: none;
       display: flex;
       /* background-color: rgb(0, 255, 55); */
       /* gap: 1vw; */
       margin-right: 2vmin;
       height: 100%;
       padding-top: 3vmin;

   }
   li{
       font-size: 3vmin;
       font-style: italic;
       /* background-color: aqua; */
       height: 6vmin;
       width: 18vmin;
       text-align: center;
       padding: 2px;

   }
   li a{
       height: 100%;
       text-decoration: none;
       color: black;
   }
   nav img{
      width: 20vmin;
      height: 100%;
   }
   #left_ul{
    margin-left: -240px;
   }
   #left_ul li:hover{
       background-color: rgb(199, 197, 197);
       border-radius: 10px;
       box-shadow:2px 2px 4px black ;
   }
   #right_ul li{
      display: flex;
     align-items: center;
     justify-content: center;
     margin-top: -10px;
   }
   .sideBar{
       position: fixed;
       top: 0;
       right: 0;
       height: 100vh;
       width: 50vmin;
       z-index: 999;
       display: none;
       flex-direction: column;
       box-shadow:2px 2px 4px black ;
       align-items: flex-start;
       justify-content: flex-start;
       background-color: rgba(255, 255, 255, 0.658);
       backdrop-filter: blur(7px);
   }
   .sideList{
       display: flex;
       flex-direction: column;
       width: 100%;
       /* background-color: aqua; */
       margin-top: 7vmax;
   }
   .sideList li{
      /* background-color: aquamarine; */
      width: 100%;
      text-align: left;
      font-size: 4vmin;
      font-style: italic;
      font-weight: bolder;
      margin: 3vmin;
   }
   .sideList li:hover{
       background-color: rgb(199, 197, 197);
       border-radius: 10px;
       box-shadow:2px 2px 4px black ;
   }
   .hover-effect:hover{
       background-color:  rgb(221, 77, 132);
       box-shadow:2px 2px 4px black ;
   }
   .Hide{
       display:none;
       margin-right: 5vw;
       /* font-size: 4vh; */
   }

   .button{
       height: 9vmin;
       width: 18vmin;
       border-radius: 10px;
       border: 2px solid black;
       background-color:  rgb(219, 40, 109);
       color: aliceblue;
       box-shadow: 5px 5px 10px rgb(99, 105, 99);
       font-size: 3vmin;
       font-weight: bolder;
       font-style: italic;
   }
   .buttonSign{
       height: 90%;
       width: 15vmin;
       margin-bottom: 20%;
       border: 2px solid black;
       background-color:  rgb(219, 40, 109);
       color: aliceblue;
       box-shadow: 2px 2px 4px rgb(99, 105, 99);
       border-radius: 10px;
       font-size: 3vmin;
   }
   #my_nav_bar{
      justify-content: space-between;
   }
   #profile-picture{
         width: 60px;
         height: 60px;
         border-radius: 50%;
         /* margin-bottom: 20px; */
         border: 2px dashed black;
        }
        #profile-picture img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        } 
        .sideBar #profile-picture{
         position: absolute;
         top: 10px;
         right: 10px;
        }
        main{
            width: 100%;
            height: calc(100vh - 8vmin);
            /* background-color: aqua; */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #main-section{
            width: 75%;
            height: 90%;
            /* background-color: blue; */
            text-align: center;
            font-size: 4vmin;
            padding:10vmin;
        }
        span{
            color:rgb(219, 40, 109);
        }
        footer{
            width: 100%;
            background-color: #edf0f7;
            display: flex;
        }
        #logo-section{
            width: 30%;
            height: 100%;
        }
        #footer-section{
            width: 70%;
            height: 100%;
            display: flex;
            gap: 4vw;
        }
        #footer-section ul li{
            list-style-type: none;
            display: flex;
            flex-direction: column;
           text-align: left;
           margin: 8px;
        }
   @media (max-width:1000px) {
      nav ul{
       display: none;
      }
      .Hide{
       display: flex;
      }
      footer{
        display:grid;
      }
      #logo-section{
        width:100vw;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-item:center;
      }
      #footer-section{
        display:flex;
        flex-direction:column;
      }
      #footer-section ul{
        width:100%;
      }
      #footer-section ul li{
        width:100%;
        font-size:4vmin;
        text-align:center;
      }
   }
   @media (max-width:800px) {
       nav{
           height: 10vmax;
       }
       #left_ul{
    margin-right: -40px;
   }
   }

</style>
</head>
<body>
   <header>
      <nav id="my_nav_bar"> 
         <img src="pink-logo-dribbble.webp" alt="">
         <ul id="left_ul">
              <li><a href="#">Inspiration</a></li>
              <li><a href="#">Find Work</a></li>
              <li><a href="#">Learn Design</a></li>
              <li><a href="#">Go Pro</a></li>
              <li><a href="#">Hire Designers</a></li>
         </ul>
          <ul id="right_ul">
               <li><input type="search" name="search-item" id="search-item" placeholder="search here.."></li>
               <li><div id="profile-picture"><img src="<?php echo $_SESSION['imagePath']?>"></div></li>
               <button class="buttonSign">Upload</button>
          </ul>
          <i onclick="showSideBar()" class="fa-solid fa-bars hover-effect Hide" style="color: #1d1d1f; font-size:4vmax;margin-left: -80px;"></i>
      </nav>
      <nav class="sideBar">
          <i onclick="closeSideBar()" class="fa-solid fa-xmark hover-effect" style="color: #595b5f; font-size: 25px;"></i>
          <li><div id="profile-picture"><img src="<?php echo $_SESSION['imagePath']?>" alt=""></div></li>
          <ul class="sideList">
            <li><a href="#">Inspiration</a></li>
            <li><a href="#">Find Work</a></li>
            <li><a href="#">Learn Design</a></li>
            <li><a href="#">Go Pro</a></li>
            <li><a href="#">Hire Designers</a></li>
            <button class="buttonSign" style="height: 5%; width: 50%;" >Upload</button>
          </ul>
      </nav>
  </header>
  <main>
    <section id="main-section">
        <h1>PLease verify your email...</h1>
        <img src="mail_icon.webp" alt="mail" style="width:90px; height:90px;">
        <p>please verify your email address.we've sent a confirmation email to</p>
        <br>
        <h3><?php echo $_SESSION['email']; ?></h3>
        <br>
        <p>Click the confirmation link in that email to begin using dribble</p>
        <br>
       <p>Didn't receive the email? Check your spam folder, it may have been caught by a filter.If you still didn't see it.<span>resend the confirmation email</span></p>
       <br>
       <p>Wrong email address? <span>Change it.</span></p>
    </section>
  </main>
  <footer>
    <section id="logo-section">
        <img style="width: 90px; height: 40px; mix-blend-mode: multiply;" src="pink-logo-dribbble.jpg" alt="logo">
        <br><br>
        <p>Dribble is the world's leading community for creative to share grow and get hired</p>
        <br>
    </section>
    <section id="footer-section">
        <ul>
            <li><b>For Designers</b></li>
            <li>Go Pro!</li>
            <li>Design blog</li>
            <li>Overtime podcast</li>
            <li>Playoffs</li>
            <li>Weekly warm-up</li>
            <li>Refer a friend</li>
            <li>Refer a friend</li>
            <li>code of conduct</li>
        </ul>
        <ul>
            <li><b>Hire Designers</b></li>
            <li>Post a job opening</li>
            <li>Post a project</li>
            <li>search for designers</li>
            <br>
            <li><b>Brands</b></li>
            <li>Advertise with us</li>
        </ul>
        <ul>
            <li><b>Company</b></li>
            <li>About</li>
            <li>Careers</li>
            <li>Careers</li>
            <li>Support</li>
            <li>Medis kit</li>
            <li>Testimonials</li>
            <li>API</li>
            <li>Terms of service</li>
            <li>Privacy policy</li>
            <li>Cookie policy</li>
        </ul>
        <ul>
            <li><b>Directories</b></li>
            <li>Design jobs</li>
            <li>Freelane designers</li>
            <li>Tags</li>
            <li>Places</li>
            <li><b>Design assets</b></li>
            <li>Dribble marketplace</li>
            <li>Creative market</li>
            <li>fontspring</li>
            <li>Font squirrel</li>
        </ul>
        <ul>
            <li><b>Design resources</b></li>
            <li>Freelancing</li>
            <li>Design Hiring</li>
            <li>Design portfolio</li>
            <li>Design education</li>
            <li>creative process</li>
            <li>Design industry trends</li>
        </ul>
    </section>
  </footer>
  <script>
   function showSideBar(){
       document.querySelector(".sideBar").style.display="flex";
   }
   function closeSideBar(){
       document.querySelector(".sideBar").style.display="none";
   }
</script>
</body>
</html>
