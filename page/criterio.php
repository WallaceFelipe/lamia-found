<?php



if($_POST['action'] == 'edit'){

	include('../class/Conexao.class.php');
	$conexao = new Conexao();

	$id       = intval($_POST['id']);
	$criterio = $conexao->select('*')->from('criteriodeavaliacao')->where("id = '$id'")->limit(1)->executeNGet();
	die(json_encode($criterio));

}

include('class/Conexao.class.php');
$conexao = new Conexao();

if(isset($_POST['id'])){

	if(!$_POST['status']) $_POST['status'] = 0;

	$update = $conexao->update('criteriodeavaliacao', $_POST, $_POST['id'], 'id', array('id'));
	if($update)
		$msg[] = "Critério atualizado com sucesso";
	else
		$msg[] = "Falha ao atualizar critério";

}elseif(isset($_POST['categoria'])){

	$insert  = $conexao->insert('criteriodeavaliacao', $_POST);
	if($insert)
		$msg[] = "Critério adicionado corretamente";
	else
		$msg[] = "Falha ao adicionar critério.";

}

if(isset($_GET['deletar'])){

	$conexao->execute("delete from criteriodeavaliacao where id = '".intval($_GET['deletar'])."'");

}

$dados = $conexao->select('*')->from('criteriodeavaliacao')->executeNGet();

$categorias = array(
	'pesquisa'=>'Pesquisa', 
	'competicaotecnologica'=>'Competição Tecnológica', 
	'inovacaoensino'=>'Inovação no Ensino',
	'manutencaoreforma'=>'Manutenção e Reforma',
	'pequenasobras'=>'Pequenas Obras');
?>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Critérios de Avaliação</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Critérios de Avaliação</h1>
	</div>
</div><!--/.row-->


<div class="row">
	
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
					<i class="glyphigon glyphicon-plus"></i> Cadastrar
				</button>

				<?php echo ($msg)? implode('', $msg).'!':''; ?>

			</div>
			<div class="panel-body">
				<table class='table table-boredered table-hover'>
					<thead>
						<tr>
							<th>Ativado</th>
							<th>Descrição</th>
							<th>Categoria</th>
							<th>Peso</th>
							<th class="text-right">Ação</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($dados as $d){ ?>
						<tr>
							<td><?php echo ($d['status'])? 'Sim':'Não'; ?></td>
							<td><?php echo $d['descricao']; ?></td>
							<td><?php echo $categorias[$d['categoria']]; ?></td>
							<td><?php echo $d['peso']; ?></td>
							<td class="text-right">
								<button onclick="editar(<?php echo $d['id']; ?>);" class="btn btn-default btn-sm">editar</button> 
								<button onclick="javascript: location.href='index.php?p=criterio&deletar=<?php echo $d['id']; ?>';"  class="btn btn-danger btn-sm">deletar</button>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script>
	function editar(cod){

		$.post(
			'page/criterio.php',
			{id:cod, action:'edit'})
		.done(function(resposta){
			console.log(resposta);
			//{"id":"2","categoria":"inovacaoensino","descricao":"Teste","status":"1","peso":"10"}
			var dado = JSON.parse(resposta);

			$('#id').val(dado.id);
			$('#categoria option[value="'+dado.categoria+'"]').prop('selected', true);
			$('#descricao').val(dado.descricao);

			if(parseInt(dado.status) == 1) $('#status').prop('checked', true);

			$('#peso').val(dado.peso);

		});
		$('#editar').modal('show');

	}
</script>

<!-- Modal -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Critério de Avaliação</h4>
      </div>

      <form method="post" id="form" action="">

	      <div class="modal-body">
	        
				<div class="col-lg-12">

					<input type="hidden" name="id" id="id"  value="">
					
						<div class="form-group">
							<label>Categoria</label>
							<select id='categoria' required name="categoria" class="form-control">
								<!--'pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras'-->
								<option value=""></option>
								<option value="pesquisa">Pesquisa</option>
								<option value="competicaotecnologica">Competição Tecnológica</option>
								<option value="inovacaoensino">Inovação no Ensino</option>
								<option value="manutencaoreforma">Manutenção e Reforma</option>
								<option value="pequenasobras">Pequenas Obras</option>
							</select>
						</div>

						<div class="form-group">
							<label>Descrição do Critério de Avaliação</label>
							<input type="text" id='descricao' name="descricao" class="form-control">
						</div>

						<div class="form-group">
							<label>Status</label>
							<p><input type="checkbox" id="status" value="1" name="status"> Ativado</p>
						</div>

						<div class="form-group">
							<label>Peso</label>
							<input type="number" min="1" id="peso" class="form-control" max="10" range="1" name="peso" size="2">
						</div>

						<div class="clearfix"></div>
					
				</div>

				<div class="clearfix"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        <button type="submit" class="btn btn-primary">Salvar</button>
	      </div>

      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cadastrar Critério de Avaliação</h4>
      </div>

      <form method="post" id="form" action="">

	      <div class="modal-body">
	        
				<div class="col-lg-12">
					
						<div class="form-group">
							<label>Categoria</label>
							<select required name="categoria" class="form-control">
								<!--'pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras'-->
								<option value=""></option>
								<option value="pesquisa">Pesquisa</option>
								<option value="competicaotecnologica">Competição Tecnológica</option>
								<option value="inovacaoensino">Inovação no Ensino</option>
								<option value="manutencaoreforma">Manutenção e Reforma</option>
								<option value="pequenasobras">Pequenas Obras</option>
							</select>
						</div>

						<div class="form-group">
							<label>Descrição do Critério de Avaliação</label>
							<input type="text" name="descricao" class="form-control">
						</div>

						<div class="form-group">
							<label>Status</label>
							<p><input type="checkbox" value="1" checked name="status"> Ativado</p>
						</div>

						<div class="form-group">
							<label>Peso</label>
							<input type="number" min="1" class="form-control" max="10" range="1" name="peso" size="2">
						</div>

						<div class="clearfix"></div>
					
				</div>

				<div class="clearfix"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        <button type="submit" class="btn btn-primary">Salvar</button>
	      </div>

      </form>
    </div>
  </div>
</div>