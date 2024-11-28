<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

// Habilitar exibição de erros (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
// Verificar o ID do usuário na sessão
$user_id = $_SESSION['user_id'];
if (!$user_id) {
    die("Erro: ID do usuário não encontrado na sessão.");
}

// Iniciar a transação
$conn->begin_transaction();

try {
    // Primeiro, excluir as entradas associadas ao usuário nas tabelas relacionadas
    $sql_calculations = "DELETE FROM finance_calculations WHERE user_id = ?";
    $stmt_calculations = $conn->prepare($sql_calculations);
    $stmt_calculations->bind_param("i", $user_id);
    $stmt_calculations->execute();
    $stmt_calculations->close();

    $sql_accounts = "DELETE FROM accounts WHERE user_id = ?";
    $stmt_accounts = $conn->prepare($sql_accounts);
    $stmt_accounts->bind_param("i", $user_id);
    $stmt_accounts->execute();
    $stmt_accounts->close();

    // Após excluir os registros relacionados, excluir o usuário
    $sql_user = "DELETE FROM users WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $stmt_user->close();

    // Se tudo correr bem, confirma a transação
    $conn->commit();

    // Excluir sessão e redirecionar para a página de login
    session_destroy();
    header("Location: ../html/login.html");
    exit();
} catch (Exception $e) {
    // Se ocorrer um erro, reverte a transação
    $conn->rollback();
    echo "Erro ao excluir o usuário: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
