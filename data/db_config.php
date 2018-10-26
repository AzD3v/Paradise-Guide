<?php

    // Variáveis de conexão à base de dados
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'Pass-123147159');
    define('DB_NAME', 'paradise');

    // Abrir a conexão à base de dados
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verificar a conexão à base de dados 
    if ($this->connection->connect_errno) {

        die("A conexão à base de dados falhou " . $this->connection->connect_error);

    }

?>