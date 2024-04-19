<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Dribble Website, Select your purpose">
    <meta name="author" content="D kavita">
    <title>Select purpose</title>
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
         text-align: center;
        }
        #logo {
         position: absolute; 
         top: 10px; 
         left: 10px;
         width: 18vmin;
         height: 9vmin;
         mix-blend-mode: multiply;
        }
        p{
         margin-top: 6px;
         font-size: 4vmin;
         text-align: center;
        }
        h2{
         margin-top: 20px;
         font-size: 4vmin;
        }

      button{
         margin-top: 1vmin;
         height: 8vmin;
         width: 30vmin;
         font-size: 5vmin;
         border-radius: 10px;
         background-color: rgba(219, 40, 109, 0.5);
         color: white;
         margin-top: 2vmin;
      }
      #objective{
         /* background-color: blue; */
         width: 100%;
         height: 45%;
         display: flex;
         justify-content: space-between;
         margin-top: 4vh;
      }
      .image-options{
         border: 2px solid black;
         height: 90%;
         width: 30%;
         border-radius: 10px;
         box-shadow: 3px 3px 6px black;
         display: flex;
         flex-direction: column;
         text-align: center;
         justify-content: space-around;
      }
      #button-container{
         display: flex;
         justify-content: center;
        }
        .my_image{
         width: 100%;
         height: 50%;
        }
        .checked {
        border: 4px solid rgb(219, 40, 109);
    }

    .checked input[type="checkbox"] {
        background-color: rgb(219, 40, 109);
    }
    .my_checkbox{
      visibility: hidden;
    }
    .my_checkbox_selected{
      visibility: visible;
      background-color:rgb(219, 40, 109);
    }
        @media (max-width:1000px) {

        h1{
         font-size: 8vmin;
        }
        #button-container{
         margin-top: -3vh;
         display: flex;
         justify-content: center;
        }
        .CreateProfile{
         width: 80%;
         height: 85%;
         /* background-color: aqua; */
         position: relative;
         margin-top: 30px;
        }
        #objective{
         display: flex;
         flex-direction: column;
         align-items: center;
         height: 120vmin;
         margin-bottom: 4vmin;
        }
        .image-options{
         margin: 1.5vmin;
         width: 50vmin;
        }
        button{
         height:9vmin;
         width: 35vmin;
         margin-top: 7vmin;
        }
        #logo{
         height: 14vmin;
         width: 20vmin;
        }
        .anything{
         margin-top:25vmin;
        }
      }
   </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
   <img id ="logo" src="pink-logo-dribbble.webp" alt="dribble-logo">
   <section class="CreateProfile">
      <h1>What brings you to Dribble?</h1>
      <p>Select the option that best decribes you. Don't worry, you can explore other options later</p>
      <div id="objective">
         <div class="image-options" onclick="toggleCheckbox(this)">
             <img class="my_image" src="designer_work.png" alt="Image 1">
             <h3>I'm a designer looking to share my work</h3>
             <input type="checkbox" class="my_checkbox">
         </div>
         <div class="image-options" onclick="toggleCheckbox(this)">
             <img class="my_image" src="hire_designer.png" alt="Image 2">
             <h3>I'm looking to hire a designer</h3>
             <input type="checkbox" class="my_checkbox">
         </div>
         <div class="image-options" onclick="toggleCheckbox(this)">
             <img class="my_image" src="design_inspiration.png" alt="Image 3">
             <h3>I'm looking for design inspiration</h3>
             <input type="checkbox" class="my_checkbox">
         </div>
     </div>>

               <!-- <i id="icon" class="fas fa-check-circle" style="color: #e141b7;"></i> -->
      <p class="anything"><b>Anything else? You can select multiple</b></p>
     <div id="button-container">
      <a href="Verification.php"><button id="submit-button" type="submit" disabled>Finish</button></a>
     </div>
     
   </section>

   <script>
      function toggleCheckbox(container) {
          const checkbox = container.querySelector('input[type="checkbox"]');
          checkbox.checked = !checkbox.checked;
  
          if (checkbox.checked) {
              container.classList.add('checked');
          } else {
              container.classList.remove('checked');
          }
  
          checkFields(container); // Pass the container to checkFields
      }
  
      function checkFields(container) {
          const checkbox = container.querySelector('input[type="checkbox"]');
          if (checkbox.checked) {
              document.querySelector('#submit-button').disabled = false;
              document.querySelector('#submit-button').style.backgroundColor = "rgb(219, 40, 109)";
          } else {
              document.querySelector('#submit-button').disabled = true;
              document.querySelector('#submit-button').style.backgroundColor = "rgba(219, 40, 109, 0.5)";
          }
      }
  
      // Initial check for fields
      document.addEventListener('DOMContentLoaded', function () {
          const containers = document.querySelectorAll('.image-options');
          containers.forEach(container => {
              checkFields(container);
          });
      });
  </script>
  
</body>
</html>