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
.likedislike{

   border:2px solid lightgray;
   border-radius:10%;

}
.emoji{

    vertical-align: middle;
    line-height: 0;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    
    //echo('<form method="post" action="PlayerStats.php">');
    ?>
     <form method="post" id="form" action="<?php echo ("quizresultat.php?id=" . $quizId); ?>">
    <?php
    
    $i = 0;
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
    
                echo('<li>' . $ressvar[$j]['svar'] . '<input type="radio" name="svar[' . $i . '][]" value="' . $ressvar[$j]['id'] . '" required></li><br>');
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
  
        ?>
        <button id="form" type="submit">Rätta quiz</button>
        </form>

        <script>

         /*   $( "submitform" ).on( "submit", function( event ) {
            event.preventDefault();
          
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200){



                }}
                xmlhttp.open("POST", 'sparaQuizResultat.php?', true);
              //  console.log($( this ).serialize());
                xmlhttp.send("svarSerialised=" +  $( this ).serialize());
        
            });
             */
         //   document.getElementById('submitform').addEventListener('click', () => {

             //   document.getElementById('form').submit();
           // })
        
        </script>
