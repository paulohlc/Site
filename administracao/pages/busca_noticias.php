 <?php require_once("header.php"); ?> 

<div class="container-fluid" >
	<div class="row">

		<?php require_once("side_menu.php");?>

		<div class="offset-1 col-8 bg-novaNoticia">
			<div>
				<h1>Notícia</h1>
				<form action="busca_noticias.php" method="post" enctype="multipart/form-data" class="form">

					<?php			

					require_once("../classes/Noticias.php");

					if(!isset($_GET['id'])){
						$buscaNoticias = new Noticias();
						$noticias = $buscaNoticias->buscarNoticias();	

					}else{
						$buscaNoticias = new Noticias();
						$noticias = $buscaNoticias->buscarNoticiaEspecifica($_GET['id']);

						$imagens = $noticias[1];
						$noticias = $noticias[0][0];				

						$diasSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
						$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

						echo "
						<div class='col-12' style='border:1px solid #000; padding: 10px;border-radius: 5px; background-color: #fff;height: 60vh; overflow: auto;'>

						<table class='table table-striped'>		
						<tr>
						<th>Data</th>	
						<th>Título</th>
						<th>Subtitulo</th>
						<th>Conteudo</th>
						<th>Imagens</th>
						</tr>";	

						$dia = $diasSemana[date('w', strtotime($noticias['data']))];
						$mes = $meses[date('n', strtotime($noticias['data']))-1];
						$data = $dia.", ".date("d * @ $ Y", strtotime($noticias['data']));
						$data = str_replace("*", "de", $data);
						$data = str_replace("@", $mes, $data);		
						$data = str_replace("$", "de", $data);

						echo "<tr>
						<td>$data</td>
						<td>". utf8_decode($noticias['titulo']) ."</td>
						<td>" . utf8_decode($noticias['subtitulo']) . "</td>
						<td>" . utf8_decode($noticias['conteudo']) . "</td>
						<td>";

						for($i = 0; $i < count($imagens); $i ++){
							$pasta = $imagens[$i]['pasta'];
							$imagem = $imagens[$i]['nome'];

							echo "<img src='../files/images/noticias/".$pasta .$imagem."'
							style='height: 150px; 
							border: 1px solid #000; 
							border-radius:5px'>";
						}

						echo 
						"</td>
						</tr>										
						</table>";
					}

					?>


				</form>
			</div>
		</div>
	</div>
</div>

<?php require_once("footer.php"); ?>