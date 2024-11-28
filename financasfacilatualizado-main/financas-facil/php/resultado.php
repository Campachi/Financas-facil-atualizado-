<?php
// Recebe os valores passados pela URL
$salario = isset($_GET['salario']) ? floatval($_GET['salario']) : 0;
$despesas = isset($_GET['despesas']) ? floatval($_GET['despesas']) : 0;
$outras_despesas = isset($_GET['outras_despesas']) ? floatval($_GET['outras_despesas']) : 0;
$percapita = isset($_GET['percapita']) ? intval($_GET['percapita']) : 1;
$data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Calcula o total de gastos (despesas + outras despesas)
$total_gastos = $despesas + $outras_despesas;

// Calcula a renda per capita (salário dividido pela quantidade de pessoas na casa)
$renda_percapita = $salario / max($percapita, 1);

// Calcula o saldo final (salário - total de gastos)
$saldo = $salario - $total_gastos;

// Define a mensagem de conselho com base no saldo
if ($saldo >= 0) {
    $conselho = "Parabéns! Você conseguirá pagar as contas este mês.";
} else {
    $conselho = "Atenção! Você está com saldo negativo. Ajuste suas despesas para evitar problemas financeiros.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Finanças Fácil</title>
    <link rel="stylesheet" href="../css/resultado.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <img class="logotip" src="../html/logotipo.png.png" alt="Logotipo">
            <ul class="nav-links">
                <li><a href="../html/pagina_inicial.html">Início</a></li>
                <li><a href="historico.php">Histórico</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Ver meu perfil</a>
                    <div class="dropdown-content">
                        <a href="../html/perfil.html">Perfil</a>
                        <a href="../html/configuraçao.html">Configurações</a>
                        <a href="../html/login.html">Sair</a>
                    </div>
                </li>
            </ul>
            <div class="search-container">
                <input type="text" placeholder="Buscar...">
                <button type="button">Buscar</button>
            </div>
        </nav>
    </header>

    <main class="result-page">
        <fieldset>
            <legend>Resultado da Análise</legend>
            <div class="result-item">
                <strong>Renda Total:</strong>
                R$ <span id="renda-total"><?= number_format($salario, 2, ',', '.') ?></span>
            </div>
            <div class="result-item">
                <strong>Total de Gastos:</strong>
                R$ <span id="total-gastos"><?= number_format($total_gastos, 2, ',', '.') ?></span>
            </div>
            <div class="result-item">
                <strong>Renda Per Capita:</strong>
                R$ <span id="renda-percapita"><?= number_format($renda_percapita, 2, ',', '.') ?></span>
            </div>
            <div class="result-item">
                <strong>Saldo Final:</strong>
                R$ <span id="saldo-final"><?= number_format($saldo, 2, ',', '.') ?></span>
            </div>
            <div class="result-item">
                <strong>Data:</strong>
                <?= date('d/m/Y', strtotime($data)) ?>
            </div>
            <div class="message">
                <p>Aqui está a sua análise financeira:</p>
            </div>
            <div class="result-item product-result">
                <strong>Conselho:</strong>
                <p><?= $conselho ?></p>
            </div>
        </fieldset>
        <a href="../html/pagina_inicial.html" class="button">Voltar ao Início</a>
    </main>

    <footer>
        <p>&copy; 2024 Finança Fácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
