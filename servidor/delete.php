
<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = "DELETE FROM servidores WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);

if ($result) {
    header("Location: servidor/index.php");
    exit;
} else {
    echo "Erro ao excluir servidor.";
}
?>
