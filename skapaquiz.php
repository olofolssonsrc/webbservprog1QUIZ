<?php 

session_start();
include 'Auth.php';
if(!Auth()){

    header('Location: login.php');
}

?>

<style>

.grå{

background-color : lightgray; 

}
.deleteBtn{

    color:red;
    width: 20px;
    display:inline;
}

.frågaContainer{

padding : 5px;

}
.kort{
    width: 50px;
    float: left;
}

</style>

<?php

if(isset($_POST['quiznamn'])){
      

    function sparaQuiz(){
        include('dbconnection.php');
        $sql = "INSERT INTO quiz (namn, creator, date) 
        VALUES (?, ?, now())";
        $stmt = $dbconn->prepare($sql);
        $data = array($_POST['quiznamn'], $_SESSION['username']);
        $stmt->execute($data);
        $last_id = $dbconn->lastInsertId();
        return $last_id;
    }
    
    function sparaFråga($quizId, $fråga){
        include('dbconnection.php');
        $sql = "INSERT INTO frågor ( quizId, fråga , date) 
        VALUES (?, ?, now())";
        $stmt = $dbconn->prepare($sql);
        $data = array($quizId, $fråga);
        $stmt->execute($data);
        $last_id = $dbconn->lastInsertId();
        return $last_id;
    }
    
    function sparaSvar($frågeId, $svar, $rättsvar){
        include('dbconnection.php');
        $sql = "INSERT INTO svar ( svar, rättsvar, frågaId , date) 
        VALUES (?, ?, ?, now())";
        $stmt = $dbconn->prepare($sql);
        $data = array($svar, $rättsvar, $frågeId);
        $stmt->execute($data);
    
    }

    $quizId = sparaQuiz();

    for ($i=0; $i < count($_POST['frågor']); $i++) { 

        $frågaId = sparaFråga($quizId, $_POST['frågor'][$i]);

        for ($j=0; $j < count($_POST['svar'][$i]); $j++) { 
        //    echo($_POST['rättSvar'][$i][$j]);
            if($_POST['rättSvar'][$i][0] == $j){
                sparaSvar($frågaId, $_POST['svar'][$i][$j], 1);
            }else{
                sparaSvar($frågaId, $_POST['svar'][$i][$j], 0);
            }
            
        }
    }   
    echo('quiz skapat!<br>    
        <a href="index.php">tillbaks till start</a>
    ');
}else{


?>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<p>quiznamn <input type="text" name="quiznamn" value="" required></p>

<div id='frågor'></div>

<button type="button" id="läggtillfråga">Lägg till en fråga</button><br>
<button type="submit">Skapa quiz</button>

</form>


<script>

document.getElementById('läggtillfråga').addEventListener('click', () => {
    
nyFråga();

})

var frågeIdIndex = 0;
var antalfrågor = {};

function nyFråga(){

    antalfrågor[frågeIdIndex] = 1;
    Fråga();
    frågeIdIndex++;
}

function Fråga(){

    var frågaHTML = document.createElement('DIV');
    frågaHTML.classList = "frågaContainer ";

    if(frågeIdIndex % 2 == 0){

        frågaHTML.classList += "grå ";
    }

    frågaInput = document.createElement('P');
    frågaInput.innerHTML = 'fråga ' + (frågeIdIndex + 1)+ ' <input type="text" name="frågor[]" required>'

    frågaHTML.appendChild(frågaInput);

    document.getElementById('frågor').appendChild(frågaHTML);

    deleteBtn = document.createElement('BUTTON');
    deleteBtn.innerHTML = ' ta bort fråga ';
    frågaHTML.appendChild(deleteBtn);
    deleteBtn.addEventListener('click', () => {

        frågaHTML.remove();
        frågeIdIndex--;
    });

    läggTillSvarAlt = document.createElement('BUTTON');
    läggTillSvarAlt.type = "button";
    läggTillSvarAlt.innerHTML = "Lägg till ett svarsalternativ";
    frågaHTML.appendChild(läggTillSvarAlt);

    var frågeIdIndexSec = frågeIdIndex;

    läggTillSvarAlt.addEventListener('click', () => {

        nySvarsRad(frågeIdIndexSec, 5, frågaHTML);
    });

    for (let i = 0; i < 3; i++) {
        
        nySvarsRad(frågeIdIndex, i, frågaHTML);
    }
}


function nySvarsRad(frågeIndexIdc, svarsId, container){

    radContainer = document.createElement('P');

    deleteBtn = document.createElement('DIV');
    deleteBtn.classList = 'deleteBtn ';
    deleteBtn.innerHTML = ' X ';

    var radCont = radContainer;
    deleteBtn.addEventListener('click', () => {

        radCont.remove();
    });

    svarnr = document.createElement('DIV');
    svarnr.innerHTML = 'svar ' + antalfrågor[frågeIndexIdc];
    svarnr.classList += ' kort';
    radContainer.appendChild(svarnr);

    textInput = document.createElement('INPUT');
    textInput.type = 'text';
    textInput.innerHTML = 'svar ' + antalfrågor[frågeIndexIdc];
    textInput.name = 'svar[' + frågeIndexIdc + '][]';
    textInput.required = true;

    radContainer.appendChild(textInput);

    rättSvarInput = document.createElement('INPUT');
    rättSvarInput.type = 'radio';
    rättSvarInput.name = "rättSvar[" + frågeIndexIdc + "][]";
    rättSvarInput.value = svarsId;
    rättSvarInput.required = true;

    radContainer.appendChild(rättSvarInput);    
    radContainer.appendChild(deleteBtn);
    container.appendChild(radContainer);   
    antalfrågor[frågeIndexIdc]++; 
}

nyFråga();

</script>

<?php

}
?>