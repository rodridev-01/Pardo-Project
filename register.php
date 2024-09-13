<?php
$host = "localhost";
$username = "root"; 
$password = "";
$dbname = "testeoproyectojp"; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$role = $_POST['role'];
$email = $_POST['email'];
$clave = $_POST['password'];

if (empty($role) || empty($email) || empty($clave)) {
    echo "Por favor, completa todos los campos.";
    exit();
}

$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "El email ya está registrado. Por favor, utiliza otro.";
    exit();
}

$clave_hashed = password_hash($clave, PASSWORD_BCRYPT);

$sql = "INSERT INTO usuarios (role, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $role, $email, $clave_hashed);

if ($stmt->execute()) {
    echo "Registro exitoso. ¡Ahora puedes iniciar sesión!";
    echo "<br><a href='login.html'>Ir a la página de inicio de sesión</a>";
} else {
    echo "Error al registrar el usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
