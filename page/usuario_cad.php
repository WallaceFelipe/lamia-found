<?php

include("class/Conexao.class.php");

if (isset($_POST['cadastrar'])) {



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
					<div class="panel-heading">Nome da tabela</div>
					<div class="panel-body">

                    <form class="form-group" action='' onsubmit="" method="post">

                            <label>Login</label>
                            <input type="text" name="login" class="form-control">


                            <label>Senha</label>


    
                            <label>Repita a Senha</label>


                            <label>Nome Completo</label>
                            <input type="text" name="nome" class="form-control">
                  
                            <label>CPF</label>
                            <input type="text" name="cpf" class="form-control">
                     
                            <label>País</label>
                            <input type="text" name="pais" class="form-control">
                       
                            <label>Estado</label>
                            <input type="text" name="Estado" class="form-control">
                        
                            <label>Cidade</label>
                            <input type="text" name="cidade" class="form-control">
                      
                            <label>Endereço</label>
                            <input type="text" name="endereco" class="form-control">
                       
                            <label>Data de Nascimento</label>
                            <input type="text" name="datanascimento" class="datepicker form-control">
                     
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control">
                       
                            <label>Tipo</label>
                            <select name="tipo" class="form-control">
                                <option value="gestordeprojeto">Gestor de Projetos</option>
                                <option value="avaliadordeprojeto">Avaliador de Projetos</option>
                                <option value="financiadoracademico">Financiador Acadêmico</option>
                            </select>
                        
                            <label>Catedoria</label>
                            <select name="categoria" class="form-control">
                                <option value="false" default>...</option>
                                <option value="pesquisa">Pesquisa</option>
                                <option value="competicaotecnologica">Competição Tecnológica</option>
                                <option value="inovacaoensino">Inovação no Ensino</option>
                                <option value="manutencaoreforma">Manutenção e Reforma</option>
                                <option value="pequenasobras">Pequenas Obras</option>
                            </select>
                        
                        <button type="submit" name="enviar" value="true" onclick="enviar_formulario()" class="btn btn-success">Cadastrar</button>
                    </form>

                    </div>
				</div>
			</div>
		</div><!--/.row-->

        <script>
            function enviar_formulario() {
                //Validações pré envio

                return true;

            }
        </script>	
