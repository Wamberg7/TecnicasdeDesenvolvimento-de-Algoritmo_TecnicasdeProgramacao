<?php
// Configurações de conexão com o banco de dados
// Configurado conforme o phpMyAdmin (config.inc.php)
define('DB_HOST', '127.0.0.1'); // Usando 127.0.0.1 conforme phpMyAdmin
define('DB_USER', 'root');
define('DB_PASS', ''); // Senha vazia conforme phpMyAdmin
define('DB_PORT', 3307); // Porta 3307 conforme phpMyAdmin
define('DB_NAME', 'trabalhoberg');

// Função para conectar ao banco de dados
function conectarDB() {
    $conn = null;
    $erro_final = '';
    $senhas_tentadas = [];
    
    // Lista de senhas comuns para tentar
    $senhas_para_tentar = [];
    if (DB_PASS !== '') {
        $senhas_para_tentar[] = DB_PASS; // Primeiro tenta a senha configurada
    }
    $senhas_para_tentar[] = ''; // Sem senha
    $senhas_para_tentar[] = 'root'; // Senha comum no XAMPP
    
    // Tenta conectar com cada senha
    // Primeiro tenta com a porta configurada (3307), depois tenta porta padrão (3306)
    $portas_para_tentar = [DB_PORT, 3306];
    
    foreach ($portas_para_tentar as $porta) {
        foreach ($senhas_para_tentar as $senha) {
            try {
                // Desabilita exceções temporariamente para verificar connect_error
                mysqli_report(MYSQLI_REPORT_OFF);
                $conn = @new mysqli(DB_HOST, DB_USER, $senha, '', $porta);
                
                if ($conn && !$conn->connect_error) {
                    // Conexão bem-sucedida!
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                    break 2; // Sai dos dois loops
                } else {
                    if ($conn) {
                        $erro_final = $conn->connect_error;
                    }
                    $senhas_tentadas[] = ($senha === '' ? '(vazia)' : '***') . " (porta $porta)";
                    $conn = null;
                }
            } catch (Exception $e) {
                $erro_final = $e->getMessage();
                $senhas_tentadas[] = ($senha === '' ? '(vazia)' : '***') . " (porta $porta)";
                $conn = null;
            }
        }
    }
    
    // Reabilita relatórios de erro
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    // Se nenhuma conexão funcionou, mostra erro
    if (!$conn || $conn->connect_error) {
        $erro_msg = $erro_final ? $erro_final : 'Não foi possível conectar ao banco de dados';
        die("
        <div style='padding: 20px; font-family: Arial; border: 2px solid #dc3545; border-radius: 5px; background: #f8d7da; color: #721c24; margin: 20px;'>
            <h3>Erro de Conexão com o Banco de Dados</h3>
            <p><strong>Erro:</strong> " . htmlspecialchars($erro_msg) . "</p>
            <p><strong>Senhas testadas:</strong> " . implode(', ', $senhas_tentadas) . "</p>
            <p><strong>Possíveis soluções:</strong></p>
            <ul>
                <li><strong>1. Verifique se o MySQL está rodando:</strong> Abra o painel de controle do XAMPP e verifique se o MySQL está com status verde (Running)</li>
                <li><strong>2. Descubra a senha correta:</strong> 
                    <ul>
                        <li>Acesse o phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>
                        <li>Se pedir senha, essa é a senha que você precisa usar</li>
                        <li>Edite o arquivo <strong>config.php</strong> na linha 6 e coloque: <code>define('DB_PASS', 'sua_senha_aqui');</code></li>
                    </ul>
                </li>
                <li><strong>3. Execute o teste de conexão:</strong> <a href='testar-conexao.php' style='color: #721c24; font-weight: bold; text-decoration: underline;'>testar-conexao.php</a> para descobrir automaticamente a senha correta</li>
                <li><strong>4. Se não tiver senha configurada:</strong> Pode ser necessário redefinir a senha do MySQL ou configurar para aceitar conexões sem senha</li>
            </ul>
            <p><strong>Configuração atual no config.php:</strong></p>
            <ul>
                <li>Host: " . DB_HOST . "</li>
                <li>Porta: " . DB_PORT . "</li>
                <li>Usuário: " . DB_USER . "</li>
                <li>Senha: " . (DB_PASS ? '***' : '(vazia)') . "</li>
            </ul>
            <p><strong>Configuração do phpMyAdmin (para referência):</strong></p>
            <ul>
                <li>Host: 127.0.0.1</li>
                <li>Porta: 3307</li>
                <li>Usuário: root</li>
                <li>Senha: (vazia)</li>
            </ul>
            <p style='margin-top: 20px; padding: 10px; background: #fff3cd; border-left: 4px solid #ffc107;'>
                <strong>💡 Dica rápida:</strong> Acesse <a href='http://localhost/phpmyadmin' target='_blank'>phpMyAdmin</a> e veja se pede senha. 
                Se pedir, use essa mesma senha no arquivo config.php.
            </p>
        </div>
        ");
    }
    
    // Verifica se o banco existe, se não existir, cria
    $db_check = $conn->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    if ($db_check->num_rows == 0) {
        $conn->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }
    
    // Seleciona o banco
    $conn->select_db(DB_NAME);
    
    // Define o charset
    $conn->set_charset("utf8mb4");
    
    return $conn;
}
?>

