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
		$titulo = trim($_POST['titulo'] ?? '');
		$anoInput = trim($_POST['ano_publicacao'] ?? '');
		$idAutor = intval($_POST['id_autor_fk'] ?? 0);

		if ($titulo === '' || $idAutor <= 0) {
			$redirect('cadastrar-livros', 'Título e autor são obrigatórios.', 'warning');
		}

        if ($anoInput === '') {
            $stmt = $conn->prepare("INSERT INTO livros (titulos, ano_publicado, autores_id_autores) VALUES (?, NULL, ?)");
            $stmt->bind_param("si", $titulo, $idAutor);
        } else {
            $ano = intval($anoInput);
            $stmt = $conn->prepare("INSERT INTO livros (titulos, ano_publicado, autores_id_autores) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $titulo, $ano, $idAutor);
        }
        $salvou = $stmt->execute();
        $stmt->close();

		if($salvou){
			$redirect('listar-livros', 'Livro cadastrado com sucesso!');
		}else{
			$redirect('cadastrar-livros', 'Não foi possível cadastrar o livro.', 'danger');
		}
		break;

	case 'editar':
		$idLivro = intval($_POST['id_livro'] ?? 0);
		$titulo = trim($_POST['titulo'] ?? '');
		$anoInput = trim($_POST['ano_publicacao'] ?? '');
		$idAutor = intval($_POST['id_autor_fk'] ?? 0);

		if ($idLivro <= 0 || $titulo === '' || $idAutor <= 0) {
			$redirect('listar-livros', 'Dados inválidos para edição.', 'danger');
		}

        if ($anoInput === '') {
            $stmt = $conn->prepare("UPDATE livros SET titulos = ?, ano_publicado = NULL, autores_id_autores = ? WHERE id_livros = ?");
            $stmt->bind_param("sii", $titulo, $idAutor, $idLivro);
        } else {
            $ano = intval($anoInput);
            $stmt = $conn->prepare("UPDATE livros SET titulos = ?, ano_publicado = ?, autores_id_autores = ? WHERE id_livros = ?");
            $stmt->bind_param("siii", $titulo, $ano, $idAutor, $idLivro);
        }
        $atualizou = $stmt->execute();
        $stmt->close();

		if ($atualizou) {
			$redirect('listar-livros', 'Livro atualizado com sucesso!');
		} else {
			$redirect('listar-livros', 'Não foi possível atualizar o livro.', 'danger');
		}
		break;

	case 'excluir':
		$idLivro = intval($_REQUEST['id_livro'] ?? 0);

		if ($idLivro <= 0) {
			$redirect('listar-livros', 'Livro inválido.', 'danger');
		}

        $stmt = $conn->prepare("DELETE FROM livros WHERE id_livros = ?");
        $stmt->bind_param("i", $idLivro);
        $excluiu = $stmt->execute();
        $stmt->close();

		if ($excluiu) {
			$redirect('listar-livros', 'Livro excluído com sucesso!');
		} else {
			$redirect('listar-livros', 'Não foi possível excluir o livro.', 'danger');
		}
		break;

	default:
		$redirect('listar-livros', 'Ação inválida.', 'danger');
}

?>