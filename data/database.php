<!-- Incluir o ficheiro de configuração da base de dados -->
<?php include_once("db_config.php"); ?>

<?php

    class Database
    {

        public $connection;

        // Método construtor
        function __construct()
        {
            $this->open_db_connection();
        }

        // Método que abre a conexão à base de dados
        public function open_db_connection()
        {

            // Criar a conexão à base de dados
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


            if ($this->connection->connect_errno) {

                die("A conexão à base de dados falhou! " . $this->connection->connect_error);

            }

        }

        // Método que permite fazer queries
        public function query($sql)
        {
            $result = $this->connection->query($sql);
            return $result;
            $this->confirm_query($result);
        }

        // Método que confirma as queries feitas
        private function confirm_query($result)
        {
            if (!$result) {
                die ("A query falhou! " . $this->connection->error);
            }
        }

    }

    $database = new Database();

?>