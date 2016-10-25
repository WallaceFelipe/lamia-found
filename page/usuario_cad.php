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
        'tipo' => $_POST['tipo']
    );

    $conexao = new Conexao();

    if(!empty($_POST['categoria'])) {

        if($conexao->insert('usuario',$array)) {
            
            $array = array(
                'categoria' => $_POST['categoria'],
                'idusuario' => $conexao->getCodigo()
                );

            if ($conexao->insert('avaliadordeprojetos', $array)) {
                $msg = "Cadastro realizado com sucesso.";
            } else {
                $msg = "Erro ao cadastrar";
            }

        } else {
            $msg = "Erro ao cadastrar";
        }
    } else {

        if($conexao->insert('usuario',$array)) {
            $msg = "Cadastro realizado com sucesso.";
        } else {
            $msg = "Erro ao cadastrar";
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
        <h1 class="page-header">Cadastro de Usuário</h1>
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
            <div class="panel-heading">Cadastro</div>
            <div class="panel-body">

                <form class="form-group" action='' onsubmit="enviar_formulario();" method="post">

                    <div class="form-group">
                        <label>Nome Completo</label>
                        <input type="text" name="nome" class="form-control">
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label>CPF</label>
                            <input type="text" name="cpf" class="cpf form-control">
                        </div>

                        <div class="col-sm-4">
                            <label>Data de Nascimento</label>
                            <input type="text" name="datanascimento" class="data datepicker form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control">
                        </div>
                        
                        <div class="col-sm-8">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Senha</label>
                            <input type="password" name="senha" id="senha" oninput="valida_senha();" class="form-control">
                        </div>

                        <div class="col-sm-6">
                            <label>Repita a Senha</label>
                            <input type="password" name="repetir" id="repeat_senha" oninput="valida_senha();" class="form-control"><span id="valida" class="glyphicon" aria-label="true"></span>
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label class="control-label">País</label>
                            <input type="text" name="pais" class="form-control">
                        </div>

                        <div class="col-sm-4">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control">
                        </div>
                        
                        <div class="col-sm-4">
                            <label>Cidade</label>
                            <input type="text" name="cidade" class="form-control">
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control">
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control" required oninput="analisaTipo(this.value);">
                                <option value="gestordeprojeto">Gestor de Projetos</option>
                                <option value="avaliadordeprojeto">Avaliador de Projetos</option>
                                <option value="financiadoracademico">Financiador Acadêmico</option>
                            </select>
                        </div>
                    

                        <div class="col-sm-6 hidden" id='categoria'>
                            <label>Catedoria</label>
                            <select name="categoria" class="form-control">
                                <option value="false" default>...</option>
                                <option value="pesquisa">Pesquisa</option>
                                <option value="competicaotecnologica">Competição Tecnológica</option>
                                <option value="inovacaoensino">Inovação no Ensino</option>
                                <option value="manutencaoreforma">Manutenção e Reforma</option>
                                <option value="pequenasobras">Pequenas Obras</option>
                            </select>
                        </div>
                    </div>
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
    
    function analisaTipo(valor) {
        if (valor == 'avaliadordeprojeto') {
            $('#categoria').removeClass('hidden').attr('required', true);
        } else if(!$('categoria').hasClass('hidden')) {
            $('#categoria').addClass('hidden').attr('required', false);
        }
    }

</script>	
