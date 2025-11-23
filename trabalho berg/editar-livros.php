<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}

$idLivro = intval($_REQUEST['id_livro'] ?? 0);
$sqlLivro = "SELECT id_livros AS id_livro, titulos AS titulo, ano_publicado, autores_id_autores 
             FROM livros WHERE id_livros = {$idLivro}";
$resLivro = $conn->query($sqlLivro);

if (!$resLivro || $resLivro->num_rows === 0) {
    print "<div class='alert alert-warning'>Livro não encontrado.</div>";
    print "<a href='?page=listar-livros' class='btn btn-secondary'>Voltar</a>";
    return;
}

$livro = $resLivro->fetch_object();
$autores = $conn->query("SELECT id_autores AS id_autor, nome_autor FROM autores ORDER BY nome_autor ASC");
?>

<div class="page-header">
	<div>
		<p class="text-muted mb-1">Atualizar registro</p>
		<h1 class="page-title">Editar Livro</h1>
	</div>
	<a href="?page=listar-livros" class="btn btn-ghost btn-action"><i class="bi bi-arrow-left me-2"></i>Voltar</a>
</div>

<div class="card card-elevated">
	<div class="card-body form-section">
		<form action="?page=salvar-livros" method="POST">
			<input type="hidden" name="acao" value="editar">
			<input type="hidden" name="id_livro" value="<?php echo $livro->id_livro; ?>">

			<div class="mb-3">
				<label class="form-label">Título</label>
				<input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($livro->titulo); ?>" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Autor</label>
	            <select name="id_autor_fk" class="form-select" required>
	                <option value="">Selecione o autor</option>
	                <?php
	                    if ($autores && $autores->num_rows > 0) {
	                        while ($autor = $autores->fetch_object()) {
	                            $selected = ($autor->id_autor == $livro->autores_id_autores) ? "selected" : "";
	                            printf(
	                                "<option value='%d' %s>%s</option>",
	                                $autor->id_autor,
	                                $selected,
	                                htmlspecialchars($autor->nome_autor, ENT_QUOTES, 'UTF-8')
	                            );
	                        }
	                    } else {
	                        print "<option value=''>Nenhum autor cadastrado</option>";
	                    }
	                ?>
	            </select>
			</div>

			<div class="mb-4">
				<label class="form-label">Ano de Publicação</label>
				<input type="number" name="ano_publicacao" class="form-control" min="0" max="<?php echo date('Y'); ?>" value="<?php echo htmlspecialchars($livro->ano_publicado); ?>">
			</div>

			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-berg btn-action">
					<i class="bi bi-check2 me-2"></i>Salvar Alterações
				</button>
				<a href="?page=listar-livros" class="btn btn-ghost btn-action">
					Cancelar
				</a>
			</div>
		</form>
	</div>
</div>