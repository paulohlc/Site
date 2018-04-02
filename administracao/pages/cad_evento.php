<?php require_once("header.php"); ?>

<div class="container-fluid" >
	<div class="row">
		<?php require_once("side_menu.php");?>

		<div class="offset-1 col-8 bg-novaNoticia">
			<div>
				<h1>Novo Evento</h1>
				<form action="cad_evento.php" method="post" enctype="multipart/form-data" class="form">
					<div class="col-12">
						<div class="form-group col-8">
							<label for="idNome">Nome do Evento: </label>
							<input class="form-control" type="text" name="nome" id="idNome" required autocomplete="off">
						</div>
						<div class="form-group col-12">
							<label for="idConteudo">Conteúdo: </label>
							<textarea class="form-control" name="conteudo" id="idConteudo" rows="6" required></textarea>
						</div>

						<div class="form-group col-3" >
							<label for="idData">Data: </label>
							<input class="form-control" type="date" name="data" id="idData" required value="<?php echo date('Y-m-d'); ?>">		
						</div>

						<div class="form-group col-2" >
							<label for="idHora">Hora: </label>
							<input class="form-control" type="text" name="hora" id="idHora" required placeholder="00:00" max="5" maxlength="5">		
						</div>						

						<div class="form-group col-11">
							<label for="idEndereco">Endereço: </label>
							<input class="form-control" type="text" name="endereco" id="idEndereco" required placeholder="Rua Afonso, 32, Jardim Bucampos">
						</div>

						<div class="form-group col-10">
							<label for="idLocalReferencia">Local de Referência: </label>
							<textarea class="form-control" name="localReferencia" id="idLocalReferencia" rows="3" required></textarea>
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

require_once("../classes/Eventos.php");

if(!empty($_POST)){
	$cadEventos = new Eventos();

	$cadEventos->cadImagem(md5(time().$_POST['nome']),$_FILES['imagem']);
	$cadEventos->cadastrarEvento($_POST['nome'], $_POST['conteudo'], $_POST['data'], $_POST['hora'], $_POST['endereco'], $_POST['localReferencia']);
}

require_once("footer.php");
?>