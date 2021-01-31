
<style>
.mainKontoSida{

padding : 20px;
}</style>

<div class="mainKontoSida">
<?php

if(!Auth()){
    header('Location: login.php');
}

include 'dbconnection.php';
echo('<h3>Dina quiz</h3>');

$sql = "SELECT * FROM quiz WHERE creator =" . $_SESSION['username'] . " ORDER BY gamesPlayed";

$stmt = $dbconn->prepare($sql);
$data = array();  
$stmt->execute($data);
$res = $stmt->fetchAll();

echo('<strong>klicka för att se detaljer</strong><br>');
for ($i=0; $i < count($res); $i++) { 
    echo('<a href="index.php?viewQuiz=' . $res[$i]['id'] .'">' .  $res[$i]['namn'] . '</a><br>');
}

/*

echo('<h3>Quiz du gillar</h3>');

$sql = "SELECT * FROM likesdislikes WHERE creator =" . $_SESSION['username'] . " ORDER BY gamesPlayed";

$stmt = $dbconn->prepare($sql);
$data = array();  
$stmt->execute($data);
$res = $stmt->fetchAll();

echo('<strong>klicka för att se detaljer</strong><br>');
for ($i=0; $i < count($res); $i++) { 
    echo('<a href="index.php?viewQuiz=' . $res[$i]['id'] .'">' .  $res[$i]['namn'] . '</a><br>');
}


*/
?>

</div>