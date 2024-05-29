<?php
if (!empty($_POST['correo'] && !empty($_POST['apiKey']))){
    $correo = $_POST['correo'];
    $apiKey = $_POST['apiKey'];
    $resultado = array();
    $con = mysqli_connect("localhost", "root", "", "datos_android");
    if($con){
        $sql = "SELECT * FROM usuario WHERE correo = '".$correo."' and apiKey = '".$apiKey."'";
        $resultado = mysqli_query($con, $sql);
        if (mysqli_num_rows($resultado) != 0) {
            $row = mysqli_fetch_assoc($resultado);
            $resultado = array("status" => "success", "message" => "Bienvenido al sistema",
                "nombre"=> $row['nombre'],"apellido"=> $row['apellido'],
                "correo"=> $row['correo'], "apiKey" => $row['apiKey']);
        } else $resultado = array("status" => "failed", "message" => "Acceso denegado");
    } else $resultado = array("status" => "failed", "message" => "La conexion a la base de datos no es valida");
} else $resultado = array("status" => "failed", "message" => "All field are required");

echo json_encode($resultado, JSON_UNESCAPED_UNICODE);