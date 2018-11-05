<!-- Incluir a configuração/conexão à base de dados --> 
<?php include_once("db_config.php"); ?>

<?php 

    class Activity {

        # Atributos da classe Activity 
        public $idAtividade;
        public $idCategoria;
        public $nomeAtividade;
        public $descricaoAtividade;
        public $zonaAtividade;
        public $imagemAtividade;
        public $precoAtividade;
        public $duracaoAtividade;
        
        # Setters 
        public function setNomeAtividade($nomeAtividade) {
            $this->nomeAtividade = $nomeAtividade;
        }

        public function setDescricaoAtividade($descricaoAtividade) {
            $this->descricaoAtividade = $descricaoAtividade;
        }

        public function setZonaAtividade($zonaAtividade) {
            $this->zonaAtividade = $zonaAtividade;
        }

        public function setImagemAtividade($imagemAtividade) {
            $this->imagemAtividade = $imagemAtividade;
        }

        public function setPrecoAtividade($precoAtividade) {
            $this->precoAtividade = $precoAtividade;
        }

        public function setDuracaoAtividade($duracaoAtividade) {
            $this->duracaoAtividade = $duracaoAtividade;
        }

        // Método que retorna todas as atividades
        public static function find_all_activities()
        {
            return self::find_this_query("SELECT * FROM atividades");
        }

        public static function find_user_activities($idUser)
        {
            $the_result_array = self::find_this_query("SELECT * FROM reservas WHERE idUser = $idUser");

            return !empty($the_result_array) ? array_shift($the_result_array) : false;

        }

        // Método que encontra o ID de uma atividade pelo nome da mesma
        public static function find_id_by_username($nomeAtividade)
        {
            $the_result_array = self::find_this_query("SELECT * FROM atividades WHERE Nomeatividade = '$nomeAtividade' LIMIT 1");

            return !empty($the_result_array) ? array_shift($the_result_array) : false;

        }

        // "Helper method" que retorna qualquer query que passe por ele
        public static function find_this_query($sql)
        {

            // Incluir a classe Database
            global $database;

            // Obter o resultado do método
            $result_set = $database->query($sql);
            $the_object_array = [];

            while ($row = mysqli_fetch_array($result_set)) {

                $the_object_array[] = self::auto_instantiate($row);

            }

            return $the_object_array;

        }

        // "Helper method" que instancia a classe Activity automaticamente
        public static function auto_instantiate($the_record)
        {

            // Instanciar a classe Activity
            $the_object = new self;

            // Iterar sobre os dados obtidos e atribuição de propriedades dinâmica
            foreach ($the_record as $the_attribute => $value) {

                if($the_object->has_the_attribute($the_attribute)) {

                    $the_object->$the_attribute = $value;

                }

            }

            return $the_object;

        }

        // Verificar se um objeto possui um dado atributo
        private function has_the_attribute($the_attribute)
        {
            // Acesso a todas as propriedades de um objeto 
            $object_properties = get_object_vars($this);

            // Retornar "true" ou "false" caso a propriedade exista ou não no objeto
            return array_key_exists($the_attribute, $object_properties);

        }

    }

?>