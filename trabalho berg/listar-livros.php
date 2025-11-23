<?php
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}
?>
<div class="page-header">
    <div>
        <p class="text-muted mb-1">Painel do acervo</p>
        <h1 class="page-title">Lista de Livros</h1>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="?page=cadastrar-livros" class="btn btn-berg btn-action"><i class="bi bi-journal-plus me-2"></i>Novo Livro</a>
        <a href="?page=cadastrar-autores" class="btn btn-ghost btn-action"><i class="bi bi-person-plus me-2"></i>Novo Autor</a>
    </div>
</div>

<?php
    $sql = "SELECT l.id_livros AS id_livro, l.titulos AS titulo, l.ano_publicado AS ano_publicacao, a.nome_autor 
            FROM livros l 
            LEFT JOIN autores a ON a.id_autores = l.autores_id_autores
            ORDER BY l.titulos ASC";

    $res = $conn->query($sql);
    $qtd = $res ? $res->num_rows : 0;
?>

<div class="card card-elevated">
    <div class="card-body">
        <?php if ($qtd > 0): ?>
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <p class="mb-0 text-muted">Encontramos <strong><?php echo $qtd; ?></strong> livro(s) cadastrados.</p>
                <a href="?page=cadastrar-livros" class="btn btn-outline-primary rounded-pill btn-sm"><i class="bi bi-plus me-1"></i>Adicionar</a>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Ano</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $res->fetch_object()):
                            $autor = $row->nome_autor ? htmlspecialchars($row->nome_autor) : 'Não informado';
                            $ano = $row->ano_publicacao ?: '-';
                        ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?php echo $row->id_livro; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($row->titulo); ?></td>
                                <td><?php echo $autor; ?></td>
                                <td><span class="badge badge-soft px-3 py-2"><?php echo $ano; ?></span></td>
                                <td class="text-end">
                                    <a href="?page=editar-livros&id_livro=<?php echo $row->id_livro; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil-square me-1"></i>Editar
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            onclick="if(confirm('Tem certeza que deseja excluir este livro?')){location.href='?page=salvar-livros&acao=excluir&id_livro=<?php echo $row->id_livro; ?>';}else{return false;}">
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
                <i class="bi bi-journal-x fs-1 text-primary mb-3"></i>
                <h5>Nenhum livro cadastrado</h5>
                <p class="mb-3">Adicione o primeiro livro para começar a construir seu catálogo.</p>
                <a href="?page=cadastrar-livros" class="btn btn-berg">Cadastrar Livro</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<a href="?page=index.php" class="btn btn-ghost mt-3"><i class="bi bi-arrow-left me-2"></i>Voltar</a>