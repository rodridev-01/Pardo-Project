<?php
$host = "localhost"; 
$dbname = "testeoproyectojp";
$username = "root"; 
$password = ""; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$usuario = $_POST['usuario']; 
$clave = $_POST['password'];
$rol = $_POST['rol'];

$sql = "SELECT * FROM usuarios WHERE email = ? AND role = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $rol);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    
    if (password_verify($clave, $row['password'])) {

        echo "<script>alert('¡Inicio de sesión exitoso!'); window.location.href = 'dashboard.php';</script>";

    } else {

        echo "<script>alert('Contraseña incorrecta.'); window.location.href = 'login.html';</script>";
    }
} else {

    echo "<script>alert('Usuario o rol no encontrado.'); window.location.href = 'login.html';</script>";
}

$stmt->close();
$conn->close();
?>
