<?php

include("class/Conexao.class.php");

if (isset($_POST['enviar'])) {
    $array = array(
        'login' => $_POST['login'],
        'senha' => $_POST['senha'],
        'nome' => $_POST['nome'],
        'cpf' => $_POST['cpf'],
        'pais' => $_POST['pais'],
        'estado' => $_POST['estado'],
        'cidade' => $_POST['cidade'],
        'endereco' => $_POST['endereco'],
        'datanascimento' => $_POST['datanascimento'],
        'email' => $_POST['email'],
        'tipo' => $_POST['tipo']
    );

    $conexao = new Conexao();
    if($conexao->insert('usuario',$array)) {
        $msg = "Cadastro realizado com sucesso!";
    } else {
        $msg = "Erro ao cadastrar";
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

            <?php if (count($msg) > 0) { ?>
            <div class="alert alert-success  alert-dismissible animated fadeIn" role="alert">
                <?php echo "<p>$msg</p>"; ?>
            </div>
            <?php } ?>
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
<<<<<<< HEAD
                            <input type="password" name="confirma" class="form-control">
                        </div>
=======
>>>>>>> 81fbfd4dfabe47519365d729a2f29a5cd4fbfaf5


                            <label>Nome Completo</label>
                            <input type="text" name="nome" class="form-control">
                  
                            <label>CPF</label>
                            <input type="text" name="cpf" class="form-control">
                     
                            <label>País</label>
                            <input type="text" name="pais" class="form-control">
                       
                            <label>Estado</label>
<<<<<<< HEAD
                            <input type="text" name="estado" class="form-control">
                        </div>

                        <div class="form-group">
=======
                            <input type="text" name="Estado" class="form-control">
                        
>>>>>>> 81fbfd4dfabe47519365d729a2f29a5cd4fbfaf5
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
