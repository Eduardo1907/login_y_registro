<?php
if (!empty($_POST['correo']) && !empty($_POST['apiKey'])) {
    $correo = $_POST['correo'];
    $apiKey = $_POST['apiKey'];
    $con = mysqli_connect("localhost", "root", "", "datos_android");
    if ($con) {
        $sql = "SELECT * FROM usuarios WHERE correo = '".$correo."' and apiKey = '".$apiKey."'";
        $resultado = mysqli_query($con, $sql);
        if (mysqli_num_rows($resultado) != 0) {
            $row = mysqli_fetch_assoc($resultado);
            $sqlUpdate = 'UPDATE usuarios SET apiKey = "" WHERE correo = "'.$correo.'"';
            if (mysqli_query($con, $sqlUpdate)) {
                echo "Success";
            } else echo "Logout failed";
        } else echo "Unauthorized to access";
    } else echo "Database connection failed";
} else echo "All fields are required";