<?php
	include("class/Projeto.class.php");
	$results=NULL;
	$myProjeto = new Projeto();
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		switch ($_POST['acao']) {
			case 'Consultar':
				if($_POST['codigo']!=''){
					$results= $myProjeto->sql_read($_POST['codigo'],'','');
				}
				else if($_POST['nome']!=''){
					$results= $myProjeto->sql_read('',$_POST['nome'],'');
				}
				else if($_POST['categoria']!=''){
					$results= $myProjeto->sql_read('','',$_POST['categoria']);	
				}
				else $results =	$myProjeto->sql_read('','','');
				break;
			case 'alterar':
				$myProjeto->sql_update($_POST['codigo'],
									   $_POST['nome'],
									   $_POST['categoria'],
									   $_POST['duracaoprevista'],
									   $_POST['valor']);
				break;
			case 'deletar':
			default:
					$myProjeto->sql_delete($_POST['codigo']);
				break;
		}
		
	}	
?>

<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Cadastro de Usuário</li>
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
					<div class="panel-heading">Cadastrar Projeto</div>
					<div class="panel-body">

                   	 	<form class="form-group" action="index.php?p=projeto_consulta" onsubmit="" method="post">
						<table class='table table-boredered <table-hover></table-hover>'>
							<thead>
								<tr>
									<td>Codigo</td>
									<td>Nome</td>
									<td>Categoria</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" name="codigo"></td>
									<td><input type="text" name="nome"></td>
									<td>
										<select name="categoria"  class="form-control">
		                                <option value='' default>...</option>
		                                <option value="pesquisa">Pesquisa</option>
		                                <option value="competicaotecnologica">Competição Tecnológica</option>
		                                <option value="inovacaoensino">Inovação no Ensino</option>
		                                <option value="manutencaoreforma">Manutenção e Reforma</option>
		                                <option value="pequenasobras">Pequenas Obras</option>
		                            	</select>
		                            </td>
								</tr>
								<tr>
									<td><input name="acao" type="submit" value="Consultar"></td>
								</tr>
							</tbody>
                         </table>                            
                    </form>
                    <table class='table table-boredered <table-hover></table-hover>'>
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>Categoria</td>
                        </tr>
                    </thead>
                    <tbody >
                    <?php if(isset($results))foreach ($results as $result) { ?>
                        
                        <tr>
                            <td><a href="#" onclick='editar(<?php echo json_encode($result);?>);'><?php echo $result['nome'] ?></a></td>
                            <td><?php echo $result['categoria'] ?></td>
                            <td class="text-right">
                                <button onclick='deletar(<?php echo json_encode($result);?>)'  id="remover_<?php echo $result['codigo']; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                    </div>
				</div>
			</div>
		</div><!--/.row-->
<!--Modal Consulta-->
<div class='modal fade' id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Usuário</h4>
            </div>
             <form class="form-group" id="consulta_modal" action='' onsubmit="" method="post">
                <div class="modal-body">
                
                    <input type="text" name="id" class="hidden">

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" >
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label>Codigo</label>
                            <input type="text" name="codigo" class="form-control" readonly>
                        </div>

                        <div class="col-sm-4">
                            <label>Categoria</label>
                            <select id="modalCategoria"  class="datepicker form-control">
		                                <option id="OPpesquisa" value="pesquisa">Pesquisa</option>
		                                <option id="OPcompeticaotecnologica" value="competicaotecnologica">Competição Tecnológica</option>
		                                <option id="OPinovacaoensino"  value="inovacaoensino">Inovação no Ensino</option>
		                                <option id="OPmanutencaoreforma" value="manutencaoreforma">Manutenção e Reforma</option>
		                                <option id="OPpequenasobras" value="pequenasobras">Pequenas Obras</option>
		                            	</select>

                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>status</label>
                            <input type="text" name="status" class="form-control" readonly>
                        </div>

                        <div class="col-sm-8">
                            <label>Duração prevista</label>
                            <input type="text" name="duracaoprevista" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label class="control-label">Prazo máximo</label>
                            <input type="text" name="pais" class="form-control" readonly>
                        </div>

                        <div class="col-sm-4">
                        <label>Valor Mínimo</label>
                        <input type="text" name="estado" class="form-control" readonly>
                        </div>
                    
                        <div class="col-sm-4">
                        <label>Valor máximo</label>
                        <input type="text" name="cidade" class="form-control" readonly>
                        </div>
                    </div>       
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="acao" value="alterar" class="btn btn-success" onclick="enviar();">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--MODAL DELETE-->
<div class='modal fade' id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Usuário</h4>
            </div>
             <form class="form-group" id="deleta_modal" action='' onsubmit="" method="post">
                <div class="modal-body">
                
                    <input type="text" name="id" class="hidden">

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" >
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label>Codigo</label>
                            <input type="text" name="codigo" class="form-control" readonly>
                        </div>

                      
                    </div>

                
                    </div>

     
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="acao" value="deletar" class="btn btn-danger" onclick="enviar();">Deletar</button>
                </div>
            </form>
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
        $("#modalCategoria").find("option#OP"+vetor.categoria).attr("selected",true);

        $("#myModal").modal("show");
    }

    function deletar(vetor) {
    	var index;
        var container = document.getElementById('deleta_modal');
        var inputs = container.getElementsByTagName('input');
        for (index = 0; index < inputs.length; ++index) {
            inputs[index].value = vetor[inputs[index].name];
        }
        $("#delModal").modal("show");
    }
    function enviar(){};
</script>