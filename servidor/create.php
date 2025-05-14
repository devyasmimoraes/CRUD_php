<?php
include_once '../conexao.php';

$query_cargo = "SELECT id, nome FROM cargo ORDER BY nome ASC";
$result_cargo = pg_query($conn, $query_cargo);

if (!$result_cargo) {
    echo "Erro ao buscar cargos.";
    exit;
}

$sql = "SELECT id, nome FROM lotacao ORDER BY nome";
$result_lotacao = pg_query($conn, $sql);

if (!$result_lotacao) {
    die("Erro na consulta: " . pg_last_error($conn));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Servidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Cadastro de Servidor</h5>
            </div>
            <div class="card-body p-4">
                <form action="store.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-semibold">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="matricula" class="form-label fw-semibold">Matrícula</label>
                        <input type="text" id="matricula" name="matricula" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="sexo_id" class="form-label fw-semibold">Sexo</label>

                        <select name="sexo" class="form-select" id="sexo">
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="sexo2">sexo2</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cargo_id" class="form-label fw-semibold">Cargo</label>
                        <select name="cargo_id" id="cargo_id" class="form-select" required>
                            <option value="">-- Selecione o cargo --</option>
                            <?php while ($row = pg_fetch_assoc($result_cargo)) { ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo htmlspecialchars($row['nome']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                   
                    <div class="mb-3">
                        <label for="lotacao_nome" class="form-label fw-semibold">Local de Atuação</label>
                        <select name="lotacao_nome" id="lotacao_nome" class="form-select" required>
                            <option value="">-- Selecione o local de atuação --</option>
                            <?php while ($row = pg_fetch_assoc($result_lotacao)) { ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo htmlspecialchars($row['nome']); ?>
                                </option>
                            <?php } ?>
                        </select>  
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
 