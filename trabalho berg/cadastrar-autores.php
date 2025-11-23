<div class="page-header">
	<div>
		<p class="text-muted mb-1">Novo cadastro</p>
		<h1 class="page-title">Cadastrar Autor</h1>
	</div>
	<a href="?page=listar-autores" class="btn btn-ghost btn-action"><i class="bi bi-arrow-left me-2"></i>Voltar</a>
</div>

<div class="card card-elevated">
	<div class="card-body form-section">
		<form action="?page=salvar-autores" method="POST">
			<input type="hidden" name="acao" value="cadastrar">
			<div class="mb-3">
				<label class="form-label">Nome do Autor</label>
				<input type="text" name="nome_autor" class="form-control" placeholder="Ex.: Clarice Lispector" required>
			</div> 
			<div class="mb-4">
				<label class="form-label">Nacionalidade</label>
				<input type="text" name="nacionalidade" class="form-control" placeholder="Ex.: Brasil">
			</div>
			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-berg btn-action">
					<i class="bi bi-check2-circle me-2"></i>Cadastrar Autor
				</button>
				<a href="?page=listar-autores" class="btn btn-ghost btn-action">
					Cancelar
				</a>
			</div>
		</form>
	</div>
</div>