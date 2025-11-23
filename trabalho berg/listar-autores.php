<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}
?>
<div class="page-header">
    <div>
        <p class="text-muted mb-1">Painel de autores</p>
        <h1 class="page-title">Lista de Autores</h1>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="?page=cadastrar-autores" class="btn btn-berg btn-action"><i class="bi bi-person-plus me-2"></i>Novo Autor</a>
        <a href="?page=cadastrar-livros" class="btn btn-ghost btn-action"><i class="bi bi-journal-plus me-2"></i>Novo Livro</a>
    </div>
</div>

<?php
    $sql = "SELECT id_autores AS id_autor, nome_autor, nacionalidade, data_cadastro 
            FROM autores 
            ORDER BY nome_autor ASC";

    $res = $conn->query($sql);
    $qtd = $res ? $res->num_rows : 0;
?>

<div class="card card-elevated">
    <div class="card-body">
        <?php if ($qtd > 0): ?>
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <p class="mb-0 text-muted">Encontramos <strong><?php echo $qtd; ?></strong> autor(es) cadastrados.</p>
                <a href="?page=cadastrar-autores" class="btn btn-outline-primary rounded-pill btn-sm"><i class="bi bi-plus me-1"></i>Adicionar</a>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Nacionalidade</th>
                            <th>Data de Cadastro</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $res->fetch_object()):
                            $dataValida = $row->data_cadastro && $row->data_cadastro !== '0000-00-00';
                            $dataCadastro = $dataValida ? date('d/m/Y', strtotime($row->data_cadastro)) : '-';
                            $nacionalidade = $row->nacionalidade ? htmlspecialchars($row->nacionalidade) : 'Não informada';
                        ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?php echo $row->id_autor; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($row->nome_autor); ?></td>
                                <td><span class="badge badge-soft px-3 py-2 text-uppercase"><?php echo $nacionalidade; ?></span></td>
                                <td><span class="badge badge-neutral px-3 py-2"><?php echo $dataCadastro; ?></span></td>
                                <td class="text-end">
                                    <a href="?page=editar-autores&id_autor=<?php echo $row->id_autor; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil-square me-1"></i>Editar
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            onclick="if(confirm('Tem certeza que deseja excluir este autor?')){location.href='?page=salvar-autores&acao=excluir&id_autor=<?php echo $row->id_autor; ?>';}else{return false;}">
                                        <i class="bi bi-trash me-1"></i>Excluir
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                <h5>Nenhum autor encontrado</h5>
                <p class="mb-3">Comece cadastrando um novo autor para alimentar o seu catálogo.</p>
                <a href="?page=cadastrar-autores" class="btn btn-berg">Cadastrar Autor</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<a href="?page=index.php" class="btn btn-ghost mt-3"><i class="bi bi-arrow-left me-2"></i>Voltar</a>