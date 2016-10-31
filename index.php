<?php

$pagina = 'inicial.php';
if(isset($_GET['p'])){
	//baseado no atributo p ele define qual pagina inclui
	switch($_GET['p']){

		case 'criterio':
			$pagina = 'criterio.php';
			$titulo = "Critérios de Avaliação";
			break;

		case 'usuario_cad':
			$pagina = 'usuario_cad.php';
			$titulo = 'Cadastrar Usuário';
			break;
		case 'usuario_consulta':
			;
			$pagina = 'usuario_consulta.php';
			$titulo = 'Contato';
			break;
		case 'projeto_cad':
			$pagina = 'projeto_cad.php';
			$titulo = 'Cadastrar Projeto';
			break;
		case 'projeto_consulta':
			$pagina = 'projeto_consulta.php';
			$titulo = 'Consultar Projetos';
			break;
		default:
			if(is_file('page/'.$_GET['p'].'.php')){
				$pagina = $_GET['p'].'.php';
				$titulo = ucwords($_GET['p']);
				break;
			}

			$pagina = 'inicial.php';
			$titulo = 'Bem vindo!';

	}

}
/* 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	esta funcao estava sobrescrevendo a pagina corretamente definida acima.
	switch($_POST['p']) {
		case 'projeto_cad':
			$pagina = 'projeto_cad.php';
			$titulo = 'Cadastrar Projeto';
			break;

	}
	
}
*/

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lumino - Tables</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/bootstrap-table.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

	<!--Icons-->
	<script src="js/lumino.glyphs.js"></script>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Fund</span>Razor</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<!-- Menu que chama as pages -->
			<li <?php if ($_GET['p'] == 'inicio' || empty($_GET['p'])) echo "class='active'"; ?> ><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li <?php if ($_GET['p'] == 'usuario_cad') echo "class='active'"; ?> ><a href="index.php?p=usuario_cad"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> Cadastrar Usuário</a></li>
			<li <?php if ($_GET['p'] == 'usuario_consulta') echo "class='active'"; ?> ><a href="index.php?p=usuario_consulta"><svg class="glyph stroked eye"><use xlink:href="#stroked-eye"></use></svg> Consulta Usuário</a></li>
			<li <?php if ($_GET['p'] == 'projeto_cad') echo "class='active'"; ?> ><a href="index.php?p=projeto_cad"><svg class="glyph stroked open folder"><use xlink:href="#stroked-open-folder"/></svg>Cadastrar Projeto</a> </li>
			<li <?php if ($_GET['p'] == 'projeto_consulta') echo "class='active'"; ?> ><a href="index.php?p=projeto_consulta"><svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg>Consultar Projeto</a> </li>
			<li <?php if ($_GET['p'] == 'criterio') echo "class='active'"; ?> ><a href="index.php?p=criterio"><svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg>Critérios de Avaliação</a> </li>
			<li <?php if ($_GET['p'] == 'repassefinanceiro') echo "class='active'"; ?> ><a href="index.php?p=repassefinanceiro"><svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg>Repasses Financeiros</a> </li>
			
			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
		</ul>

	</div><!--/.sidebar-->

	
	<!--Inclui as paginas -->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<?php include('page/'.$pagina); ?>
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
			
			$(".data").mask('00/00/0000');
			$(".cpf").mask('000.000.000-00');
			$(".money").mask("#.##0,00", {reverse: true});

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
