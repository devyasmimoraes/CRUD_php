<?php

include_once '../conexao.php';


$query = "
    SELECT 
        servidores.id, 
        servidores.nome, 
        servidores.matricula, 
        cargo.nome AS cargo, 
        lotacao.nome AS lotacao
    FROM servidores
    LEFT JOIN cargo ON servidores.cargo_id = cargo.id
    LEFT JOIN lotacao ON servidores.lotacao_id = lotacao.id
    ORDER BY servidores.nome ASC
";

$result = pg_query($conn, $query);

if (!$result) {
    echo "Erro ao buscar servidores.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Servidores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Servidores Cadastrados</h3>
            <a href="create.php" class="btn btn-primary">Novo Cadastro</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Cargo</th>
                            <th>Local de Atuação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = pg_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                                <td><?php echo htmlspecialchars($row['matricula']); ?></td>
                                <td><?php echo htmlspecialchars($row['cargo']); ?></td>
                                <td><?php echo htmlspecialchars($row['lotacao']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este servidor?');">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (pg_num_rows($result) === 0): ?>
                            <tr><td colspan="5" class="text-center">Nenhum servidor cadastrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

