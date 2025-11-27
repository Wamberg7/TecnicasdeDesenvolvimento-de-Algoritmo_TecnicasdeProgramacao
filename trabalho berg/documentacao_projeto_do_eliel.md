# 📚 Sistema de Gestão de Biblioteca

Sistema web desenvolvido em PHP para gerenciamento de acervo bibliográfico, permitindo o cadastro, listagem, edição e exclusão de autores e livros.

---

## 📋 Documentação Complementar da Disciplina

- [ ] **Documentação complementar da disciplina, contendo:**
  - [x] Projeto desenvolvido com aplicação CRUD
  - [ ] Pseudocódigo
  - [ ] Fluxograma
  - [ ] Especificação em linguagem algorítmica (Python, PHP, C, outras)

---

## 🎯 Descrição do Projeto

Sistema de gestão bibliográfica desenvolvido com PHP e MySQL, oferecendo uma interface web responsiva para administração de autores e livros. O sistema implementa operações CRUD (Create, Read, Update, Delete) completas para ambas as entidades, com validação de dados e tratamento de erros.

### Funcionalidades Principais

- ✅ **CRUD de Autores**: Cadastro, listagem, edição e exclusão de autores
- ✅ **CRUD de Livros**: Cadastro, listagem, edição e exclusão de livros
- ✅ **Relacionamento**: Livros vinculados a autores através de chave estrangeira
- ✅ **Interface Responsiva**: Design moderno com Bootstrap 5
- ✅ **Validação de Dados**: Validação client-side e server-side
- ✅ **Tratamento de Erros**: Mensagens de feedback para o usuário

---

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 8.2+
- **Banco de Dados**: MySQL (MariaDB)
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Servidor**: Apache (XAMPP) ou servidor PHP embutido
- **IDE**: Qualquer editor de código (VS Code, PHPStorm, etc.)

---

## 📁 Estrutura do Projeto

```
trabalho berg/
│
├── index.php                 # Página principal e roteamento
├── config.php                # Configuração de conexão com banco de dados
├── bancodedados.sql          # Script SQL para criação do banco de dados
│
├── cadastrar-autores.php     # Formulário de cadastro de autores
├── listar-autores.php        # Listagem de autores
├── editar-autores.php        # Formulário de edição de autores
├── salvar-autores.php        # Processamento de cadastro/edição/exclusão
│
├── cadastrar-livros.php      # Formulário de cadastro de livros
├── listar-livros.php         # Listagem de livros
├── editar-livros.php         # Formulário de edição de livros
├── salvar-livros.php         # Processamento de cadastro/edição/exclusão
│
├── css/
│   ├── bootstrap.css         # Framework Bootstrap
│   └── custom.css            # Estilos personalizados
│
└── js/
    └── bootstrap.bundle.js    # JavaScript do Bootstrap
```

---

## 🗄️ Estrutura do Banco de Dados

### Tabela: `autores`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id_autores` | INT (PK, AUTO_INCREMENT) | Identificador único do autor |
| `nome_autor` | VARCHAR(100) | Nome completo do autor |
| `nacionalidade` | VARCHAR(50) | Nacionalidade do autor |
| `data_cadastro` | DATE | Data de cadastro do autor |

### Tabela: `livros`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id_livros` | INT (PK, AUTO_INCREMENT) | Identificador único do livro |
| `titulos` | VARCHAR(255) | Título do livro |
| `ano_publicado` | YEAR | Ano de publicação (opcional) |
| `autores_id_autores` | INT (FK) | Referência ao autor (chave estrangeira) |

**Relacionamento**: `livros.autores_id_autores` → `autores.id_autores`

---

## 🚀 Instalação e Configuração

### Pré-requisitos

1. **XAMPP** (ou similar) instalado
2. **PHP 8.2+** 
3. **MySQL/MariaDB** rodando

### Passos para Instalação

1. **Clone ou baixe o projeto** para a pasta `htdocs` do XAMPP:
   ```
   C:\xampp\htdocs\trabalho berg\
   ```

2. **Configure o banco de dados**:
   - Abra o phpMyAdmin: `http://localhost/phpmyadmin`
   - Importe o arquivo `bancodedados.sql` para criar o banco e as tabelas

3. **Configure a conexão** (se necessário):
   - Edite o arquivo `config.php` e ajuste as credenciais:
   ```php
   define('DB_HOST', '127.0.0.1');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Sua senha do MySQL
   define('DB_PORT', 3307); // Porta do MySQL
   define('DB_NAME', 'trabalhoberg');
   ```

