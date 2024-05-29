<?php
if(!empty($_POST['correo']) && !empty($_POST['password'])){
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $resultado = array();
    $con = mysqli_connect("localhost", "root", "", "datos_android");
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if ($con) {
        $sql = "SELECT * FROM usuarios WHERE correo = '".$correo."'";
        $resultado = mysqli_query($con, $sql);
        if(mysqli_num_rows($resultado) != 0){
            $row = mysqli_fetch_assoc($resultado);
            if($correo == $row['correo'] && password_verify($password, $row['password'])){
                try {
                 $apiKey = bin2hex(random_bytes(23));
            }catch (Exception $e) {
                $apiKey = bin2hex(uniqid($correo(), true));
            }
            $sqlUpdate = "UPDATE usuarios SET apiKey = '".$apiKey."' WHERE correo = '".$correo."'";
                if(mysqli_query($con, $sqlUpdate)){
                    $resultado = array("status" => "success", "message" => "Bienvenido al sistema",
                        "nombre"=> $row['nombre'],"apellido"=> $row['apellido'],
                    "correo"=> $row['correo'], "apiKey" => $row['apiKey']);


                } else $resultado = array("status" => "failed", "message" => "Login failed try again");
            } else $resultado = array("status" => "failed", "message" => "Intenta poner el correo y passowrd de nuevo");
        } else $resultado = array("status" => "failed", "message" => "Intenta poner el correo y passowrd de nuevo");
    } else $resultado = array("status" => "failed", "message" => "La conexion a la base de datos no es valida");
} else $resultado = array("status" => "failed", "message" => "All field are required");

echo json_encode($resultado, JSON_UNESCAPED_UNICODE);