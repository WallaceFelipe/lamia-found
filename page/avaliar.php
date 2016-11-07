<?php

include('class/Conexao.class.php');
$conexao = new Conexao();


if ($_POST['acao'] == 'avaliar') {
	$criterios = explode(";", $_POST['listaCriterios']);
	
	$dataExp = explode("/",$_POST['data']);
	$data = $dataExp[2].$dataExp[1].$dataExp[0];
	
	if (floatval($_POST['nota']) > 6) {
		$status = "aprovado";
	} else {
		$status = "reprovado";
	}

	$array = array(
		'codProjeto' => $_POST['codProjeto'],
		'codAvaliador' => $_POST['codAvaliador'],
		'nota' => $_POST['nota'],
		'data' => $data
	);
	if (!empty($_POST['sugestao'])) {
		$array['sugestao'] = $_POST['sugestao'];
	}
	
	if ($conexao->insert('avaliacao', $array)) {
		$idAvaliacao = $conexao->getCodigo();
		$array = array ('status' => $status);
		if($conexao->update('projeto',$array, $_POST['codProjeto'], 'id')) {
			foreach ($criterios as $criterio) {
				if ($criterio != "") {
					$array = array (
						'idAvaliacao' => $idAvaliacao,
						'idCriterio' => $criterio,
						'nota' => $_POST[$criterio],
						'peso' => $_POST['peso_'.$criterio]
					);
					if ($conexao->insert('itemavaliacao', $array)) {
						echo "<script>alert('ok');</script>";
					}
				}
			}
		}
	}


}



switch ($user->categoria) {
	case 'pesquisa':
		$msg = "Pesquisa";
		break;
	case 'inovacaoensino':
		$msg = "Inovação em Ensino";
		break;
	case 'competicaotecnologica':
		$msg = "Competição Tecnológica";
		break;
	case 'manutencaoreforma':
		$msg = "Manutenção e Reforma";
		break;
	case 'pequenasobras':
		$msg = "Pequenas Obras";
		break;
	default:
		$msg = "Você não é um Avaliador";
		break;
}

$criterios = $conexao->select('*')->from('criteriodeavaliacao')->where("status = 1 and categoria = '$user->categoria'")->executeNGet();

if (count($criterios) == 0) {
	echo "<script>alert('Não há critério de avaliação para a sua categoria. Por favor, cadastre ao menos um critério.');
			window.location.href = 'index.php?p=criterio'</script>";
}
$dados = $conexao->select('*')->from('projeto')->where("status ='candidato' and categoria = '$user->categoria'")->executeNGet();

?>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Avaliação de Projetos</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Avaliação de Projetos</h1>
	</div>
</div><!--/.row-->


<div class="row">
	
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<!-- Button trigger modal -->
				<h2>Categoria: <?php echo $msg; ?></h2>
			</div>
			<div class="panel-body">
				<table class='table table-boredered table-hover'>
					<thead>
						<tr>
							<th>Status</th>
							<th>Código</th>
							<th>Nome</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; foreach($dados as $d){ ?>
						<tr>
							<td><?php echo $d['status']; ?></td>
							<td><?php echo $d['codigo']; ?></td>
							<td><?php echo $d['nome']; ?></td>
							<td class="text-right">
								<button id='ln_<?php echo $index; ?>' onclick="avaliacao(<?php echo $d['id'].",'".$d['codigo']."','".$d['nome']."',".$d['duracaoprevista'].",".$d['valor']; ?>);" class="btn btn-primary btn-sm">avaliar</button> 
							</td>
						</tr>
						<?php $index++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script>
	function avaliacao(id, cod, nome, duracao, valor){

		/*$.post(
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

		});*/

		$('#codProjeto').val(id);
		$('#projeto').val(cod);
		$('#nome').val(nome);
		$('#duracao').val(duracao);
		$('#valor').val(valor);

		$('#avaliar').modal('show');
	
	}

	function calcNota() {
		var soma = 0;
		var peso = 0;
		
		$.each($('#criterios input'), function(i, ele) {
			if($(ele).attr('id') != 'nota') {
				var notaParcial = $(ele).val() * $(ele).attr('id'); 
				soma += notaParcial;
				peso += parseInt($(ele).attr('id'));
			}
		});
		var notafinal = soma/peso; 
		$('#nota').val(notafinal.toFixed(2));

	}


</script>

<!-- Modal -->
<div class="modal fade" id="avaliar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Avaliação</h4>
      </div>

      <form method="post" id="form" action="">

	      <div class="modal-body">
	        
					<div class="col-lg-12">

						<input type="hidden" name="acao"  value="avaliar">
						<input type="hidden" name="codProjeto" id="codProjeto" value="">
						
						<div>
							<h4>Dados do Avaliador:</h4>
							<div class="form-group col-sm-2">
								<label for="">Código:</label>
								<input type="text" id="codigo" name="codAvaliador" class="form-control" value="<?php echo $user->getId(); ?>" readonly>
							</div>

							<div class="form-group col-sm-6">
                <label for="">Avaliador:</label>
                <input type="text" class="form-control" value="<?php echo $user->nome;?>" readonly>
							</div>

              <div class="form-group col-sm-4">
                <label for="">Data:</label>
                <input type="text" class="form-control" name="data" value="<?php echo date('d/m/Y'); ?>" readonly>
              </div>
						</div>
						</hr>
						<div>
							<h4>Dados do Projeto:</h4>
							<div class="form-group col-sm-4">
								<label for="">Projeto:</label>
								<input type="text" id="projeto" class="form-control" value="" readonly>
							</div>

							<div class="form-group col-sm-8">
                <label for="">Nome:</label>
                <input type="text" class="form-control" id="nome" value="" readonly>
							</div>

              <div class="form-group col-sm-4">
                <label for="">Duração Prevista:</label>
                <input type="text" class="form-control" id="duracao" value="" readonly>
              </div>

			<div class="form-group col-sm-8">
                <label for="">Valor:</label>
                <input type="text" class="form-control" id="valor" value="" readonly>
              </div>
						</div>

							<div class="form-group">
								<table class="table table-condensed table-hover">
									<thead>
										<tr>
											<th class="col-sm-8">Critério:</th>
											<th>Nota:</th>
										</tr>
									</thead>
									<tbody id="criterios">
										<?php foreach($criterios as $c) {
											$listCriterio .= $c['id'].";"; 
											?>
											<tr>
												<td><?php echo $c['descricao']; ?></td>
												<td><input type="text" class="form-control" id="<?php echo $c['peso'];?>" name="<?php echo $c['id']; ?>" value="" onkeyup="calcNota();"></td>
												<input type="text" class="hidden" name="peso_<?php echo $c['id']; ?>" value="<?php echo $c['peso'];?>">
											</tr>
										<?php } ?>
											<tr class="active">
												<td>Nota Final</td>
												<td><input type="text" id="nota" name="nota" value="" readonly></td>
											</tr>
									</tbody>
								</table>
								<input type="text" class="hidden" value="<?php echo $listCriterio; ?>" name='listaCriterios'>
							</div>

							<div class="form-group">
								<label for="">Sugestões de Melhoria</label>
								<textarea rows="3" class="form-control" name="sugestao"></textarea>
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