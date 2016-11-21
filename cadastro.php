<?php

    include("class/Conexao.class.php");

    if (isset($_POST['enviar'])) {
        
        $dataExp = explode("/",$_POST['datanascimento']);
        $data = $dataExp[2].$dataExp[1].$dataExp[0];

        $cpf = explode(".", $_POST['cpf']);
        $cpf = implode("",$cpf);
        $cpf = explode("-",$cpf);
        $cpf = implode("",$cpf);

        $array = array(
            'login' => $_POST['login'],
            'senha' => $_POST['senha'],
            'nome' => $_POST['nome'],
            'cpf' => $cpf,
            'pais' => $_POST['pais'],
            'estado' => $_POST['estado'],
            'cidade' => $_POST['cidade'],
            'endereco' => $_POST['endereco'],
            'datanascimento' => $data,
            'email' => $_POST['email'],
            'tipo' => "usuariopublico"
        );

        $conexao = new Conexao();

        if($conexao->insert('usuario',$array)) {
            header('location: login.php?c=ok');
        } else {
            $msg = "Erro ao cadastrar";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h2>Cadastro</h2>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="post" >

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Nome Completo</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome">
                                </div>

                                <div class="col-sm-3">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" class="cpf form-control" placeholder="123.456.789-01">
                                </div>

                                <div class="col-sm-3">
                                    <label>Data de Nascimento</label>
                                    <input type="text" name="datanascimento" class="data datepicker form-control" placeholder="01/01/20016" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label>Login</label>
                                    <input type="text" name="login" class="form-control" placeholder="Login">
                                </div>
                                
                                <div class="col-sm-8">
                                    <label>E-mail</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Senha</label>
                                    <input type="password" name="senha" id="senha" oninput="valida_senha();" class="form-control" placeholder="Senha">
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group has-sucess has-feedback">
                                        <label class="control-label" for="repetir_senha">Repita a Senha</label>
                                        <input type="password" name="repetir" id="repeat_senha" oninput="valida_senha();" class="form-control" placeholder="Repita a Senha"><span id="valida" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">País</label>
                                    <input type="text" name="pais" class="form-control" placeholder="País">
                                </div>

                                <div class="col-sm-2">
                                    <label>Estado</label>
                                    <input type="text" name="estado" class="form-control" placeholder="Estado">
                                </div>
                                
                                <div class="col-sm-4">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" class="form-control" placeholder="Cidade">
                                </div>

                                <div class="col-sm-4">
                                    <label>Endereço</label>
                                    <input type="text" name="endereco" class="form-control" placeholder="Endereço (Rua Alftred Hitcock, 272)">
                                </div>
                            </div>
                            <button type="submit" name="enviar" value="true" class="btn btn-success">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->

        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/chart.min.js"></script>
        <script src="js/chart-data.js"></script>
        <script src="js/easypiechart.js"></script>
        <script src="js/easypiechart-data.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script src="js/jquery.mask.min.js"></script>
        <script>
            !function ($) {
                $(".data").mask('00/00/0000');
                $(".cpf").mask('000.000.000-00');
                $(".money").mask("#.##0,00", {reverse: true});

            }(window.jQuery);

            function valida_senha() {
                var senha = document.getElementById("senha");
                var reSenha = document.getElementById("repeat_senha");
                if ($("#senha").val() == $("#repeat_senha").val()) {
                    $("#repeat_senha").parent().removeClass("has-error");
                    $("#repeat_senha").parent().addClass("has-success");
                    $("#valida").addClass("glyphicon-ok").addClass("has-success").removeClass("glyphicon-remove");
                    
                } else {
                    $("#repeat_senha").parent().removeClass("has-success");
                    $("#repeat_senha").parent().addClass("has-error");
                    $("#valida").addClass("glyphicon-remove").addClass("has-error").removeClass("glyphicon-ok");
                }
            }
        </script>

    </body>
</html>