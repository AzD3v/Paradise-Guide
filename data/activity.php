<!-- Incluir a configuração/conexão à base de dados --> 
<?php include_once("db_config.php"); ?>

<?php 

    class Activity {

        # Atributos da classe Activity 
        public $idAtividade;
        public $idAdmin;
        public $nomeCartao;
        public $nomeAtividade;
        public $descricaoAtividade;
        public $zonaAtividade;
        public $imagemAtividade;
        public $precoAtividade;
        public $duracaoAtividade;
        public $estadoAtividade;
        
        // Método que retorna todas as atividades
        public static function find_all_activities()
        {
            return self::find_this_query("SELECT * FROM atividades");
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