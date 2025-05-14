<?php
include_once '../conexao.php';

try {
    // Conexão com o PostgreSQL usando PDO
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se os dados foram enviados via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recebe os dados do formulário HTML
        $nome = $_POST['nome'] ?? null;
        $matricula = $_POST['matricula'] ?? null;
        $cargo_id = $_POST['cargo_id'] ?? null;
        $lotacao_id = $_POST['lotacao_nome'] ?? null; 
        $sexo = $_POST['sexo'] ?? null;

        // Validação dos campos obrigatórios
        if (!$nome || !$matricula || !$cargo_id || !$lotacao_id) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        // Insere o servidor no banco de dados
        $sql = "INSERT INTO servidores (nome, matricula, cargo_id, lotacao_id, sexo)
                VALUES (:nome, :matricula, :cargo_id, :lotacao_id, :sexo)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':cargo_id', $cargo_id, PDO::PARAM_INT);
        $stmt->bindParam(':lotacao_id', $lotacao_id, PDO::PARAM_INT);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->execute();

        // Redireciona após sucesso
        header("Location: index.php");
        exit;
    } else {
        echo "Método inválido.";
    }
} catch (PDOException $e) {
    echo "Erro ao inserir: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
