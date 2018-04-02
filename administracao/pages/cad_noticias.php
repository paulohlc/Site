<?php require_once("header.php"); ?>

<div class="container-fluid" >
	<div class="row">
		<?php require_once("side_menu.php");?>

		<div class="offset-1 col-8 bg-novaNoticia">
			<div>
				<h1>Nova Notícia</h1>
				<form action="cad_noticias.php" method="post" enctype="multipart/form-data" class="form">
					<div class="col-12">
						<div class="form-group col-8">
							<label for="idTitulo">*Título: </label>
							<input class="form-control" type="text" name="titulo" id="idTitulo" required autocomplete="off">
						</div>
						<div class="form-group col-12">
							<label for="idSubtitulo">*Subtítulo: </label>
							<input class="form-control" type="text" name="subtitulo" id="idSubtitulo" autocomplete="off">	
						</div>

						<div class="form-group col-3" >
							<label for="idData">*Data: </label>
							<input class="form-control" type="date" name="data" id="idData" required value="<?php echo date('Y-m-d'); ?>">		
						</div>

						<div class="form-group col-11">
							<label for="idConteudo">*Conteúdo: </label>
							<textarea class="form-control" name="conteudo" id="idConteudo" rows="6" required></textarea>	
						</div>

						<div class="row">
							<div class="col-10 form-group">
								<input type="file" name="imagem[]" id="idImagem" multiple>							
							</div>
							<div class="col-2"><button class="btn btn-primary" type="submit"><b>Cadastrar</b></button></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php

require_once("../classes/Noticias.php");

if(!empty($_POST)){
	$cadNoticias = new Noticias();

	$cadNoticias->cadImagem(md5(time().$_POST['titulo']),$_FILES['imagem']);
	$cadNoticias->cadastrarNoticia($_POST['titulo'], $_POST['subtitulo'], $_POST['data'], $_POST['conteudo']);
}

require_once("footer.php");
?>