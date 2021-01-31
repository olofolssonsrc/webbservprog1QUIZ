<style>

.viewQuizInfbody{

    padding : 20px;
}

.like{

color:blue;

}

.dislike{

color:red;

}

</style>

<div class="viewQuizInfbody">
<a href="index.php"><h4>< tillbaks</h4></a>
<?php
include('dbconnection.php');
$quizId = $_GET['viewQuiz'];

$sql = "SELECT * FROM quiz WHERE id = " . $quizId;

$stmt = $dbconn->prepare($sql);
$data = array();  
$stmt->execute($data);
$res = $stmt->fetchAll();

//TODO : förbättra med inner join.

$sql = " SELECT 
    COUNT(*) 'likes'
    FROM likesdislikes 
    WHERE likeStatus = 'LIKE' AND quizid = $quizId";

$stmt = $dbconn->prepare($sql);
$data = array();  
$stmt->execute($data);
$res2 = $stmt->fetchAll();

$sql = " SELECT 
    COUNT(*) 'dislikes'
    FROM likesdislikes 
    WHERE likeStatus = 'DISLIKE' AND quizid = $quizId";

$stmt = $dbconn->prepare($sql);
$data = array();  
$stmt->execute($data);
$res3 = $stmt->fetchAll();

echo('<h2>' . $res[0]['namn'] .  '</h2>');
echo('<i>Skapad av <strong>' . $res[0]['creator']. '</strong>&nbsp;&nbsp;&nbsp;&nbsp;' . substr($res[0]['date'], 0, -9) . '</i>');
echo('<p>Spelats totalt ' . $res[0]['gamesPlayed'] . ' gånger</p>');
echo('<p class="like">' . $res2[0][0] . ' gillningar</p><p class="dislike">' . $res3[0][0] . ' ogillningar</p>');

if(isset($_POST['startquiz'])){

    $_SESSION['körquiz' . $quizId] = 1;
 //  header('Location : görquiz.php?id="'. $quizId . '"');
    header('Location: görquiz.php?id=' . $quizId);
   echo('test') ;
};

include 'gillaknappar.php';
echo('<br><br>');
?>

<form method="post" action="<?php echo($_SERVER["PHP_SELF"] . "?viewQuiz=" . $quizId) ?>">
    <input type="hidden" name="startquiz" value="1"></input>
  <button type="submit">Starta quiz</button>
  
</form>
<?php


    
?>

</div>


