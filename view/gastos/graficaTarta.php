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
 
     $stmt = $db->prepare("SELECT tipo, (SUM(importe)*100)/(SELECT SUM(importe) FROM `gastos` WHERE author=?) as importe FROM gastos where author=? group by tipo;");  
     $stmt->execute(array($currentuser,$currentuser));
     $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
 } catch(PDOException $ex) {
     die("exception! ".$ex->getMessage());
 }
   
 
 foreach($gastos as $gasto){
 
     $test[$count]["label"]=$gasto["tipo"];
     
     $test[$count]["y"]=$gasto["importe"];
 
     $count=$count+1;
 }
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Usage Share of Desktop Browsers"
	},
	subtitles: [{
		text: "November 2017"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                              