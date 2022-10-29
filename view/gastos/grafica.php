
<?php

require_once("../../core/db_connection.php");
//session_start();

$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}


$count =0;
if(!isset($_POST['fecha'])){
	$time = strtotime("-1 year", time());
	$date = date("Ymd", $time);
	$_POST['fecha']=$date;
}
if(!isset($_POST['fecha2'])){
	$_POST['fecha2']=date("Ymd");
}

echo date("Ymd",strtotime($_POST['fecha']));
try {

    $stmt = $db->prepare("SELECT tipo,SUM(importe) as importe,fecha,author FROM gastos where author=? AND fecha BETWEEN ? AND ? group by tipo");  
	$stmt->execute(array($currentuser,date("Ymd",strtotime($_POST['fecha'])),date("Ymd",strtotime($_POST['fecha2']))));
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
} catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
}
  
if( isset($_POST['submit'])){
	$count=0;
	foreach($gastos as $gasto){

		if($gasto["tipo"] == "Otros" && isset($_POST['otros'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$gasto["importe"];
			
			$count=$count+1;

		}else{
			
		}
		if($gasto["tipo"] == "Regalos" && isset($_POST['regalos'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$gasto["importe"];
			$count=$count+1;

		}else{
			
		}
		if($gasto["tipo"] == "Comida" && isset($_POST['comida'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$gasto["importe"];
			$count=$count+1;

		}else{
			
		}
		if($gasto["tipo"] == "Casa" && isset($_POST['casa'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$gasto["importe"];
			$count=$count+1;
		
		}else{
			
		}

		
	}
}else{
	$count=0;
foreach($gastos as $gasto){

	$test[$count]["label"]=$gasto["tipo"];
	
	$test[$count]["y"]=$gasto["importe"];

	$count=$count+1;
}
}
/*
$count=0;
foreach($gastos as $gasto){

	$test[$count]["label"]=$gasto["tipo"];
	
	$test[$count]["y"]=$gasto["importe"];

	$count=$count+1;
}
*/
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
	<form action="personal_area.php" method="POST">

	<label><input type="checkbox" name="otros" id="cbox1" <?php if (isset($_POST["otros"])) echo "checked='checked'"; ?>>Otros</label><br>
	<label><input type="checkbox" name="regalos" id="cbox2" <?php if (isset($_POST["regalos"]))echo "checked='checked'"; ?>>Regalos</label><br>
	<label><input type="checkbox" name="comida" id="cbox3"<?php if (isset($_POST["comida"])) echo "checked='checked'"; ?>>Comida</label><br>
	<label><input type="checkbox" name="casa" id="cbox4" <?php if (isset($_POST["casa"])) echo "checked='checked'"; ?>>Casa</label><br>

	<label class="labellog">Fecha Inicio:</label><br> 
        <input class="inputfecha" type="date" name="fecha" 
          value="<?= isset($_POST["fecha"])?$_POST["fecha"]:date("Ymd") ?>">
        <?= isset($errors["fecha"])?$errors["fecha"]:"" ?><br>
		
		<label class="labellog">Fecha Fin:</label><br> 
        <input class="inputfecha" type="date" name="fecha2" 
          value="<?= isset($_POST["fecha2"])?$_POST["fecha2"]:date("Ymd") ?>">
        <?= isset($errors["fecha2"])?$errors["fecha2"]:"" ?><br>

	<input class="inputbtn" type="submit" name="submit" value="Submit">

	</form>
</div>

</body>
</html>         
