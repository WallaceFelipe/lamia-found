<?php


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

                   	 	<form class="form-group" action="class/Projetos.class.php" onsubmit="" method="post">
							<input type="hidden" name="operation" value="read">	
                        	<label>Codigo</label><input type="text" name="codigo">
							<label>Nome</label><input type="text" name="nome">
							<label>Categoria</label><select name="categoria"  class="form-control"> 
                                <option value="false" default>...</option>
                                <option value="pesquisa">Pesquisa</option>
                                <option value="competicaotecnologica">Competição Tecnológica</option>
                                <option value="inovacaoensino">Inovação no Ensino</option>
                                <option value="manutencaoreforma">Manutenção e Reforma</option>
                                <option value="pequenasobras">Pequenas Obras</option>
                            </select>                            
                    </form>

                    </div>
				</div>
			</div>
		</div><!--/.row-->
