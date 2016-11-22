<?php
    $conexao = new Conexao();
    
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] == false) {
        session_start();
        $_SESSION['idfinanciado'] = $_GET["id"];
        header('location: login.php?lf='.$_GET["id"]);
    } elseif (isset($_SESSION['idfinanciador'])) {
        $_SESSION['idfinanciado'] = null;
    }

    $recompensa = $conexao->select("*")->from("recompensa")->where("id = ".$_GET['id'])->limit(1)->executeNGet();
    $projeto = $conexao->select("*")->from("projeto")->where("id = ".$recompensa['idprojeto'])->limit(1)->executeNGet();

    if (isset($_POST['financiar'])) {
        $financiar = array(
            'idusuario' => $user->getId(),
            'idprojeto' => $recompensa['idprojeto'],
            'tipo' => 'integral',
            'valor' => $recompensa['valor'],
            'formapagamento' => 'cartaocredito'
        );
        
        $recompensar = array(
            'financiador' => $user->getId(),
            'idrecompensa' => $recompensa['id']
        );

        if($conexao->insert('financiar', $financiar)) {
            if($conexao->insert('usuariorecompensa', $recompensar)) {
                echo '<script> alert("Financiamento realizado com sucesso");
                        window.location.href = "index_public.php";
                    </script>';
                die();
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Financiamento</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <h4>Você irá financiar o seguinte projeto:</h4>
                            <p><b>Projeto:</b> <?php echo $projeto['nome'];?></p>
                            <p><b>Objetivo:</b> R$ <span class="money"><?php echo $projeto['valor'];?><span></p>
                            <p><b>Valor Indicado:</b> R$ <span class="money"><?php echo $recompensa['valor'];?></span></p>
                        </div>
                        </br>
                        <div class="row">
                            <h4>Recompensa: <b><?php echo $recompensa['titulo'];?></b></h4>
                            <p><?php echo $recompensa['descricao'];?></p>
                        </div>
                        <br>
                        <div class="row">
                            <form method="post" id="form" action="">
                                <div class="form-group col-sm-3">
                                    <label>Número do Cartão</label>
                                    <input type="text" name="cartao" class="card form-control" value="" placeholder="1234.1234.1234.1234">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>CVV</label>
                                    <input type="text" name="cvv" class="cvv form-control" value="" placeholder="123">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Data de Vencimento</label>
                                    <input type="text" name="data" class="dataC form-control" value="" placeholder="01/2020">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label></label>
                                    <button type="submit" name="financiar" class="btn btn-success form-control" value="ok" >Financiar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
