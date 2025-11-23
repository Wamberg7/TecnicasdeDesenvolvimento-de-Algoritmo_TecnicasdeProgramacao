<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}
?>
<div class="page-header">
	<div>
		<p class="text-muted mb-1">Novo registro</p>
		<h1 class="page-title">Cadastrar Livro</h1>
	</div>
	<a href="?page=listar-livros" class="btn btn-ghost btn-action"><i class="bi bi-arrow-left me-2"></i>Voltar</a>
</div>

<div class="card card-elevated">
	<div class="card-body form-section">
		<form action="?page=salvar-livros" method="POST">
			<input type="hidden" name="acao" value="cadastrar">
			<div class="mb-3">
				<label class="form-label">Título</label>
				<input type="text" name="titulo" class="form-control" placeholder="Ex.: Grande Sertão: Veredas" required>
			</div> 
			<div class="mb-3">
				<label class="form-label">Autor</label>
                <?php
                    $autoresDisponiveis = false;
                    $listaAutores = [];
                    $sql = "SELECT id_autores AS id_autor, nome_autor FROM autores ORDER BY nome_autor ASC";
                    if ($res = $conn->query($sql)) {
                        while ($row = $res->fetch_object()) {
                            $listaAutores[] = $row;
                        }
                        $autoresDisponiveis = count($listaAutores) > 0;
                        $res->free();
                    }
                ?>
	            <select name="id_autor_fk" class="form-select" required <?php echo $autoresDisponiveis ? '' : 'disabled'; ?>>
	                <option value=""><?php echo $autoresDisponiveis ? 'Selecione o autor' : 'Nenhum autor disponível'; ?></option>
	                <?php if ($autoresDisponiveis): ?>
                        <?php foreach ($listaAutores as $row): ?>
                            <option value="<?php echo $row->id_autor; ?>"><?php echo htmlspecialchars($row->nome_autor, ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
	            </select>
                <?php if (!$autoresDisponiveis): ?>
                    <small class="form-hint">Nenhum autor cadastrado. <a href="?page=cadastrar-autores">Cadastre um autor primeiro</a>.</small>
                <?php endif; ?>
			</div>

			<div class="mb-4">
				<label class="form-label">Ano de Publicação</label>
				<input type="number" name="ano_publicacao" class="form-control" min="0" max="<?php echo date('Y'); ?>" placeholder="<?php echo date('Y'); ?>">
			</div>
		    
			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-berg btn-action">
					<i class="bi bi-check2-circle me-2"></i>Cadastrar Livro
				</button>
				<a href="?page=listar-livros" class="btn btn-ghost btn-action">
					Cancelar
				</a>
			</div>
		</form>
	</div>
</div>