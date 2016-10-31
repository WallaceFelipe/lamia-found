<?php

if($_POST['action'] == 'edit'){

	include('../class/Conexao.class.php');
	$conexao = new Conexao();

	$id       = intval($_POST['id']);
	$repassef = $conexao->select('*')->from('repassefinanceiro')->where("id = '$id'")->limit(1)->executeNGet();
	$repassef['data'] = date('d/m/Y', strtotime($repassef['data']));

	die(json_encode($repassef));

}

include('class/Conexao.class.php');
$conexao = new Conexao();

if(isset($_POST['id'])){ // edição de dados

	$_POST['valor'] = floatval(str_replace(',', '.', $_POST['valor']));
	$tmp = explode('/', $_POST['data']);
	$_POST['data'] = "$tmp[2]-$tmp[1]-$tmp[0]";

	$update = $conexao->update('repassefinanceiro', $_POST, $_POST['id'], 'id', array('id'));
	if($update)
		$msg[] = "Repasse atualizado com sucesso";
	else
		$msg[] = "Falha ao atualizar repasse";

}elseif(isset($_POST['idprojeto'])){

	// cadastro  dados

	$tmp = explode('/', $_POST['data']);
	$_POST['data'] = "$tmp[2]-$tmp[1]-$tmp[0]";
	$_POST['valor'] = floatval(str_replace(',', '.', $_POST['valor']));

	$insert  = $conexao->insert('repassefinanceiro', $_POST);
	if($insert)
		$msg[] = "Repasse adicionado corretamente";
	else
		$msg[] = "Falha ao adicionar repasse.";

}

if(isset($_GET['deletar'])){

	$conexao->execute("delete from repassefinanceiro where id = '".intval($_GET['deletar'])."'");

}

$dados = $conexao->select('p.nome, r.id, r.idprojeto, r.data, r.valor, r.status')->from('repassefinanceiro r, projeto p')->where("p.id = r.idprojeto")->executeNGet();
$projeto = $conexao->select('id, nome')->from('projeto')->executeNGet();

?>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Repasses Financeiros</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Repasses Financeiros</h1>
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
							<th>Projeto</th>
							<th>Data</th>
							<th>Valor</th>
							<th>Status</th>
							<th class="text-right">Ação</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($dados as $d){ ?>
						<tr>
							<td><?php echo $d['nome']; ?></td>
							<td><?php echo date('d/m/Y', strtotime($d['data'])); ?></td>
							<td><?php echo number_format($d['valor'], 2, ',', '.'); ?></td>
							<td><?php if($d['status'] == 'quitado') echo 'Quitado'; else echo 'Não Quitado'; ?></td>
							<td class="text-right">
								<button onclick="editar(<?php echo $d['id']; ?>);" class="btn btn-default btn-sm">editar</button> 
								<button onclick="javascript: location.href='index.php?p=repassefinanceiro&deletar=<?php echo $d['id']; ?>';"  class="btn btn-danger btn-sm">deletar</button>
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
			'page/repassefinanceiro.php',
			{id:cod, action:'edit'})
		.done(function(resposta){
			console.log(resposta);
			//{"id":"1","idprojeto":"1","data":"0000-00-00","valor":"4500","status":"quitado"}
			var dado = JSON.parse(resposta);

			$('#id').val(dado.id);
			$('#idprojeto option[value="'+dado.idprojeto+'"]').prop('selected', true);
			$('#data').val(dado.data);
			$('#valor').val(dado.valor);
			$('#status option[value="'+dado.status+'"]').prop('selected', true);



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
							<label>Projeto</label>
							<select required id="idprojeto" name="idprojeto" class="form-control">
								<!--'pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras'-->
								<option value=""></option>
								<?php foreach($projeto as $p){ ?>
								<option value="<?php echo $p['id']; ?>"><?php echo $p['nome']; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Data</label>
							<input type="text" id="data" name="data" required placeholder="30/12/2016, por exemplo" class="form-control">
						</div>

						<div class="form-group">
							<label>Valor</label>
							<input type="text" id="valor" name="valor" required class="form-control">
						</div>

						<div class="form-group">
							<label>Status</label>
							<select name="status" id="status" required class="form-control">
								<option value=""></option>
								<option value="quitado">Quitado</option>
								<option value="naoquitado">Não Quitado</option>
							</select>
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
        <h4 class="modal-title">Cadastrar Repasse Financeiro</h4>
      </div>

      <form method="post" id="form" action="">

	      <div class="modal-body">
	        
				<div class="col-lg-12">
					
						<div class="form-group">
							<label>Projeto</label>
							<select required name="idprojeto" class="form-control">
								<!--'pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras'-->
								<option value=""></option>
								<?php foreach($projeto as $p){ ?>
								<option value="<?php echo $p['id']; ?>"><?php echo $p['nome']; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Data</label>
							<input type="text" name="data" required placeholder="30/12/2016, por exemplo" class="form-control">
						</div>

						<div class="form-group">
							<label>Valor</label>
							<input type="text" name="valor" required class="form-control">
						</div>

						<div class="form-group">
							<label>Status</label>
							<select name="status" required class="form-control">
								<option value=""></option>
								<option value="quitado">Quitado</option>
								<option value="naoquitado">Não Quitado</option>
							</select>
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