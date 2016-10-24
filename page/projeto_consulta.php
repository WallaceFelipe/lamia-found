<?php
	include("class/Projeto.class.php");
	$results=NULL;
	$myProjeto = new Projeto();
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['codigo'])){
			$results= $myProjeto->sql_read($_POST['codigo'],'','');
		}
		else if(isset($_POST['nome'])){
			$results= $myProjeto->sql_read('',$_POST['nome'],'');
		}
		else if(isset($_POST['categoria'])){
			$results= $myProjeto->sql_read('','',$_POST['categoria']);	
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

                        	<label>Codigo</label><input type="text" name="codigo">
							<label>Nome</label><input type="text" name="nome">
							<label>Categoria</label><select name="categoria"  class="form-control"> 
                                <option value='' default>...</option>
                                <option value="pesquisa">Pesquisa</option>
                                <option value="competicaotecnologica">Competição Tecnológica</option>
                                <option value="inovacaoensino">Inovação no Ensino</option>
                                <option value="manutencaoreforma">Manutenção e Reforma</option>
                                <option value="pequenasobras">Pequenas Obras</option>
                            </select>
                            <input type="submit" value="Consultar">                            
                    </form>
                    <table class='table table-boredered <table-hover></table-hover>'>
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>Categoria</td>
                        </tr>
                    </thead>
                    <tbody >
                    <?php foreach ($results as $result) { ?>
                        
                        <tr>
                            <td><a href="#" onclick='editar(<?php echo json_encode($result);?>);'><?php echo $result['nome'] ?></a></td>
                            <td><?php echo $result['categoria'] ?></td>
                            <td class="text-right">
                                <button onclick="" id="remover_<?php echo $result['codigo']; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                    </div>
				</div>
			</div>
		</div><!--/.row-->
