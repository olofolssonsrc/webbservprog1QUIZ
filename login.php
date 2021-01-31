<?php 
session_start();

include 'Auth.php';
if(Auth() == true){
  
    echo('Du redan inloggad!<br>');
    echo('<a href="index.php">Startsida</a>');
}else{


    ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    
    <p>username</p><input type="text" name="username" value="" required>
    
    <p>lösenord</p><input type="text" name="password" value="" required>
    <button type="submit">Logga in</button>
    </form>
    
    <?php 
    
    include('dbconnection.php');
    
    if(isset($_POST['username'])&&isset($_POST['password'])){
    
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];
    
        $sql = "SELECT * FROM users WHERE username = '$inputUsername'";
    
        $stmt = $dbconn->prepare($sql);
        $data = array();  
        $stmt->execute($data);
        $res = $stmt->fetchAll();
    
        if(!$res){
    
            echo('Det finns inget konto med det användarnamnet<br>');
            echo('<a href="signup.php">Skapa konto</a>');
        }else{
            $password = ($res[0]['password']);
            $bannad = $res[0]['bannad'];
            if($password == $inputPassword){
        
                if($bannad == 1){
                    echo('Ditt konto har blivit avstängt av en administratör<br>');
                    echo('<a href="index.php">Startsida</a>');
                }else{
                    $_SESSION['username'] =  $inputUsername;
                    $_SESSION['userId'] =  $res[0]['id'];
                    header('Location: index.php');
                }

                
            }else{
        
            echo('fel lösenord ');  
            }   
        }  
    }
    /*
        // sql to delete table
        $sql = "DROP TABLE IF EXISTS users";
        //use exec() because no results are returned
        $dbconn->exec($sql);
        echo "Table deleted successfully";
    
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(30) NOT NULL,
        password VARCHAR(30) NOT NULL,
        email VARCHAR(30) NOT NULL,
        status VARCHAR(30) NOT NULL,
        reg_date DATETIME
        )";*/
    
    //$dbconn->exec($sql);

}
    ?>
    
    
