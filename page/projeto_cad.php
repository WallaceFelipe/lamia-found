<?php


$categoria=$valor=$duracaoprevista=$nome=$codigo= '';
$categoriaErr=$valorErr=$duracaoprevistaErr=$nomeErr=$codigoErr = '';
$form_valid = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $a=$b=$c=$d=$e = false;
  
  $a=validar_campo('codigo',$codigo,$codigoErr,'/^[a-zA-Z0-9]*$/'); 
  $b=validar_campo('nome',$nome,$nomeErr,'/^[a-z A-Z]*$/');
  $c=validar_campo('duracaoprevista',$duracaoprevista,$duracaoprevistaErr,'/^[0-9]*$/');
  $d=validar_campo('valor',$valor,$valorErr,'/^[0-9]*$/');   
  $categoria = $_POST['categoria'];
  if($_POST['categoria']!=='false')$e=true;	

  $form_valid = ($e and $b and $c and $d and $a);

}  
  	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
	function validar_campo($campo,&$var_campo,&$var_error,$exp_regular){
		if (empty($_POST[$campo])){
  		$var_error = '* '.$campo.' precisa sem preenchido';
  		return false;
  		}else {
			$var_campo = test_input($_POST[$campo]);  
			if(!preg_match($exp_regular,$var_campo)){
				$var_error = 'Valores inválidos para o campo';
				return false;	
			}
  		}
  		return true;
	}

?>

<?php if($form_valid===false) {?>
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

                    <form class="form-group" action="" onsubmit="" method="post">
									 <input type="hidden" value="projeto_cad" name="p">
                        	
                            <label>Código <?php echo $codigoErr; ?></label>
                            <input type="text" name="codigo" class="form-control" value="<?php echo $codigo; ?>" maxlength="6" size="6" required > 
                       
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
        <?php } else{ ?>
        
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
						  <h3>Confirmar cadastro?</h3>
						  <p>Nome: <?php echo $nome; ?> </p>
                    <p>Codigo: <?php echo $codigo; ?> </p>
                    <p>Categoria: <?php echo $categoria; ?> </p>
                    <p>Valor: <?php echo $valor; ?> </p> 
                    <p>Duração Prevista <?php echo $duracaoprevista;?>dias</p>						  					  
						  <form class="form-group" action="class/Projetos.class.php" onsubmit="" method="post">
							  <input type="hidden" name="operation" value="create">						 	  
						 	  <input type="hidden" name="nome" value="<?php echo $nome; ?>">
							  <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
 							  <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
							  <input type="hidden" name="valor" value="<?php echo $valor; ?>">
							  <input type="hidden" name="duracaoprevista" value="<?php echo $duracaoprevista; ?>">
							  <input type="submit" value="confirma">                    
                    </form>
                    </div>
				</div>
			</div>
		</div><!--/.row-->
<?php }?>
