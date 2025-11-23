<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Livros - Berg Lindo</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-gradient navbar-dark shadow-sm">
  <div class="container py-2">
    <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="index.php">
		<i class="bi bi-journal-richtext fs-4"></i>
		<span>Berg Lindo • Biblioteca</span>
	</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active fw-semibold" aria-current="page" href="index.php">Início</a>
        </li>



        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-capitalize fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Autores
          </a>
          <ul class="dropdown-menu shadow-sm">
            <li><a class="dropdown-item" href="?page=cadastrar-autores"><i class="bi bi-person-plus me-2"></i>Cadastrar</a></li>
            <li><a class="dropdown-item" href="?page=listar-autores"><i class="bi bi-people me-2"></i>Lista</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Livros
          </a>
          <ul class="dropdown-menu shadow-sm">
            <li><a class="dropdown-item" href="?page=cadastrar-livros"><i class="bi bi-plus-circle me-2"></i>Cadastrar</a></li>
            <li><a class="dropdown-item" href="?page=listar-livros"><i class="bi bi-journal-text me-2"></i>Lista</a></li>
          </ul>
        </li>

      </ul>
      <a href="?page=cadastrar-livros" class="btn btn-light text-primary fw-semibold rounded-pill shadow-sm">
		<i class="bi bi-plus-circle me-2"></i>Novo Livro
	  </a>
    </div>
  </div>
</nav>

	<div class="container py-4 flex-grow-1">
		<div class="row">
			<div class="col">
                <?php if (isset($_GET['msg'])): 
                    $tipoPermitido = ['success','danger','warning','info'];
                    $tipo = $_GET['tipo'] ?? 'success';
                    if (!in_array($tipo, $tipoPermitido)) {
                        $tipo = 'success';
                    }
                ?>
                    <div class="alert alert-<?php echo $tipo; ?> alert-dismissible fade show shadow-sm rounded-4" role="alert">
                        <span class="fw-semibold"><?php echo htmlspecialchars($_GET['msg']); ?></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
				<?php
				  include('config.php');

					switch (@$_REQUEST['page']) {
						// livros
						case 'cadastrar-livros':
							include("cadastrar-livros.php");
							break;
						case 'listar-livros':
							include("listar-livros.php");
							break;
						case 'editar-livros':
							include("editar-livros.php");
							break;
						case 'salvar-livros':
							include("salvar-livros.php");
							break;

						// autores
						case 'cadastrar-autores':
							include("cadastrar-autores.php");
							break;
						case 'listar-autores':
							include("listar-autores.php");
							break;
						case 'editar-autores':
							include("editar-autores.php");
							break;
						case 'salvar-autores':
							include("salvar-autores.php");
							break;										
					default:
                        ?>
                        <div class="hero-card mb-4">
                            <p class="text-uppercase mb-2 fw-semibold opacity-75">Sistema de Gestão</p>
                            <h1 class="mb-3">Organize autores e livros com elegância</h1>
                            <p class="mb-4">Cadastre novos autores, gerencie o acervo e mantenha o catálogo sempre atualizado. Tudo em uma interface leve e responsiva.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="?page=cadastrar-livros" class="btn btn-light text-primary fw-semibold rounded-pill px-4">
                                    <i class="bi bi-plus-circle me-2"></i>Novo Livro
                                </a>
                                <a href="?page=listar-autores" class="btn btn-outline-light rounded-pill px-4">
                                    Ver autores
                                </a>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card card-elevated h-100 text-center p-4">
                                    <i class="bi bi-journal-richtext fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-semibold">Biblioteca Inteligente</h5>
                                    <p class="text-muted mb-0">Classifique livros por autor, ano e mantenha o histórico de cadastros organizado.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-elevated h-100 text-center p-4">
                                    <i class="bi bi-people fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-semibold">Autores em destaque</h5>
                                    <p class="text-muted mb-0">Acompanhe nacionalidades e atualize cadastros em poucos cliques.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-elevated h-100 text-center p-4">
                                    <i class="bi bi-speedometer2 fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-semibold">Fluxo ágil</h5>
                                    <p class="text-muted mb-0">Interface otimizada com botões acessíveis e uma identidade visual moderna.</p>
                                </div>
                            </div>
                        </div>
                        <?php
		
					}

				?>

			</div>
		</div>
	</div>
<footer class="footer-minimal py-4 mt-auto">
	<div class="container text-center">
		<p class="mb-1">Desenvolvido por <strong>Wamberg Gomes</strong></p>
		<p class="mb-0 small">&copy; <?php echo date('Y'); ?> Berg Lindo - Sistema de Gestão de Livros</p>
	</div>
</footer>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>

</html>