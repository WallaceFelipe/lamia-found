<?php

$conexao    = new Conexao();

if($_POST){

	$projeto = array();
	$projeto['nome'] = $_POST['nome'];
	$projeto['valor'] = floatval(str_replace( ',', '.', $_POST['valorp']));
	$projeto['valorminimo'] = floatval(str_replace( ',', '.', $_POST['valorminimo']));
	$projeto['valormaximo'] = floatval(str_replace( ',', '.', $_POST['valormaximo']));
	$projeto['categoria'] = $_POST['categoria'];
	$projeto['prazomaximo'] = date("Y-m-d", time() + ($projeto['duracaoprevista']*86400));
	$projeto['duracaoprevista'] = intval($_POST['duracaoprevista']);

	$id_projeto = intval($_GET['idprojeto']);
	
	// faz o upload
	if($_FILES['imagem']['name']){
		$projeto['imagem'] = md5(basename($_FILES['imagem']['name'])).time().substr($_FILES['imagem']['name'], strlen($_FILES['imagem']['name'])-4, strlen($_FILES['imagem']['name']));
		move_uploaded_file($_FILES['imagem']['tmp_name'], 'upload/'.$projeto['imagem']);
	}

	
	$pro_codigo = $conexao->update('projeto', $projeto, $id_projeto, 'id');
	

	$conexao->execute("delete from recompensa where idprojeto = '$id_projeto'");

	foreach($_POST['titulo'] as $k=>$t){

		if(strlen($t) > 0){

			$recompensa = array();
			$recompensa['idprojeto'] = $id_projeto;
			$recompensa['titulo']    = $t;
			$recompensa['limite'] = $_POST['limite'][$k];
			$recompensa['descricao'] = $_POST['descricao'][$k];
			$recompensa['valor'] = floatval(str_replace(',', '.', $_POST['valor'][$k]));



			if(!$conexao->insert('recompensa', $recompensa))
				echo "Falha ao cadastrar recompensa $t ".PHP_EOL;

		}

	}

	/*die("
	<script>
		alert('Projeto cadastrado com sucesso!'); 
		location.href='http://localhost/lamia-found/index.php?p=projeto_consulta';
	</script>");*/


}

$idprojeto = intval($_GET['idprojeto']);
$projeto = $conexao->select('*')->from('projeto')->where("id = '$idprojeto'")->limit(1)->executeNGet();
$recompensa = $conexao->select('*')->from('recompensa')->where("idprojeto = '$idprojeto'")->executeNGet();

?>

<style>
	.esconder{
		display:none;
	}
</style>


<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Cadastro de Projeto</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"></h1>
	</div>
</div><!--/.row-->


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">

			<form action="" method="POST"  enctype="multipart/form-data">
			<div class="panel-heading">

				Cadastrar Projeto
				<button type="submit" class="btn btn-primary pull-right">Salvar</button>
				
			</div>
			<div class="panel-body">
				
				<div class="col-sm-4">

					<h4>Informações Básicas</h4>

					<div class="form-group">
						<label for="">Foto do Projeto</label>
						<input type="file"  class="form-control" name="imagem">
					</div>

					<div class="form-group">
						<label for="">Título do Projeto</label>
						<input type="text" value="<?php echo $projeto['nome']; ?>"  required class="form-control" name="nome">
					</div>

					<div class="form-group">
						<label for="">Duração Prevista (em dias)</label>
						<input type="text" value="<?php echo $projeto['duracaoprevista']; ?>" required  class="form-control" name="duracaoprevista">
					</div>

					<div class="form-group">
						<label for="">Valor Mínimo</label>
						<input type="text" value="<?php echo $projeto['valorminimo']; ?>" required  class="form-control" name="valorminimo">
					</div>

					<div class="form-group">
						<label for="">Valor Máximo</label>
						<input type="text" value="<?php echo $projeto['valormaximo']; ?>" required  class="form-control" name="valormaximo">
					</div>
					
					<div class="form-group">
						<label for="">Valor</label>
						<input type="text" value="<?php echo $projeto['valor']; ?>" required  class="form-control" name="valorp">
					</div>

					<div class="form-group">
						<label for="">Categoria</label>
						<select name="categoria" required class="form-control">
							<option value="">...</option>
							<option <?php if($projeto['categoria'] == 'pesquisa') echo "selected"; ?> value="pesquisa">Pesquisa</option>
							<option <?php if($projeto['categoria'] == 'competicaotecnologica') echo "selected"; ?> value="competicaotecnologica">Competição Tecnológica</option>
							<option <?php if($projeto['categoria'] == 'manutencaoreforma') echo "selected"; ?> value="manutencaoreforma">Manutenção e Reformas</option>
							<option <?php if($projeto['categoria'] == 'pequenasobras') echo "selected"; ?> value="pequenasobras">Pequenas Obras</option>
						</select>
					</div>

				</div>

				<div class="col-sm-4" id="recompensas_grupo">
					
					<h4>Recompensas</h4>
					<div class="form-group">
						<button type="button" onclick="duplicate();" class="btn btn-default form-control"><i class="glyphicon glyphicon-plus"></i> Adicionar Outra</button>
					</div>

					<div id="recompensa_copy" class="form-group recompensa esconder">
						<input type="text" name="titulo[]" placeholder="Título" class="form-control"> 
						<textarea type="text" name="descricao[]" placeholder="Descrição" class="form-control"></textarea>
						<input type="text" name="valor[]" placeholder="Valor" class="form-control"> 
						<input type="text" name="limite[]" placeholder="Quantidade disponível" class="form-control"> 
						<button type="button" onclick="remover(this);" class="btn btn-danger form-control"><i class="glyphicon glyphicon-plus"></i> Remover</button>
						<hr>
					</div>

					<?php 

						foreach($recompensa as $r){


					?>
					<div  class="form-group recompensa">
						<input type="text" name="titulo[]" value="<?php echo $r['titulo']; ?>" placeholder="Título" class="form-control"> 
						<textarea type="text" name="descricao[]"  placeholder="Descrição" class="form-control"><?php echo $r['descricao']; ?></textarea>
						<input type="text" name="valor[]" value="<?php echo $r['valor']; ?>" placeholder="Valor" class="form-control"> 
						<input type="text" name="limite[]" value="<?php echo $r['limite']; ?>" placeholder="Quantidade disponível" class="form-control"> 
						<button type="button" onclick="remover(this);" class="btn btn-danger form-control"><i class="glyphicon glyphicon-plus"></i> Remover</button>
						<hr>
					</div>
					<?php } ?>

				</div>

				

			</div>
			</form>
		</div>
	</div>
</div><!--/.row-->
<script>

	function remover(e){

		$(e).parent().remove();

	}

	function duplicate(){

		$('#recompensa_copy')
			.clone()
			.appendTo('#recompensas_grupo')
			.removeClass('esconder');

	}
</script>
