<?php


if($_POST['action'] == 'getCriterio'){
    include('../class/Conexao.class.php');
    $conexao = new Conexao();
    $sql = "SELECT itemavaliacao.*, criteriodeavaliacao.descricao, criteriodeavaliacao.categoria FROM `itemavaliacao` join criteriodeavaliacao on itemavaliacao.idCriterio = criteriodeavaliacao.id where itemavaliacao.idAvaliacao =".$_POST['idAvaliacao'];
    $tmp = $conexao->execute($sql);
    
    while($dado = $tmp->fetch_assoc()){
        $criterios[] = $dado;
    }

    $avaliador = $conexao->select("*")->from('usuario')->where("id = ".$_POST['avaliador'])->executeNGet();

    $dados = array ('avaliador' => $avaliador, 'criterios'=> $criterios);

    die(json_encode($dados));
}

include("class/Conexao.class.php");
$conexao = new Conexao();
$sql = "SELECT projeto.*, avaliacao.id as idAvaliacao, avaliacao.codAvaliador, avaliacao.data, avaliacao.nota, avaliacao.sugestao FROM `projeto` JOIN `avaliacao` ON projeto.id = avaliacao.codProjeto";
$projetos = $conexao->execute($sql);
?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Consulta de Projetos Avaliados</li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Projetos</h1>
    
        <?php if (count($msg) > 0) { ?>
        <div class="alert alert-success  alert-dismissible animated fadeIn" role="alert">
            <?php echo "<h3>$msg</h3>"; ?>
        </div>
        <?php } ?>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <small>Buscar</small>
            </div>
            <div class="pane-body">
                
                <form action='index.php?p=usuario_consulta' method='post' class='form-inline'>
                    <div class="form-group  col-lg-10 col-lg-offset-1">
                        <input type="text" name="nome" value="" class='form-control' placeholder="Nome">
                        <input type="text" name="login" value="" class='form-control' placeholder="Login">

                        <button type="submit" name="acao" value="pesquisar" class="btn btn-success" onclick="enviar();">Pesquisar</button>
                    </div>
                </form>

                <br>
                <br>

                <table class='table table-boredered <table-hover></table-hover>'>
                    <thead>
                        <tr>
                            <td>Status</td>
                            <td>Código</td>
                            <td>Nome</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projetos as $value) { ?>
                        
                        <tr>
                            <td><?php echo $value['status'] ?></td>
                            <td><?php echo $value['codigo'] ?></td>
                            <td><?php echo $value['nome'] ?></td>
                            <td class="text-right">
                                <button onclick='consulta(<?php echo json_encode($value); ?>);' class="btn btn-success btn-sm">Avaliação</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Modal Consulta-->
<div class='modal fade' id="consultaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Usuário</h4>
            </div>
            <div class="modal-body">
                <div>
                    <h4>Dados do Avaliador:</h4>
                    <div class="form-group col-sm-2">
                        <label for="">Código:</label>
                        <input type="text" id="codAvaliador" class="form-control" value="" readonly>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="">Avaliador:</label>
                        <input type="text" id="nomeAvaliador" class="form-control" value="" readonly>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="">Data:</label>
                        <input type="text" class="form-control" id="dataAvaliacao" value="" readonly>
                    </div>
                </div>

                <div>
                    <h4>Dados do Projeto:</h4>
                    <div class="form-group col-sm-4">
                        <label for="">Projeto:</label>
                        <input type="text" id="codProjeto" class="form-control" value="" readonly>
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
                            
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <label for="">Sugestões de Melhoria</label>
                    <textarea rows="3" class="form-control" id="sugestao" readonly></textarea>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function editar(vetor) {
        var index;
        var container = document.getElementById('consulta_modal');
        var inputs = container.getElementsByTagName('input');
        for (index = 0; index < inputs.length; ++index) {
            inputs[index].value = vetor[inputs[index].name];
        }

        $("#myModal").modal("show")
    }

    function enviar() {
        return true;
    }

    function consulta(dados) {
        
        $.post(
			'page/projeto_avaliado.php',
			{avaliador:dados['codAvaliador'], idAvaliacao:dados['idAvaliacao'], action:'getCriterio'})
		.done(function(resposta){
			console.log(resposta);
			//{"id":"2","categoria":"inovacaoensino","descricao":"Teste","status":"1","peso":"10"}
			var dado = JSON.parse(resposta);
            var criterio = dado['criterios'];
            console.log(criterio);
            $('#nomeAvaliador').val(dado['avaliador'][0]['nome']);

            //Inserir os criterios no modal

            })
			

		});

        $('#codAvaliador').val(dados['codAvaliador']);
        $('#codProjeto').val(dados['codigo']);
        $('#dataAvaliacao').val(dados['data']);
        $('#nome').val(dados['nome']);
        $('#duracao').val(dados['duracaoprevista']);
        $('#valor').val(dados['valor']);
        if (dados['sugestao'] == null) {
            $('#sugestao').val('Não foi registrado nenhuma sugestão');
        } else {
            $('#sugestao').val(dados['sugestao']);
        }
        $("#consultaModal").modal("show");
    }

    function remover(id) {
        $("#id_user").val(id);
        $("#modalConfirma").modal("show");
    }
</script>