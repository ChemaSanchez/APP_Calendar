
<?php
$day = $_GET['day'];
if(strlen($_GET['day']) == 1) $day = '0'.$day;
$date = $day .'/'. date('m/Y', strtotime('+0 month'));
$date_sql = date('Y-m', strtotime('+0 month')).'-'. $day;

$mysqli = new mysqli("localhost", "root", "", "app_calendar");
$sql = "SELECT * FROM calendar WHERE date = '$date_sql'";
$result = $mysqli->query($sql);
if(mysqli_num_rows($result) >= 1){
    while ($fila = $result->fetch_row()) {

        $msg = $fila[1] . ' tiene ' . $fila[2] .' el '.$date.' a las ['.$fila[3].']';
        $href = "./delete_event.php?id=$fila[0]";
        echo '<head>
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
              </head>';
        echo "<br><div style='border-radius: 20px; background: rgba(207,204,224,0.65); width: fit-content; margin: auto; padding-top: 15px; padding-left: 15px; padding-right: 15px; padding-bottom: 4px'><h4 style='color: #6c63ff'>$msg <a style='color: #3f3d56;' href=$href><i class='far fa-trash-alt'></i></a></h4></div>";
    }

    /* liberar el conjunto de resultados */
    $result->close();
}
echo include('add_event.html');

if(!empty($_POST)){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $hour = $_POST['hour'];
    $telf = $_POST['telf'];
    $color = $_POST['color'];

    var_dump($_POST);

    $sentencia = $mysqli->prepare("INSERT INTO calendar (name, subject, hour, telf, date, color) VALUES (?,?,?,?,?,?)");
    $sentencia->bind_param("ssssss", $name, $subject, $hour, $telf, $date_sql, $color);
    $sentencia->execute();
    header("Location: ./index.php");
    exit();
}



