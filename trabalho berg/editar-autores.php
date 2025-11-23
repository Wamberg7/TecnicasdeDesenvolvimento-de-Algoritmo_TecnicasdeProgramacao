<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}

$idAutor = intval($_REQUEST['id_autor'] ?? 0);
$sql = "SELECT id_autores AS id_autor, nome_autor, nacionalidade FROM autores WHERE id_autores = {$idAutor}";
$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    print "<div class='alert alert-warning'>Autor não encontrado.</div>";
    print "<a href='?page=listar-autores' class='btn btn-secondary'>Voltar</a>";
    return;
}

$autor = $res->fetch_object();
?>

<div class="page-header">
	<div>
		<p class="text-muted mb-1">Atualizar informações</p>
		<h1 class="page-title">Editar Autor</h1>
	</div>
	<a href="?page=listar-autores" class="btn btn-ghost btn-action"><i class="bi bi-arrow-left me-2"></i>Voltar</a>
</div>

<div class="card card-elevated">
	<div class="card-body form-section">
		<form action="?page=salvar-autores" method="POST">
			<input type="hidden" name="acao" value="editar">
			<input type="hidden" name="id_autor" value="<?php echo $autor->id_autor; ?>">
			<div class="mb-3">
				<label class="form-label">Nome do Autor</label>
				<input type="text" name="nome_autor" class="form-control" value="<?php echo htmlspecialchars($autor->nome_autor); ?>" required>
			</div>
			<div class="mb-4">
				<label class="form-label">Nacionalidade</label>
				<input type="text" name="nacionalidade" class="form-control" value="<?php echo htmlspecialchars($autor->nacionalidade); ?>">
			</div>
			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-berg btn-action">
					<i class="bi bi-check2 me-2"></i>Salvar Alterações
				</button>
				<a href="?page=listar-autores" class="btn btn-ghost btn-action">Cancelar</a>
			</div>
		</form>
	</div>
</div>