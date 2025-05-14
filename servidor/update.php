<?php
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cargo_id = $_POST['cargo_id'];
    $lotacao_id = $_POST['lotacao_id'];
    $id = $_POST['id'];

    $update_query = "UPDATE servidores SET nome = $1, matricula = $2, cargo_id = $3, lotacao_id = $4 WHERE id = $5";
    $result = pg_query_params($conn, $update_query, [$nome, $matricula, $cargo_id, $lotacao_id, $id]);

    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao atualizar servidor.";
    }
}