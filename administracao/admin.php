<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="files/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="files/css/style.css">

</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="offset-2 col-8 offset-md-3 col-md-6 col-lg-6">
			<form action="obj/controle_login.php" method="POST" class="formLoginAdmin">
				<div class="form-group">
					<label for="idLogin">Login: </label>
					<input class="form-control" type="text" name="login" id="idLogin" autocomplete="off">
				</div>
				<div class="form-group">
					<label for="idPassword">Senha: </label>
					<input class="form-control" type="password" name="password"	id="idPassword">
				</div>
				<div class="form-group">
					<a href="#">Esqueci Minha Senha</a>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Entrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="files/js/fontawesome-all.js"></script>
<script type="text/javascript" src="files/js/bootstrap.min.js"></script>
<script type="text/javascript" src="files/js/popper.min.js"></script>
<script type="text/javascript" src="" rc="files/js/jquery-3.3.1.js"></script>
</body>
</html>