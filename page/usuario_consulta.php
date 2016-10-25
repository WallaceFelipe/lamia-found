<?php
include("class/Conexao.class.php");

$conexao = new Conexao();

if (!isset($_POST['acao'])) {
    
    $usuarios = $conexao->select('*')->from('usuario')->where('ativo = 1')->orderby('nome')->executeNGet();
} else {
    if ($_POST['acao'] == 'alterar') {
            $array = array(
            'login' => $_POST['login'],
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

        if($conexao->update('usuario',$array, $_POST['id'], 'id')) {
            $msg = "Cadastro realizado com sucesso!";
        } else {
            $msg = "Erro ao cadastrar";
        }

    } elseif ($_POST['acao'] == 'pesquisar') {
        
        $nome = $conexao->escape($_POST['nome']);
        $login = $conexao->escape($_POST['login']);

        if (empty($nome) && empty($login)) {
            $usuarios = $conexao->select('*')->from('usuario')->where('ativo = 1')->orderby('nome')->executeNGet();
        } else {

            if(!empty($nome) && !empty($login))
                $usuarios = $conexao->select('*')->from('usuario')->where("ativo = 1 and nome  like '%$nome%' or login like '%$login%'")->orderby('nome')->executeNGet();
            
            elseif(!empty($nome))
                $usuarios = $conexao->select('*')->from('usuario')->where("ativo = 1 and nome  like '%$nome%'")->orderby('nome')->executeNGet();

            elseif(!empty($login))
                $usuarios = $conexao->select('*')->from('usuario')->where("ativo = 1 and login  like '%$login%'")->orderby('nome')->executeNGet();

        }
    } elseif ($_POST['acao'] == 'excluir') {
        $query = "SELECT * FROM financiar JOIN projeto ON financiar.idprojeto = projeto.id WHERE financiar.idusuario = ".$_POST['id_user']." AND projeto.status = 'aprovado'";
        $retorno = $conexao->execute($query);
        if(empty($retorno)) {
            $msg = "Usuário está financiando um projeto aprovado e que não está finalizado. Desativação impedida até que essa pendência seja resolvida";
        } else {
            $array = array('ativo' => 0);

            if($conexao->update('usuario',$array, $_POST['id_user'], 'id')) {
                $msg = "Desativação realizado com sucesso!";
            } else {
                $msg = "Erro ao desativar";
            }
        }
    }
}


?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Consulta de Usuários</li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Usuários</h1>
    
        <?php if (count($msg) > 0) { ?>
        <div class="alert alert-success  alert-dismissible animated fadeIn" role="alert">
            <?php echo "<h3>$msg</h3>"; ?>
        </div>
        <?php } ?>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <small>Buscar</small>
            </div>
            <div class="pane-body">
                
                <form action='index.php?p=usuario_consulta' method='post' class='form-inline'>
                    <div class="form-group  col-lg-10 col-lg-offset-1">
                        <input type="text" name="nome" value="" class='form-control' placeholder="Nome">
                        <input type="text" name="login" value="" class='form-control' placeholder="Login">

                        <button type="submit" name="acao" value="pesquisar" class="btn btn-success" onclick="enviar();">Pesquisar</button>
                    </div>
                </form>

                <br>
                <br>

                <table class='table table-boredered <table-hover></table-hover>'>
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>Login</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($usuarios as $value) { ?>
                        
                        <tr>
                            <td><a href="#" onclick='editar(<?php echo json_encode($value);?>);'><?php echo $value['nome'] ?></a></td>
                            <td><?php echo $value['login'] ?></td>
                            <td class="text-right">
                                <button onclick="remover(<?php echo $value['id']; ?>);" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Modal Consulta-->
<div class='modal fade' id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Usuário</h4>
            </div>
             <form class="form-group" id="consulta_modal" action='' onsubmit="" method="post">
                <div class="modal-body">
                
                    <input type="text" name="id" class="hidden">

                    <div class="form-group">
                        <label>Nome Completo</label>
                        <input type="text" name="nome" class="form-control" readonly>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label>CPF</label>
                            <input type="text" name="cpf" class="cpf form-control" readonly>
                        </div>

                        <div class="col-sm-4">
                            <label>Data de Nascimento</label>
                            <input type="text" name="datanascimento" class="data datepicker form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control">
                        </div>

                        <div class="col-sm-8">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control">
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
                            <input type="text" name="tipo" class="form-control" readonly>
                        </div>

                        <div class="col-sm-6 hidden">
                            <label>Categoria</label>
                            <input type="text" name="categoria" class="form-control" readonly>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="acao" value="alterar" class="btn btn-success" onclick="enviar();">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--Modal Confirmação-->
<div class='modal fade' id="modalConfirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmação</h4>
            </div>
            <form onsubmit="enviar();" method='post'>
                <div class="modal-body">
                    <p>Deseja realmente deletar o usuário?</p>
                    <input type="text" name="id_user" id="id_user" class="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="acao" value="excluir" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function editar(vetor) {
        var index;
        var container = document.getElementById('consulta_modal');
        var inputs = container.getElementsByTagName('input');
        for (index = 0; index < inputs.length; ++index) {
            inputs[index].value = vetor[inputs[index].name];
        }

        $("#myModal").modal("show")
    }

    function enviar() {
        return true;
    }

    function remover(id) {
        $("#id_user").val(id);
        $("#modalConfirma").modal("show");
    }
</script>