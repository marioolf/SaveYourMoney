<?php

require_once("../../core/db_connection.php");
//session_start();

$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}

$test=array();
$count =0;

try {

    $stmt = $db->query("SELECT * FROM gastos");  
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  } catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
  }
  
foreach($gastos as $gasto){
	if ($gasto["author"] == $currentuser){

		$flag=0;
		$loc=0;

		while($loc<$count||$flag==1){
			if($test[$loc]["label"]==$gasto["tipo"]){
				$test[$loc]["y"]=$test[$loc]["y"]+$gasto["importe"];
				$flag=1;
				break;
			}
			$loc=$loc+1;	
		}
			
		if($flag==0){
			$test[$count]["label"]=$gasto["tipo"];
			$test[$count]["y"]=$gasto["importe"];
		}
		
		$count=$count+1;
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
</body>
</html>         