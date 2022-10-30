<?php
 

 require_once("../../core/PDOConnection.php");
 $db=PDOConnection::getInstance();
 
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
 
 try {
 
     $stmt = $db->prepare("SELECT tipo, SUM(importe) as importe , fecha FROM gastos where author=? AND fecha BETWEEN ? AND ? group by tipo;");  
     $stmt->execute(array($currentuser,date("Ymd",strtotime($_POST['fecha'])),date("Ymd",strtotime($_POST['fecha2']))));
     $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
 } catch(PDOException $ex) {
     die("exception! ".$ex->getMessage());
 }


    $acum=0;

    foreach($gastos as $gasto){

        if($gasto["tipo"] == "Otros" && isset($_POST['otros'])){
        
            $acum=$acum+intval($gasto["importe"]);
        }
        if($gasto["tipo"] == "Regalos" && isset($_POST['regalos'])){
            $acum=$acum+intval($gasto["importe"]);
        }
        if($gasto["tipo"] == "Comida" && isset($_POST['comida'])){
            $acum=$acum+intval($gasto["importe"]);
        }
        if($gasto["tipo"] == "Casa" && isset($_POST['casa'])){
            $acum=$acum+intval($gasto["importe"]);
        }
            
    }

    foreach($gastos as $gasto){

        if($gasto["tipo"] == "Otros" && isset($_POST['otros'])){
            $pocenOtros=(intval($gasto["importe"])*100)/$acum;
        }
        if($gasto["tipo"] == "Regalos" && isset($_POST['regalos'])){
            $pocenRegalos=(intval($gasto["importe"])*100)/$acum;
        }
        if($gasto["tipo"] == "Comida" && isset($_POST['comida'])){
            $pocenComida=(intval($gasto["importe"])*100)/$acum;
        }
        if($gasto["tipo"] == "Casa" && isset($_POST['casa'])){
            $pocenCasa=(intval($gasto["importe"])*100)/$acum;
        }
            
    }
    



 if( isset($_POST['submit'])){
	$count=0;
	foreach($gastos as $gasto){

		if($gasto["tipo"] == "Otros" && isset($_POST['otros'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$pocenOtros;
			
			$count=$count+1;

		}
		if($gasto["tipo"] == "Regalos" && isset($_POST['regalos'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$pocenRegalos;
			$count=$count+1;

		}
		if($gasto["tipo"] == "Comida" && isset($_POST['comida'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$pocenComida;
			$count=$count+1;

		}
		if($gasto["tipo"] == "Casa" && isset($_POST['casa'])){
			$test[$count]["label"]=$gasto["tipo"];
		
			$test[$count]["y"]=$pocenCasa;
			$count=$count+1;
		
		}

	}

}else{
    $count=0;

	foreach($gastos as $gasto){

	if($gasto["tipo"] != "Comida"){
        $test[$count]["label"]=$gasto["tipo"];
		
		$test[$count]["y"]=$gasto["importe"];
        $count=$count+1;
    }

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
	title: {
		text: "Tipos de gasto durante los ultimos 12 meses"
	},
	subtitles: [{
		text: "Gastos"
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

<div id="choose" style="display:inline-block;width: 15%;float:left;">

    <?php 
        if(!isset($_POST['fecha'])){
            $time = strtotime("-1 year", time());
            $date = date("Ymd", $time);
            $_POST['fecha']=$date;
        }
        if(!isset($_POST['fecha2'])){
            $_POST['fecha2']=date("Ymd");
        }
    ?>
	<form action="personal_area.php" method="POST">
    <div class="checkbox">
	<label><input type="checkbox" name="otros" id="cbox1" <?php if (isset($_POST["otros"])) echo "checked='checked'"; ?>>Otros</label><br>
	<label><input type="checkbox" name="regalos" id="cbox2" <?php if (isset($_POST["regalos"]))echo "checked='checked'"; ?>>Regalos</label><br>
	<label><input type="checkbox" name="comida" id="cbox3"<?php if (isset($_POST["comida"])) echo "checked='checked'"; ?>>Comida</label><br>
	<label><input type="checkbox" name="casa" id="cbox4" <?php if (isset($_POST["casa"])) echo "checked='checked'"; ?>>Casa</label><br>
    </div>
    <div class="fecha">
	<label class="labellog" style="text-align: center;">Fecha Inicio:</label><br> 
        <input class="inputfecha" type="date" name="fecha" 
        value="<?php echo $_POST['fecha']; ?>">
        <?= isset($errors["fecha"])?$errors["fecha"]:"" ?><br>
		
		<label class="labellog" style="text-align: center;">Fecha Fin:</label><br> 
        <input class="inputfecha" type="date" name="fecha2" 
        value="<?php echo $_POST['fecha2']; ?>">
        <?= isset($errors["fecha2"])?$errors["fecha2"]:"" ?><br>
    </div>
        <input class="inputbtn" type="submit" name="submit" value="Submit">

	</form>
   
</div>

<div id="chartContainer" style="display:inline-block;height: 370px; width: 85%;float:left;">

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</div>

</body>
</html>                              