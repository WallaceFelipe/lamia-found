<?php
	include("Projeto.class.php");

	$myProjeto = new Projeto();
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		switch($_POST['operation']){
			case 'create' :
				$nome = $_POST['nome'];
				$codigo = $_POST['codigo'];
				$categoria = $_POST['categoria'];
				$valor = $_POST['valor'];
				$duracaoprevista = $_POST['duracaoprevista'];
				$myProjeto->sql_create($codigo,$nome,$categoria,$duracaoprevista,$valor);

				echo "<script> location.href = '../index.php?p=projeto_cad'; </script>";
				break;
			default:
		}		
	}
	
