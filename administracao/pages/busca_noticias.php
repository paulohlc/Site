<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Busca</title>
	<link rel="stylesheet" type="text/css" href="../files/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../files/css/style.css">	
	<link href="https://fonts.googleapis.com/css?family=Mina:700" rel="stylesheet">
</head>
<body>	
	<div class="container-fluid">

		<nav class="navbar navbar-toggleable-sm navbar-expand-lg navbar-light bg-inverse">
			<a href="" class="navbar-brand">ADMIN</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav">
					<li class="nav-item active">
						<a href="#" class="nav-link">Home</a>
					</li>
					<li class="nav-item">
						<a href="busca_noticias.php" class="nav-link">Notícias</a>
					</li>					
					<li class="nav-item">
						<a href="#" class="nav-link">Eventos</a>
					</li>										
				</ul>
			</div>
		</nav>



		<div class="container-fluid" >
			<div class="row">
				<div class="col-2 bg-menuNoticia">
					<ul class="nav">
						<li class="link"><button class="btn btn-primary"><a href="">Todas as Notícias</a></button></li>
						<li class="link"><button class="btn btn-primary"><a href="">Nova Notícia</a></button></li>
					</ul>


				</div>

				<div class="offset-1 col-8 bg-novaNoticia">
					<div>
						<h1>Notícia</h1>
						<form action="busca_noticias.php" method="post" enctype="multipart/form-data" class="form">

							<?php			

							require_once("../classes/Noticias.php");

							/*echo "
							<div class='col-12' style='border:1px solid #000; padding: 10px;border-radius: 5px; background-color: #fff;height: 60vh; overflow: auto;'>

							<table class='table table-striped'>

							<tr>
							<th>Título</th>
							<th>INDICAÇÃO</th>
							<th>DATA INDICAÇÃO</th>
							<th>DTA RECEBIDA</th>
							<th>VEREADOR</th>
							<th>ASSUNTO</th>
							<th>SECRETARIA(S)</th>
							<th>DATA DE ENVIO PARA SECRETARIA(S)</th>
							</tr>				
							";

							$buscaNoticias = new Noticias();

							$buscaNoticias->buscarNoticias();

							echo "
							</table>
							</div>";											
*/							
							//$id = $_GET['id'];

							if(!isset($_GET['id'])){

								$buscaNoticias = new Noticias();
								$noticias = $buscaNoticias->buscarNoticias();	


							}else{
								$buscaNoticias = new Noticias();
								$noticias = $buscaNoticias->buscarNoticiaEspecifica($_GET['id']);								


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
								</tr>
								";	

								$dia = $diasSemana[date('w', strtotime($noticias['data']))];
								$mes = $meses[date('n', strtotime($noticias['data']))-1];
								$data = $dia.", ".date("d * @ $ Y", strtotime($noticias['data']));
								$data = str_replace("*", "de", $data);
								$data = str_replace("@", $mes, $data);		
								$data = str_replace("$", "de", $data);

								$imagens = explode(';', $noticias['imagem']);
								//print_r($imagens);



								echo "<tr>
								<td>$data</td>
								<td>". utf8_decode($noticias['titulo']) ."</td>
								<td>" . utf8_decode($noticias['subtitulo']) . "</td>
								<td>" . utf8_decode($noticias['conteudo']) . "</td>
								<td>";


								//$noticias['pasta_imagem']

								for($i = 0; $i < count($imagens); $i ++){

									//echo $imagens[$i]. "<br>
									echo "<img src='../files/images/noticias/".$noticias['pasta_imagem'] .$imagens[$i]."'
									style='height: 150px; 
									border: 1px solid #000; 
									border-radius:5px'>";


								}

								echo "</td>


								</tr>";

								/*
								class='img-fluid'>
								</a>
								<div class='dropdown-divider'>
								</div>
								asd
*/






								/*echo "<tr>
								<td>".."</td>
								<td>".$noticias['titulo']."</td>
								</tr>	
								";*/															

								echo "</table>";
							}

							?>


							</form>
							</div>
							</div>
							</div>
							</div>






							<?php require_once("footer.php"); ?>