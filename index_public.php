<?php
require_once('class/Usuario.class.php');
session_start();


$pagina = 'inicial_public.php';
if(isset($_GET['p'])){
	$pagina = $_GET['p'].".php";
}


$tipos = array(
	'pesquisa'=>'Pesquisa', 
	'competicaotecnologica'=>'Competição Tecnológica', 
	'inovacaoensino' => 'Inovação no Ensino', 
	'manutencaoreforma' => 'Manutenção e Reforma', 
	'pequenasobras' => 'Pequenas Obras');

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
					<li class=" pull-right">
						<a href="index.php?p=login"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg></a>
					
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Pesquisar...">
			</div>
		</form>
		<ul class="nav menu">
			<!-- Menu que chama as pages -->
			<li <?php if ($_GET['p'] == 'inicio' || empty($_GET['p'])) echo "class='active'"; ?> ><a href="index_public.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Início</a></li>
			<?php foreach($tipos as $k=>$t) { ?>
			<li <?php if ($_GET['cat'] == $k) echo "class='active'"; ?> ><a href="index_public.php?p=inicial_public&cat=<?php echo $k; ?>"><svg class="glyph stroked male user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $t; ?></a></li>
			<?php } ?>
			<!--

			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>-->
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
