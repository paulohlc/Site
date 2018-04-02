<?php
require_once("Sql.php");

class Eventos{	
	private $fotos;
	private $pasta_fotos;

	//Método para cadastrar os dados no banco
	public function cadastrarEvento($nome, $conteudo, $data, $hora, $endereco, $localRefencia)
	{		

		$geocode = $this->geocode($endereco);

		$sql = new Sql();
		
		
		$getNome = $sql->select("SELECT * FROM eventos where nome = :NOME", $param = array(
			':NOME'=>$nome
		));
		

		$numNome = count($getNome);

		if($numNome < 1){ 

		// variavel id, pois o $sql->query() retorna o valor do ultimo ID
			$id = $sql->query("INSERT INTO eventos (nome, conteudo, data, hora, endereco, local_referencia, latitude, longitude) VALUES (:NOME, :CONTEUDO, :DATA, :HORA, :ENDERECO, :LOCAL_REFERENCIA, :LATITUDE, :LONGITUDE)", $params = array(
				':NOME' => utf8_decode($nome),
				':CONTEUDO' => utf8_decode($conteudo),
				':DATA' => $data,
				':HORA' => $hora,
				':ENDERECO' => utf8_decode($endereco),
				':LOCAL_REFERENCIA' => utf8_decode($localRefencia),
				':LATITUDE' => $geocode[0],
				':LONGITUDE' => $geocode[1]
			));

			for ($i=0; $i < count($this->fotos); $i++) { 
				$sql->query("INSERT INTO imagem_evento (id, nome, pasta) VALUES (:ID, :NOME, :PASTA)", $params = array(
					':ID' => $id,
					':NOME' => $this->fotos[$i],
					':PASTA' => $this->pasta_fotos
				));				
			}
		}else{ echo "<script> alert('Evento já existente, tente colocar outra edição, ou outro nome de evento');</script>";}


		

	}

	public function cadImagem($folder,$imagem)
	{
		$caminho_imagem = "../files/images/eventos/$folder/";
		if(!is_dir($caminho_imagem)){
			mkdir($caminho_imagem);
		}
		
		for ($i=0; $i < count($imagem['name']); $i++) { 
			//Analisa qual a extensao da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"][$i], $ext);
			//Cria um nome unico pra imagem
			$nome_imagem[$i] = md5(uniqid(time())).".".$ext[1];
			//Cria o caminho que a fotos deve ser gravada
			$caminho_imagem = "../files/images/eventos/$folder/".$nome_imagem[$i];
			//Grava as fotos no caminho
			move_uploaded_file($imagem["tmp_name"][$i], $caminho_imagem);
		}

		$this->fotos = $nome_imagem;

		$this->pasta_fotos = "$folder/";
		
	}

	public function buscarEventos(){



		$sql = new Sql();
		$results = $sql->select("SELECT * FROM eventos ORDER BY `data` DESC");


		$diasSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
		$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

		$res = array('$results','$diasSemana', '$meses');


		echo "
		<div class='col-12' style='border:1px solid #000; padding: 10px;border-radius: 5px; background-color: #fff;height: 60vh; overflow: auto;'>

		<table class='table table-striped'>		
		<tr>		
		<th>Data</th>
		<th>Hora</th>	
		<th>Nome do Evento</th>
		</tr>
		";

		foreach ($results as $result) {
			$dia = $diasSemana[date('w',strtotime($result['data']))];
			$mes = $meses[date('n', strtotime($result['data']))-1];
			$data = $dia.", ".date("d * @ $ Y", strtotime($result['data']));
			$data = str_replace("*", "de", $data);
			$data = str_replace("@", $mes, $data);
			$data = str_replace("$", "de", $data);

			$hora = substr($result['hora'], 0, -3);

			echo "<tr>
			<td>$data</td>
			<td>". $hora ."</td>
			<td><a style='color:#212529' href='?id=".$result['id']."'>" .$result['nome']. "</a></td>
			</tr>";
		}


		echo "</table>";	

	}

	function buscarEventoEspecifico($id){

		$sql = new Sql();
		$results = array();
		$result = $sql->select("SELECT e.nome, e.conteudo, e.data, e.hora, e.endereco, e.local_referencia FROM eventos as e WHERE e.id = :ID ", array(
			':ID' => $id
		));

		array_push($results, $result);

		$result = $sql->select("SELECT * FROM imagem_evento WHERE id = :ID ", array(
			':ID' => $id
		));		

		array_push($results, $result);

		return $results; 


	}

	function geocode($address){

    // url encode the address
		$address = urlencode($address);

    // google map geocode api url
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyBA1TKoGZ58eib4P2SMaEXlFCU6wJ4dKBQ";

    // get the json response
		$resp_json = file_get_contents($url);

    // decode the json
		$resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address 
		if($resp['status']=='OK'){

        // get the important data
			$lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
			$longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
			$formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

        // verify if data is complete
			if($lati && $longi && $formatted_address){

            // put the data in the array
				$data_arr = array();            

				array_push(
					$data_arr, 
					$lati, 
					$longi, 
					$formatted_address
				);

				return $data_arr;

			}else{
				return false;
			}

		}

		else{
			echo "<strong>ERROR: {$resp['status']}</strong>";
			return false;
		}
	}


}