4. **Acesse o sistema**:
   - Abra no navegador: `http://localhost/trabalho berg/`

---

## 📝 Operações CRUD Implementadas

### Autores

| Operação | Arquivo | Descrição |
|----------|---------|-----------|
| **Create** | `cadastrar-autores.php` + `salvar-autores.php` | Cadastra novo autor |
| **Read** | `listar-autores.php` | Lista todos os autores |
| **Update** | `editar-autores.php` + `salvar-autores.php` | Edita autor existente |
| **Delete** | `salvar-autores.php` | Exclui autor (com verificação de livros vinculados) |

### Livros

| Operação | Arquivo | Descrição |
|----------|---------|-----------|
| **Create** | `cadastrar-livros.php` + `salvar-livros.php` | Cadastra novo livro |
| **Read** | `listar-livros.php` | Lista todos os livros com seus autores |
| **Update** | `editar-livros.php` + `salvar-livros.php` | Edita livro existente |
| **Delete** | `salvar-livros.php` | Exclui livro |

---

## 🔄 Pseudocódigo - Operação de Cadastro de Livro

```
INÍCIO
  CONECTAR ao banco de dados
  SE conexão bem-sucedida ENTÃO
    LER dados do formulário (título, ano, id_autor)
    SE título não está vazio E id_autor é válido ENTÃO
      SE ano está vazio ENTÃO
        PREPARAR query: INSERT INTO livros (titulos, ano_publicado, autores_id_autores) 
                         VALUES (?, NULL, ?)
        EXECUTAR query com título e id_autor
      SENÃO
        PREPARAR query: INSERT INTO livros (titulos, ano_publicado, autores_id_autores) 
                         VALUES (?, ?, ?)
        EXECUTAR query com título, ano e id_autor
      FIM SE
      SE operação bem-sucedida ENTÃO
        REDIRECIONAR para listar-livros com mensagem de sucesso
      SENÃO
        REDIRECIONAR para cadastrar-livros com mensagem de erro
      FIM SE
    SENÃO
      REDIRECIONAR para cadastrar-livros com mensagem de validação
    FIM SE
  SENÃO
    EXIBIR erro de conexão
  FIM SE
FIM
```

---

## 📊 Fluxograma - Fluxo de Cadastro de Livro

```
┌─────────────────┐
│   INÍCIO        │
└────────┬────────┘
         │
         ▼
┌─────────────────────────┐
│ Conectar ao Banco       │
└────────┬────────────────┘
         │
         ▼
    ┌────────┐
    │ Sucesso?│
    └───┬────┘
        │ SIM
        ▼
┌─────────────────────────┐
│ Ler dados do formulário │
│ (título, ano, autor)    │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Validar dados           │
│ (título e autor OK?)    │
└────────┬────────────────┘
         │
         ▼
    ┌────────┐
    │ Válido?│
    └───┬────┘
        │ SIM
        ▼
┌─────────────────────────┐
│ Ano preenchido?         │
└────────┬────────────────┘
         │
    ┌────┴────┐
    │ SIM     │ NÃO
    ▼         ▼
┌─────────┐ ┌─────────┐
│ INSERT  │ │ INSERT  │
│ com ano │ │ sem ano │
└────┬────┘ └────┬────┘
     │          │
     └────┬─────┘
          │
          ▼
    ┌────────┐
    │ Sucesso?│
    └───┬────┘
        │ SIM
        ▼
┌─────────────────────────┐
│ Redirecionar para       │
│ listar-livros           │
│ (mensagem de sucesso)   │
└─────────────────────────┘
         │
         ▼
      ┌─────┐
      │ FIM │
      └─────┘
```

---

## 💻 Especificação em Linguagem Algorítmica (PHP)

### Função: Cadastrar Livro

