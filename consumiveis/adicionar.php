<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome_prod = trim($_POST['producto']);
    $descricao = trim($_POST['descricao']);
    $quantidade = trim($_POST['quantidade']);
    $fornecedor = trim($_POST['fornecedores']);
    $data = $_POST['data'];

    if (empty($nome_prod) || empty($descricao) || empty($quantidade) || empty($fornecedor) || empty($data)) {
        $mensagem = "Todos os campos são obrigatórios.";
        $classe_mensagem = "erro";
    } else {
        $sql = "INSERT INTO produtos (nome, descricao, quantidade,fornecedor, data) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        $stmt->bind_param("sssss", $nome_prod, $descricao, $quantidade, $fornecedor, $data);

        if ($stmt->execute()) {
            $mensagem = "Produto adicionado com sucesso!";
            $classe_mensagem = "sucesso";
        } else {
            $mensagem = "Erro ao cadastrar o produto: " . $stmt->error;
            $classe_mensagem = "erro";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adicionar Consumíveis</title>
</head>

<body>

    <?php if (!empty($mensagem)) : ?>
        <p class="<?php echo $classe_mensagem; ?>">
            <?php echo $mensagem; ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST">
        <br>
        <div>
            <input type="text" id="prod" name="producto" placeholder="Nome do Produto" required>
            <br><br>
            <input type="text" id="desc" name="descricao" placeholder="Descrição do produto" required>
            <br><br>
            <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade" required>
            <br><br>
            <select name="fornecedores" id="forn" required>
                <option value="">Escolha o Fornecedor</option>
                <option value="HP">HP</option>
                <option value="Dell">Dell</option>
            </select>
            <br><br>
            <input type="date" id="data" name="data" required>
            <br><br>
            <button type="submit">Guardar</button>
        </div>
    </form>

</body>

</html>