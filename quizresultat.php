<?php
 
session_start();
?>

<style>

.rätt{
    background-color:lime;
}
.fel{

    background-color : orange;
}
</style>

<?php   

    include('dbconnection.php');

    $quizId = $_GET['id'];

    $sql = "SELECT * FROM quiz WHERE id = " . $quizId;
    
    $stmt = $dbconn->prepare($sql);
    $data = array();  
    $stmt->execute($data);
    $res = $stmt->fetchAll();
    
    echo('<h1>' . $res[0]['namn'] . '</h1>');
    
    $sql = "SELECT * FROM frågor WHERE quizId = " . $quizId;
    
    $stmt = $dbconn->prepare($sql);
    $data = array();  
    $stmt->execute($data);
    $res = $stmt->fetchAll();
    
    $i = 0; //fråga id
    $antalRätt = 0;
    while(true){
    
    if(isset($res[$i])){
    
        $frågaTxt = $res[$i]['fråga'];
        echo('<h4>' . $frågaTxt . '</h4>');
    
        $sql = "SELECT * FROM svar WHERE frågaId = " . $res[$i]['id'];
    
        $stmt = $dbconn->prepare($sql);
        $data = array();  
        $stmt->execute($data);
        $ressvar = $stmt->fetchAll();
    
        echo('<ol>');
        $j = 0;
        while(true){
        if(isset($ressvar[$j])){
    
                if($ressvar[$j]['rättsvar'] == 1){
                    if($_POST['svar'][$i][0] == $ressvar[$j]['id']){
                        $antalRätt++;  
                    }
                    echo('<li><label class="rätt">' . $ressvar[$j]['svar'] . '</label></li><br>');         
                    
                }else if($_POST['svar'][$i][0] == $ressvar[$j]['id']){
                    echo('<li><label class="fel">' . $ressvar[$j]['svar'] . '</label></li><br>');            
                }else{
                    echo('<li><label >' . $ressvar[$j]['svar'] . '</label></li><br>');     
                }
           
            $j++;
        }else{
            echo('</ol>');
            break;
        }
        }
    $i++;
    }else{
        break;
    }
    }

    $antalFrågor = $i;

        echo('Du fick ' . $antalRätt . ' rätt av ' . $antalFrågor . ' möjliga.<br>');
        include 'gillaknappar.php';
        echo('<a href="index.php">tillbaks till start</a>');
        if(isset($_SESSION['körquiz' . $quizId])){
        
            unset($_SESSION['körquiz' . $quizId]);
            include('dbconnection.php');
            
            $sql = "UPDATE quiz 
            SET gamesPlayed = gamesPlayed + 1
            WHERE id = " . $quizId;
    
            $stmt = $dbconn->prepare($sql);
            $stmt->execute();    
        }
     
  ?>