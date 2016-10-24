<?php

require_once("class/Projeto.class.php");
$codigoErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["codigo"])) {
    $codigoErr = "Name is required";
  } else {
    $codigo = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z 0-9 ]*$/",$codigo)) {
      $codigoErr = "Digite letras e números para esse campo";
    }
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
					<div class="panel-heading">Nome da tabela</div>
					<div class="panel-body">

                    <form class="form-group" action="projeto_cad.php" onsubmit="" method="post">

                        
                            <label>Código</label>
                            <input type="text" name="codigo" class="form-control" value="<?php echo $codigoErr; ?>" required>
                       
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        
                            <label>Duracao Prevista (dias)</label>
                            <input type="number" name="duracaoprevista" class="form-control" required>
                        
                            <label>Valor</label>
                            <input type="number" name="valor" class="form-control" required>
                        
                            <label>Categoria</label>
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