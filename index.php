<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: registroGastos.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['usuario']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        require 'conexion/conexion.php';
        
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
       


        if ($password == $user['password_hash']) {
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['username'] = $user['nombre'];
            
            
            header("Location: registroGastos.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor complete todos los campos.";
    }
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/stylesLogin.css" />
    <script src="js/app.js"></script>
    <title>Soluciones de Tecnología Grupo Dos</title>
  </head>
  <body>
    

    <div class="login-box">
        <h2>🔐 Iniciar Sesión</h2>
        <p class="subtitle">Ingresa tus credenciales para acceder al sistema</p>
        
        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="usuario" placeholder="Ingresa tu usuario" required autocomplete="username">
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Ingresa tu contraseña" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn">→ Ingresar</button>
        </form>
    </div>
  </body>
</html>
