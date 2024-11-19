<?php

$conn = mysqli_connect('localhost', 'root', 'root', 'gerenciamento_chamados_1');

if (!$conn) {
    die("Conexão não deu boa: " . mysqli_connect_error());
}

$nome_cliente = isset($_POST['nome_cliente']) ? $_POST['nome_cliente'] : 'Não possui nome.';
$email_cliente = isset($_POST['email_cliente']) ? $_POST['email_cliente'] : 'Não possui email';
$telefone_cliente = isset($_POST['telefone_cliente']) ? $_POST['telefone_cliente'] : 'Não possui';


function inserir($table, $campos, $values) {
    global $conn;
    
    $campos = implode(',', $campos);
    $placeholders = implode(',', array_fill(0, count($values), '?'));

    $stmt = $conn->prepare("INSERT INTO $table ($campos) VALUES ($placeholders)");
    $stmt->bind_param(str_repeat('s', count($values)), ...$values);
    
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

function ver($table) {
    global $conn;
    $query_ver = "SELECT * FROM $table";
    $result = $conn->query($query_ver);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Nome: " . $row['nome_cliente'] . " - Email: " . $row['email_cliente'] . " - Telefone: " . $row['telefone_cliente'] . "<br>";
        }
    } else {
        echo "Nenhum cliente encontrado.";
    }
}

function updateCliente($table, $dados, $id) {
    global $conn;

    $set = [];
    foreach ($dados as $campo => $valor) {
        $set[] = "$campo = ?";
    }
    $set = implode(',', $set);
    
    $stmt = $conn->prepare("UPDATE $table SET $set WHERE id = ?");
    $dados['id'] = $id;
    $stmt->bind_param(str_repeat('s', count($dados)), ...array_values($dados));

    if ($stmt->execute()) {
        echo "Cliente atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    inserir("cliente", ['nome_cliente', 'email_cliente', 'telefone_cliente'], [$nome_cliente, $email_cliente, $telefone_cliente]);
}

?>


<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CADASTRO</title>
</head>
<body>
    <h2>PÁGINA DE CADASTRO</h2>
    <form action="enviar_cadastro" method="post">
        <label  for="nome_cliente" value="nome_cliente" required>nome:</label><br>
        <input name="nome_cliente" type="text"  required><br><br>
        <label  for="email_cliente" value="email_cliente" required >email:</label><br>
        <input name="email_cliente" type="text"  required><br><br>
        <label for="telefone_cliente" value="telefone_cliente" required >telefone:</label>
        <input name= "telefone_cliente"  type="text" required><br><br>
        <button method="submit" required><b>Enviar</b></button>
    </form>

</body>
</html>