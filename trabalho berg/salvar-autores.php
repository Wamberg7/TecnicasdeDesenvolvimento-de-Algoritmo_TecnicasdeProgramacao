<?php 
if (!isset($conn) || !($conn instanceof mysqli)) {
    require_once 'config.php';
    $conn = conectarDB();
}

$redirect = function (string $page, string $msg, string $tipo = 'success') {
    $query = http_build_query([
        'page' => $page,
        'msg' => $msg,
        'tipo' => $tipo
    ]);
    header("Location: index.php?$query");
    exit;
};

$acao = $_REQUEST['acao'] ?? '';

switch ($acao) {
	case 'cadastrar':
		$nome = trim($_POST['nome_autor'] ?? '');
		$nacionalidade = trim($_POST['nacionalidade'] ?? '');

		if ($nome === '') {
            $redirect('cadastrar-autores', 'O nome do autor é obrigatório.', 'warning');
		}

		$stmt = $conn->prepare("INSERT INTO autores (nome_autor, nacionalidade, data_cadastro) VALUES (?, ?, NOW())");
		$stmt->bind_param("ss", $nome, $nacionalidade);
		$salvou = $stmt->execute();
		$stmt->close();

		if($salvou){
			$redirect('listar-autores', 'Autor cadastrado com sucesso!');
		}else{
			$redirect('cadastrar-autores', 'Não foi possível cadastrar o autor.', 'danger');
		}
		break;

	case 'editar':
		$idAutor = intval($_POST['id_autor'] ?? 0);
		$nome = trim($_POST['nome_autor'] ?? '');
		$nacionalidade = trim($_POST['nacionalidade'] ?? '');

		if ($idAutor <= 0 || $nome === '') {
			$redirect('listar-autores', 'Dados inválidos para edição.', 'danger');
		}

		$stmt = $conn->prepare("UPDATE autores SET nome_autor = ?, nacionalidade = ? WHERE id_autores = ?");
		$stmt->bind_param("ssi", $nome, $nacionalidade, $idAutor);
		$atualizou = $stmt->execute();
		$stmt->close();

		if ($atualizou) {
			$redirect('listar-autores', 'Autor atualizado com sucesso!');
		} else {
			$redirect('listar-autores', 'Não foi possível atualizar o autor.', 'danger');
		}
		break;

	case 'excluir':
		$idAutor = intval($_REQUEST['id_autor'] ?? 0);

		if ($idAutor <= 0) {
			$redirect('listar-autores', 'Autor inválido.', 'danger');
		}

        try {
            $conn->begin_transaction();

            $stmtLivros = $conn->prepare("DELETE FROM livros WHERE autores_id_autores = ?");
            $stmtLivros->bind_param("i", $idAutor);
            $stmtLivros->execute();
            $stmtLivros->close();

            $stmtAutor = $conn->prepare("DELETE FROM autores WHERE id_autores = ?");
            $stmtAutor->bind_param("i", $idAutor);
            $stmtAutor->execute();
            $stmtAutor->close();

            $conn->commit();
			$redirect('listar-autores', 'Autor e seus livros foram excluídos.');
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            if (isset($stmtLivros) && $stmtLivros) {
                $stmtLivros->close();
            }
            if (isset($stmtAutor) && $stmtAutor) {
                $stmtAutor->close();
            }
            $redirect('listar-autores', 'Erro ao excluir o autor: ' . $e->getMessage(), 'danger');
        }
		break;

	default:
		$redirect('listar-autores', 'Ação inválida.', 'danger');
}
?>