```php
<?php
// Função para cadastrar um novo livro no banco de dados
function cadastrarLivro($titulo, $anoPublicacao, $idAutor) {
    // Conectar ao banco de dados
    require_once 'config.php';
    $conn = conectarDB();
    
    // Validar dados de entrada
    if (empty($titulo) || $idAutor <= 0) {
        return [
            'sucesso' => false,
            'mensagem' => 'Título e autor são obrigatórios.'
        ];
    }
    
    // Preparar query SQL baseada na presença do ano
    if (empty($anoPublicacao)) {
        $stmt = $conn->prepare(
            "INSERT INTO livros (titulos, ano_publicado, autores_id_autores) 
             VALUES (?, NULL, ?)"
        );
        $stmt->bind_param("si", $titulo, $idAutor);
    } else {
        $ano = intval($anoPublicacao);
        $stmt = $conn->prepare(
            "INSERT INTO livros (titulos, ano_publicado, autores_id_autores) 
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sii", $titulo, $ano, $idAutor);
    }
    
    // Executar query
    $resultado = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    // Retornar resultado
    if ($resultado) {
        return [
            'sucesso' => true,
            'mensagem' => 'Livro cadastrado com sucesso!'
        ];
    } else {
        return [
            'sucesso' => false,
            'mensagem' => 'Não foi possível cadastrar o livro.'
        ];
    }
}
?>
```

### Função: Listar Livros

```php
<?php
// Função para listar todos os livros com seus autores
function listarLivros() {
    // Conectar ao banco de dados
    require_once 'config.php';
    $conn = conectarDB();
    
    // Query SQL com JOIN para obter nome do autor
    $sql = "SELECT 
                l.id_livros AS id_livro, 
                l.titulos AS titulo, 
                l.ano_publicado AS ano_publicacao, 
                a.nome_autor 
            FROM livros l 
            LEFT JOIN autores a ON a.id_autores = l.autores_id_autores
            ORDER BY l.titulos ASC";
    
    // Executar query
    $resultado = $conn->query($sql);
    
    // Verificar se há resultados
    if ($resultado && $resultado->num_rows > 0) {
        $livros = [];
        while ($row = $resultado->fetch_assoc()) {
            $livros[] = [
                'id' => $row['id_livro'],
                'titulo' => $row['titulo'],
                'autor' => $row['nome_autor'] ?: 'Não informado',
                'ano' => $row['ano_publicacao'] ?: '-'
            ];
        }
        $resultado->free();
        $conn->close();
        return $livros;
    } else {
        $conn->close();
        return [];
    }
}
?>
```

### Função: Excluir Livro

```php
<?php
// Função para excluir um livro do banco de dados
function excluirLivro($idLivro) {
    // Validar ID
    if ($idLivro <= 0) {
        return [
            'sucesso' => false,
            'mensagem' => 'ID de livro inválido.'
        ];
    }
    
    // Conectar ao banco de dados
    require_once 'config.php';
    $conn = conectarDB();
    
    // Preparar query de exclusão
    $stmt = $conn->prepare("DELETE FROM livros WHERE id_livros = ?");
    $stmt->bind_param("i", $idLivro);
    
    // Executar query
    $resultado = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    // Retornar resultado
    if ($resultado) {
        return [
            'sucesso' => true,
            'mensagem' => 'Livro excluído com sucesso!'
        ];
    } else {
        return [
            'sucesso' => false,
            'mensagem' => 'Não foi possível excluir o livro.'
        ];
    }
}
?>
```

---

## 🔐 Segurança

- ✅ **Prepared Statements**: Todas as queries usam prepared statements para prevenir SQL Injection
- ✅ **Validação de Dados**: Validação tanto no cliente quanto no servidor
- ✅ **Sanitização**: Uso de `htmlspecialchars()` para prevenir XSS
- ✅ **Validação de Tipos**: Conversão e validação de tipos de dados (intval, trim)

---

## 📌 Observações Importantes

1. **Ordem de Cadastro**: É necessário cadastrar autores antes de cadastrar livros, pois os livros dependem de autores existentes.

2. **Exclusão de Autores**: A exclusão de um autor que possui livros vinculados pode gerar erro devido à constraint de chave estrangeira. O sistema trata isso adequadamente.

3. **Ano de Publicação**: O campo ano é opcional, permitindo cadastrar livros sem data de publicação.

4. **Porta MySQL**: Verifique a porta do MySQL no seu XAMPP (geralmente 3306 ou 3307) e ajuste no `config.php`.

---

## 👨‍💻 Desenvolvido por

[Seu Nome]

---

## 📄 Licença

Este projeto foi desenvolvido para fins acadêmicos.

---

## 📞 Suporte

Para dúvidas ou problemas, verifique:
- Configuração do banco de dados no `config.php`
- Status do MySQL no painel do XAMPP
- Logs de erro do PHP

---

**Versão**: 1.0  
**Última atualização**: 2025

