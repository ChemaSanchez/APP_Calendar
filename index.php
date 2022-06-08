<?php
include 'Calendar.php';
$a_date = "2022-02-01";

$action = 0;

if(!empty($_POST)){
    if(!empty($_POST['ant'])){
        $action = -1;
    }

}

$fecha = date('Y-m', strtotime($action .' month')). '-1';

var_dump($fecha);

$calendar = new Calendar($fecha);

$mysqli = new mysqli("localhost", "root", "", "app_calendar");
$sql = "SELECT * FROM calendar";

if ($resultado = $mysqli->query($sql)) {

    /* obtener el array de objetos */
    while ($fila = $resultado->fetch_row()) {
        $msg = $fila[2] . ' ['.$fila[3].'] <br> ' . $fila[1];
        $calendar->add_event($msg , $fila[5], 1, $fila[6]);
    }

    /* liberar el conjunto de resultados */
    $resultado->close();
}

$_SESSION['mes'] = 0;

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $meses[date('n')-(1)-$action];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Calandario</title>
    <link href="calendar.css" rel="stylesheet" type="text/css">
    <link href="calendar.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>Calendario</h1>
    </div>
</nav>
<div class="content home">
    <?=$calendar?>
</div>
<br>
<form action="index.php" method="post">
    <input type="submit" name="ant" value="<?php echo $meses[date('n')-(2+$_SESSION['mes'])] ?>" style="padding: 8px 16px; background-color: #2c7aca; border: none; color:  white"/>
</form>
</body>
</html>
<?php
