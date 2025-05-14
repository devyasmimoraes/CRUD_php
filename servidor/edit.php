<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID do servidor não informado.");
}



$query = "
    SELECT * FROM servidores WHERE id = $1
";
$result = pg_query_params($conn, $query, [$id]);
$servidor = pg_fetch_assoc($result);

$cargos = pg_query($conn, "SELECT id, nome FROM cargo ORDER BY nome");
$lotacoes = pg_query($conn, "SELECT id, nome FROM lotacao ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Servidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3>Editar Servidor</h3>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $servidor['id'] ?>">

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($servidor['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="<?= htmlspecialchars($servidor['matricula']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Cargo</label>
            <select name="cargo_id" class="form-select" required>
                <?php while ($cargo = pg_fetch_assoc($cargos)) { ?>
                    <option value="<?= $cargo['id'] ?>" <?= $cargo['id'] == $servidor['cargo_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cargo['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Lotação</label>
            <select name="lotacao_id" class="form-select" required>
                <?php while ($lot = pg_fetch_assoc($lotacoes)) { ?>
                    <option value="<?= $lot['id'] ?>" <?= $lot['id'] == $servidor['lotacao_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lot['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
