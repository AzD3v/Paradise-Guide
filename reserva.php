<?php 

        # Função que possui como objetivo registar uma reserva para um dado utilizador
        function registarReserva($idUser, $idAtividade, $nCartao){
        
            $sql ='INSERT INTO visita (user, idImovel, dataVisita, estadoVisita) VALUES(:user, :idImovel, :dataVisita, :estadoVisita)';
            $dia = $dia . " " . $hora;
            $arr = array('user' => utf8_encode($idUser) , 'idImovel' => utf8_encode($imovel->getIdImovel()), 'dataVisita' => utf8_encode($dia), 'estadoVisita' => ("Em apreciação"));
            //var_dump($arr);
            $this->query($sql, $arr);

      }

?>