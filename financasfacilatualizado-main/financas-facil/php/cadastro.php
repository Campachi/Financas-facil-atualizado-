<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financas_facil";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar dados do formulário com verificação
    $nome = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['username']) ? $_POST['username'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $telefone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $senha = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $confirmSenha = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';

    // Verificar se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($email) || empty($cpf) || empty($telefone) || empty($senha) || empty($confirmSenha)) {
        die("Por favor, preencha todos os campos.");
    }

    // Verificar se as senhas coincidem
    if (!password_verify($confirmSenha, $senha)) {
        die("As senhas não coincidem.");
    }

    // Inserir dados no banco de dados
    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, cpf, telefone, senha) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $nome, $email, $cpf, $telefone, $senha);

    if ($sql->execute()) {
        echo "Cadastro realizado com sucesso.";
        header("Location: ../html/login.html"); // Redirecionar para a página de login
        exit(); // Certifique-se de que o script não continua a ser executado após o redirecionamento
    } else {
        echo "Erro: " . $sql->error;
    }

    $sql->close();
}

$conn->close();
?>
