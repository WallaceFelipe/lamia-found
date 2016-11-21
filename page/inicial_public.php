<?php
$conexao = new Conexao();

$tipos = array(
	'pesquisa'=>'Pesquisa', 
	'competicaotecnologica'=>'Competição Tecnológica', 
	'inovacaoensino' => 'Inovação no Ensino', 
	'manutencaoreforma' => 'Manutenção e Reforma', 
	'pequenasobras' => 'Pequenas Obras');

if($_GET['finalizar']){

	if($_SESSION['usuario']->getTipo() == 'gestordeprojeto'){
		$conexao->update('projeto', array('status'=>'finalizado'), intval($_GET['finalizar']), 'id');
		echo "<script>alert('Projeto finalizado com sucesso!');</script>";
	}

}
?>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Projetos</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Principais Projetos</h1>
	</div>
</div><!--/.row-->


<div class="row">
	
	<?php 
	foreach($tipos as $k=>$titulo){
		$projeto = $conexao->select('*')->from('projeto')->where("status = 'aprovado' and categoria = '".$_GET['cat']."'")->executeNGet(); 
		if(count($projeto) > 0){ ?>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Projetos de <?php echo $titulo;  ?></div>
				<div class="panel-body">
					<?php 
					
					foreach($projeto as $p){ ?>
					
						<div class="col-sm-3">
							<div class="col-lg-12">
								<a class="prj_link" href="index_public.php">
								<img src="upload/<?php echo $p['imagem']; ?>" alt="<?php echo $p['nome']; ?>" class="img-responsive">
								</a>
								<h3><?php echo $p['nome']; ?></h3>
								<?php /*if($_SESSION['usuario']->getTipo() == 'gestordeprojeto' && $p['status'] != 'finalizado'){ ?>
								<button onclick="if(confirm('Tem certeza?')) location.href='index_public.php?p=inicial_public&finalizar=<?php echo $p['id']; ?>';" class="btn btn-primary btn-xs">Finalizar</button>
								<?php  }*/ ?>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</div>
					
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } 

	}
	?>

	

	
</div><!--/.row-->	
