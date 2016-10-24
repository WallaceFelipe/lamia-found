<?php

require_once("class/Projeto.class.php");
$categoria=$valor=$duracaoprevista=$nome=$codigo= '';
$categoriaErr=$valorErr=$duracaoprevistaErr=$nomeErr=$codigoErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["codigo"])) {
    $codigoErr = '*campo Codigo precisa sem preenchido';
  } else {
    $codigo = test_input($_POST['codigo']);
    if (!preg_match('/^[a-zA-Z0-9]*$/',$codigo)) {
      $codigoErr = "Digite letras e números para esse campo";
    }  
  }
	
  if (empty($_POST['nome'])){
  	$nomeErr = '*campo Nome precisa sem preenchido';
  }else {
	$nome = test_input($_POST['nome']);  
	if(!preg_match('/^[a-zA-Z]*$/',$nome)){
		$nomeErr = 'Digite letras para esse campo';	
	}
  }
  
  if (empty($_POST['duracaoprevista'])){
  	$duracaoprevistaErr = '*campo Duração Prevista precisa sem preenchido';
  }else {
	$duracaoprevista = test_input($_POST['duracaoprevista']);  
	if(!preg_match('/^[0-9]*$/',$duracaoprevista)){
		$duracaoprevistaErr = 'Digite números para esse campo';	
	}
  }
  
  if (empty($_POST['valor'])){
  	$valorErr = '*campo Valor precisa sem preenchido';
  }else {
	$valor = test_input($_POST['valor']);  
	if(!preg_match('/^[0-9]*$/',$valor)){
		$valorErr = 'Digite números para esse campo';	
	}
  }
    
}  
  	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
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

                    <form class="form-group" action="index.php" onsubmit="" method="post">
									 <input type="hidden" value="projeto_cad" name="p">
                        	
                            <label>Código <?php echo $codigoErr; ?></label>
                            <input type="text" name="codigo" class="form-control" value="<?php echo $codigo; ?>" required> 
                       
                            <label>Nome <?php echo $nomeErr; ?></label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" required> 
                        
                            <label>Duracao Prevista (dias) <?php echo $duracaoprevistaErr; ?></label>
                            <input type="number" name="duracaoprevista" class="form-control" value="<?php echo $duracaoprevista; ?>" required> 
                        
                            <label>Valor <?php echo $valorErr; ?></label>
                            <input type="number" name="valor" class="form-control" value="<?php echo $valor; ?>" required> 
                        
                            <label>Categoria <?php echo $categoriaErr; ?></label>
                            <select name="categoria"  value="<?php echo $categoria; ?>" class="form-control"> 
                                <option value="false" default>...</option>
                                <option value="pesquisa">Pesquisa</option>
                                <option value="competicaotecnologica">Competição Tecnológica</option>
                                <option value="inovacaoensino">Inovação no Ensino</option>
                                <option value="manutencaoreforma">Manutenção e Reforma</option>
                                <option value="pequenasobras">Pequenas Obras</option>
                            </select>
                        
                        <button type="submit" name="enviar" value="true" class="btn btn-success">Cadastrar</button>
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