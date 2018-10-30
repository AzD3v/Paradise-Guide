 <?php 

    // Variáveis de conexão à base de dados
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "Pass-123147159");
    define("DB_NAME", "paradise");

    // Definir DSN (Data Source Name) 
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

    // Testar a conexão à base de dados 
    try{
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e){
        die("A conexão à base de dados falhou! " . $e);
    }

?>