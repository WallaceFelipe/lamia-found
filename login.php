<?php
	require_once('class/Conexao.class.php');
	require_once('class/Usuario.class.php');
	

	if (isset($_POST['acao']) && $_POST['acao'] == 'logar') {

		// Fazer do jeito abaixo possibilita um MYSQLInjection
		$login = $_POST['login'];
		$senha = $_POST['senha'];

		$conexao = new Conexao();

		// O jeito correto é
		$login = $conexao->escape($_POST['login']);
		$senha = $conexao->escape($_POST['senha']);
		
		//$id = $conexao->select('id')->from('usuario')->where("login = '$login' and senha = '$senha'")->executeNGet();
		//$id = $id[0]['id'];

		$id = $conexao->select('id')->from('usuario')->where("login = '$login' and senha = '$senha'")->limit(1)->executeNGet('id');

		if($id) {
			session_start();
			$_SESSION['logado'] = true;
			$_SESSION['usuario'] = new Usuario($id);
			if (isset($_SESSION['idfinanciado'])) {
				$url = 'Location: index_public.php?p=financiar_projeto&id='.$_SESSION['idfinanciado'];
			}else
				if ($_SESSION['usuario']->tipo == 'usuariopublico') {
					$url = 'Location: index_public.php';	
				} else {
					$url = 'Location: index.php';
				}
			header($url);
		}

		$msg = "Login ou senha inválido. Tente novamente!";

	}

	if(isset($_GET['c']) && $_GET['c'] == 'ok') {
		$msg = "Cadastro realizado com sucesso! Por favor, faça seu login.";
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h2>Log in</h2>
				</div>
				<div class="panel-body">
					<div class="form-group"><p><?php echo $msg;?></p></div>
					<form role="form" action="" method="post" >
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Login" name="login" type="text" autofocus="" required>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Senha" name="senha" type="password" value="" required>
							</div>
							<button type="submit" name='acao' value='logar' class="btn btn-primary">Login</button>
						</fieldset>
						</br>
						<p>Ainda não se é membro? <a href="cadastro.php">Cadastre-se!</a></p>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
