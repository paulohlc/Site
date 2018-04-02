<?php
require_once("Sql.php");

class Noticias{	
	private $fotos;
	private $pasta_fotos;

	//Método para cadastrar os dados no banco
	public function cadastrarNoticia($titulo, $subtitulo, $data, $conteudo)
	{
		$sql = new Sql();


		$getNome = $sql->select("SELECT * FROM noticias where titulo = :NOME", $param = array(
			':NOME'=>$titulo
		));
		

		$numNome = count($getNome);

		if($numNome < 1){ 		
		// variavel id, pois o $sql->query() retorna o valor do ultimo ID
			$id = $sql->query("INSERT INTO noticias (titulo, subtitulo, data, conteudo) VALUES (:TITULO, :SUBTITULO, :DATA, :CONTEUDO)", $params = array(
				':TITULO' => utf8_decode($titulo),
				':SUBTITULO' => utf8_decode($subtitulo),
				':DATA' => $data,
				':CONTEUDO' => utf8_decode($conteudo)
			));

			for ($i=0; $i < count($this->fotos); $i++) { 
				$sql->query("INSERT INTO imagem_noticia (id, nome, pasta) VALUES (:ID, :NOME, :PASTA)", $params = array(
					':ID' => $id,
					':NOME' => $this->fotos[$i],
					':PASTA' => $this->pasta_fotos
				));				
			}}else{
				echo "<script> alert('Noticia já existente, tente colocar outra edição, ou outro nome de noticia');</script>";
			}



		}

		public function cadImagem($folder,$imagem)
		{
			$caminho_imagem = "../files/images/noticias/$folder/";
			if(!is_dir($caminho_imagem)){
				mkdir($caminho_imagem);
			}

			for ($i=0; $i < count($imagem['name']); $i++) { 
			//Analisa qual a extensao da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"][$i], $ext);
			//Cria um nome unico pra imagem
				$nome_imagem[$i] = md5(uniqid(time())).".".$ext[1];
			//Cria o caminho que a fotos deve ser gravada
				$caminho_imagem = "../files/images/noticias/$folder/".$nome_imagem[$i];
			//Grava as fotos no caminho
				move_uploaded_file($imagem["tmp_name"][$i], $caminho_imagem);
			}

			$this->fotos = $nome_imagem;

			$this->pasta_fotos = "$folder/";

		}

		public function buscarNoticias(){

			$sql = new Sql();
			$results = $sql->select("SELECT * FROM noticias ORDER BY `data` DESC");


			$diasSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
			$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

			$res = array('$results','$diasSemana', '$meses');



			echo "
			<div class='col-12' style='border:1px solid #000; padding: 10px;border-radius: 5px; background-color: #fff;height: 60vh; overflow: auto;'>

			<table class='table table-striped'>		
			<tr>		
			<th>Data</th>	
			<th>Título</th>
			</tr>
			";

			foreach ($results as $result) {
				$dia = $diasSemana[date('w',strtotime($result['data']))];
				$mes = $meses[date('n', strtotime($result['data']))-1];
				$data = $dia.", ".date("d * @ $ Y", strtotime($result['data']));
				$data = str_replace("*", "de", $data);
				$data = str_replace("@", $mes, $data);
				$data = str_replace("$", "de", $data);
				echo "<tr>
				<td>$data</td>
				<td><a style='color:#212529' href='?id=".$result['id']."'>" .$result['titulo']. "</a></td>
				</tr>";
			}


			echo "</table>";	

		}

		function buscarNoticiaEspecifica($id){

			$sql = new Sql();
			$results = array();
			$result = $sql->select("SELECT * FROM noticias WHERE id = :ID ", array(
				':ID' => $id
			));

			array_push($results, $result);

			$result = $sql->select("SELECT * FROM imagem_noticia WHERE id = :ID ", array(
				':ID' => $id
			));		

			array_push($results, $result);

			return $results; 

		}



	}