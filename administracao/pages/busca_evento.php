<?php require_once("header.php"); ?>

<div class="container-fluid" >
	<div class="row">

		<?php require_once("side_menu.php");?>

		<div class="offset-1 col-8 bg-novaNoticia">
			<div>
				<h1>Eventos</h1>
				<form action="busca_evento.php" method="post" enctype="multipart/form-data" class="form">

					<?php			

					require_once("../classes/Eventos.php");

					if(!isset($_GET['id'])){
						$buscaEventos = new Eventos();
						$eventos = $buscaEventos->buscarEventos();	

					}else{
						$buscaNoticias = new Eventos();
						$eventos = $buscaNoticias->buscarEventoEspecifico($_GET['id']);

						$imagens = $eventos[1];
						
						$eventos = $eventos[0][0];				

						$diasSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
						$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

						$dia = $diasSemana[date('w', strtotime($eventos['data']))];
						$mes = $meses[date('n', strtotime($eventos['data']))-1];
						$data = $dia.", ".date("d * @ $ Y", strtotime($eventos['data']));
						$data = str_replace("*", "de", $data);
						$data = str_replace("@", $mes, $data);		
						$data = str_replace("$", "de", $data);						

						echo "
						<div class='col-12' style='border:1px solid #000; padding: 10px;border-radius: 5px; background-color: #fff;height: 60vh; overflow: auto;'>

						<div align='center'> <h2><b><i>".utf8_decode($eventos['nome'])." </i></b></h2></div>";

						// imagens
						echo " <br>
						<div align='center'>";

						for($i = 0; $i < count($imagens); $i ++){
					
							$pasta = $imagens[$i]['pasta'];
							$imagem = $imagens[$i]['nome'];


							echo "<img src='../files/images/eventos/".$pasta .$imagem. "'

							class='img'
							style='border: 1px solid #000; 
							border-radius:5px'>";
						}		

						echo "</div><br>";				


						$conteudo = str_replace(chr(10),"<br/>",utf8_encode($eventos['conteudo']));

						echo "<b>Data: </b>". $data . "<br><b>Horário: </b>". $eventos['hora']."<br>". "<div align=center>" . "<b>Detalhes do Evento: </b><br><div id='conteudo'>".$conteudo. "</div></div><br>	". "<b>Endereço: </b>". utf8_encode($eventos['endereco']);



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