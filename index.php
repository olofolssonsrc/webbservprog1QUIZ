<?php 
session_start();
include 'Auth.php';
if(!Auth()){
  LoggaUt();
}
?>
<body class="body">
<style>
a{

text-decoration:none;

}
.grid-container {
    width:60%;
   height:70%;
  display: grid;
  grid-template-columns: 15% 30% 30% 15%;
  grid-template-rows: 20% auto auto;
  gap: 2px 2px;
  grid-template-areas:
    "header header header header"
    "left main main right"
    "footer footer footer footer";
   position:absolute;
   margin:0%;
   left: 50%; 
   transform: translate(-50%, 0);
}
.header { 
    grid-area: header; background-color:skyblue; 
    text-align:center;
    border:blue 2px solid;
    border-radius: 10px;
}
.left {
    padding-top:20px;
    text-align:center;
    border:gray 2px solid;
    border-radius: 10px;
    grid-area: left; background-color:lightgray;
 }
.right {
    padding-top:20px;
    text-align:center;
    border:gray 2px solid;
    border-radius: 10px;
    grid-area: right; background-color:lightgray;
 }
.main { 
    grid-area: main;  background-color:white;
    border:gray 2px solid;
    border-radius: 10px;

}
.footer { 
    grid-area: footer; background-color:lightgray;
    padding: 40px;
    border:gray 2px solid;
    border-radius: 10px;
 }

.body{
    font-family:'arial';
}

</style>

<div class="grid-container">
  <div class="header"><h1>QUIZ.SE</h1></div>
  <div class="left">
<a href="skapaquiz.php">skapa quiz</a><br>
<a href="index.php">hitta quiz</a><br>
  <a href="index.php?kontosida=view">ditt konto</a><br>



</div>
  <div class="right"> 
  
  <?php 



if(!Auth()){
    ?>
    <a href="login.php">Logga in</a> eller <a href="signup.php">Skapa konto </a>för att kunna skapa quiz, spara statestik och gilla/ogilla quiz.<br><br>
    
    <?php 
}else{
    ?>        
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="loggaut" value="">
        <div>inloggad som <?php echo($_SESSION['username']); ?></div>

        <?php

          if(Admin_Auth()){
            echo('<a href="admin.php">Admin funktioner</a>');
          }
          
        ?>

        <button type="submit">Logga ut</button>   
        </form>
    <?php
}
?>
  </div>
  
  <div class="main">


<?php




  if(isset($_GET['viewQuiz']))
  {
    include('viewquiz.php');
  }else if(isset($_GET['kontosida'])){
    include('kontosida.php');
  }else{
    include('recomendedQuiz.php');
  }
   
?>
  </div>
  <div class="footer">skapad av olof 18te</div>
</div>


</body>
<?php

if(isset($_POST['loggaut'])){

  LoggaUt();
}

function LoggaUt(){
  $_SESSION = array();
          
  // From http://php.net/manual/en/function.session-destroy.php
  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }
  
  // Finally, destroy the session.
  session_destroy();


}



?>
<?php
?>
