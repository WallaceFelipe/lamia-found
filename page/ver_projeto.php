<?php
    $conexao = new Conexao();
    if (!isset($_GET['id'])) {
        header('location: index_public.php');
        exit();
    }

    $projeto = $conexao->select('*')->from('projeto')->where("id = '".$_GET['id']."'")->executeNGet();
    $recompensas = $conexao->select('*')->from('recompensa')->where("idprojeto = '".$_GET['id']."'")->executeNGet();
    $projeto = $projeto[0]; 
    $coordenador = $conexao->select('nome')->from('usuario')->where("id = '".$projeto['coordenador']."'")->executeNGet();
?>

<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Perfil</li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">            

            <div class="panel-heading">
            <!-- Nav tabs -->
                <ul class="nav nav-tabs " role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Financiar</a></li>
                    
                </ul>

            </div>

            <div class="panel-body">
                
                <div>        
                    <div class="form-group col-sm-4">
						<label for="">Projeto:</label>
						<input type="text" id="projeto" class="form-control" value="<?php echo $projeto['codigo']; ?>" readonly>
					</div>

					<div class="form-group col-sm-8">
						<label for="">Nome:</label>
						<input type="text" class="form-control" id="nome" value="<?php echo $projeto['nome']; ?>" readonly>
					</div>

                    <div class="form-group col-sm-4">
						<label for="">Coordenador:</label>
						<input type="text" class="form-control" id="nome" value="<?php echo $coordenador[0]['nome']; ?>" readonly>
					</div>

					<div class="form-group col-sm-4">
						<label for="">Duração Prevista:</label>
						<input type="text" class="form-control" id="duracao" value="<?php echo $projeto['duracaoprevista']; ?>" readonly>
					</div>

					<div class="form-group col-sm-4">
						<label for="">Valor:</label>
						<input type="text" class="form-control" id="valor" value="<?php echo $projeto['valor']; ?>" readonly>
					</div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="home">
                        <table class='table table-boredered <table-hover></table-hover>'>
                            <thead>
                                <tr>
                                    <td>Recompensa</td>
                                    <td>Descrição</td>
                                    <td>Valor da Recompensa (R$)</td>
                                    <td>Limite</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($recompensas as $recompensa) { ?>
                                <tr>
                                    <td><?php echo $recompensa['titulo']; ?></td>
                                    <td><?php echo $recompensa['descricao']; ?></td>
                                    <td><?php echo $recompensa['valor']; ?></td>
                                    <td><?php echo $recompensa['limite']; ?></td>
                                    <td><button type="button" class="btn btn-info">Pegar</button></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="profile">
                        <form>
                            <div class="form-control">

                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>