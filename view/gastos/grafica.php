
<?php

require_once("../../core/db_connection.php");
//session_start();

$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}

$test=array();
$count =0;
$_POST['fecha']="20211010";
try {

    $stmt = $db->prepare("SELECT tipo,SUM(importe) as importe,fecha,author FROM gastos where author=? AND fecha BETWEEN ? AND ? group by tipo");  
	$stmt->execute(array($currentuser,$_POST['fecha'],date("Ymd")));
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
} catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
}
  

foreach($gastos as $gasto){

	$test[$count]["label"]=$gasto["tipo"];
	
	$test[$count]["y"]=$gasto["importe"];

	$count=$count+1;
}

if (isset($_POST["submit"])){
	if(isset($_POST['otros'])==1){

	}else{

	}
	if(isset($_POST['regalos'])==1){

	}else{
		
	}
	if(isset($_POST['comida'])==1){

	}else{
		
	}
	if(isset($_POST['casa'])==1){

	}else{
		
	}
}

?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Gastos"
	},
	axisY: {
		title: "Gastos por tipo",
		includeZero: true,
		suffix:  "€"
	},
	data: [{
		type: "bar",
		yValueFormatString: "###.## €",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontWeight: "bolder",
		indexLabelFontColor: "black",
		dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>

<div id="chartContainer" style="height: 370px; width: 50%; margin:0px auto;"></div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div id="choose">
	<form action="grafica.php" method="POST">

	<label><input type="checkbox" name="otros" id="cbox1">Otros</label><br>
	<label><input type="checkbox" name="regalos" id="cbox2">Regalos</label><br>
	<label><input type="checkbox" name="comida" id="cbox3">Comida</label><br>
	<label><input type="checkbox" name="casa" id="cbox4">Casa</label><br>

	<label class="labellog">Fecha:</label><br> 
        <input class="inputfecha" type="date" name="fecha" 
          value="<?= isset($_POST["fecha"])?$_POST["fecha"]:$gasto["fecha"] ?>">
        <?= isset($errors["fecha"])?$errors["fecha"]:"" ?><br>

	<input class="inputbtn" type="submit" name="submit" value="Submit">

	</form>
</div>

</body>
</html>         
