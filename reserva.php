<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("data/database.php"); ?>

<!-- Incluir a classe User -->
<?php include_once("data/user.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("data/activity.php"); ?>


<!-- Session start --> 
<?php session_start(); ?>

<?php


    # Obter o ID do utilizador que possui sessão iniciada
    $username = $_SESSION["client"];
    $user_id = User::find_id_by_username($username);
    $user_id->idUser;

    
    

      //   # Função que possui como objetivo registar uma reserva para um dado utilizador
      //   function registarReserva($idUser, $idAtividade, $nCartao){
        
      //       $sql ='INSERT INTO visita (user, idImovel, dataVisita, estadoVisita) VALUES(:user, :idImovel, :dataVisita, :estadoVisita)';
      //       $dia = $dia . " " . $hora;
      //       $arr = array('user' => utf8_encode($idUser) , 'idImovel' => utf8_encode($imovel->getIdImovel()), 'dataVisita' => utf8_encode($dia), 'estadoVisita' => ("Em apreciação"));
      //       //var_dump($arr);
      //       $this->query($sql, $arr);

      // }

?>