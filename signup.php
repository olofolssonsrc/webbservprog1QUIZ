<?php 
include('dbconnection.php');

session_start();

if(isset($_SESSION['username'])){

    header('Location: index.php');
}

if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['epost'])){

  $sql = "INSERT INTO users (username, password, epost, admin, bannad, reg_date) 
  VALUES (?, ?, ?, ?, ?, now())";
  $stmt = $dbconn->prepare($sql);
  # the data we want to insert
  $data = array($_POST['username'], $_POST['password'], $_POST['epost'], 0, 0);
  # execute width array-parameter
  $stmt->execute($data);

  $sql = "SELECT * FROM users WHERE username = " . $_POST['username'];

    $stmt = $dbconn->prepare($sql);
    $data = array();  
    $stmt->execute($data);
    $res = $stmt->fetchAll();

  $_SESSION['username'] =  $_POST['username'];
  $_SESSION['userId'] =  $res[0]['id'];
 // $_SESSION['userstatus'] =  $res[0]['status'];

  echo('<h1>Välkommen till quiz.se!</h1>');
  echo('<a href="index.php">Start</a>');

}else{
?>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

  <p>username</p><input type="text" name="username" value="" required>
  <p>email</p><input type="text" name="epost" value="" required>
  <p>password</p><input type="text" name="password" value="" required>
  <!--<p>admin true/false</p><input type="text" name="adminstatus" value="">-->
  <button type="submit">Skapa konto</button>
  
  </form>

  <a href="login.php">Logga in</a>
<?php
}

$dbconn = null;

?>
