<?php
session_start();

include("conexao/conexao.php");

$erro = "";

if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        $erro = "Preencha o seu email";
    } elseif (strlen($_POST['senha']) == 0) {
        $erro = "Preencha a sua senha";
    } else {
        $email = $conn->real_escape_string($_POST["email"]);
        $password = $conn->real_escape_string($_POST["senha"]);

        $sql_code = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do código: " . mysqli_error($conn));

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            $_SESSION['user'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            header("Location: menu.php");
            exit;
        } else {
            $erro = "Email ou senha incorretos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
</head>

<body>
    <form action="" method="post">
        <legend>Login</legend>

        <?php if (!empty($erro)) : ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <input type="email" id="email" name="email" placeholder="Email" required />
        <input type="password" id="senha" name="senha" placeholder="Senha" required />
        <input type="checkbox" onclick="togglePassword()"> Mostrar senha

        <br><br>

        <button type="submit">Entrar</button>
        <a href="recuperarSenha.php">Esqueci a palavra-passe</a>
    </form>

    <script>
        function togglePassword() {
            var senhaField = document.getElementById("senha");
            if (senhaField.type === "password") {
                senhaField.type = "text";
            } else {
                senhaField.type = "password";
            }
        }
    </script>
</body>

</html>
