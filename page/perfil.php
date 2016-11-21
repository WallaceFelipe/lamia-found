<div class="row">
    <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Perfil</li>
    </ol>
</div><!--/.row-->




<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div>
                <div class="panel-heading">
                <!-- Nav tabs -->
                    <ul class="nav nav-tabs " role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                        
                    </ul>

                </div>

                <div class="panel-body">
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="home">
                            <form class="form-group" action='' onsubmit="enviar_formulario();" method="post">

                                <div class="form-group">
                                    <label>Nome Completo</label>
                                    <input type="text" name="nome" class="form-control" value="<?php echo $user->nome;?>" readonly>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label>CPF</label>
                                        <input type="text" name="cpf" class="cpf form-control" value ="<?php echo $user->getCpf();?>" readonly>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Data de Nascimento</label>
                                        <input type="text" name="datanascimento" class="data datepicker form-control" value="<?php echo $user->getData();?>" readonly>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>E-mail</label>
                                        <input type="text" name="email" class="form-control" value="<?php echo $user->email;?>" readonly>
                                    </div>
                                </div>
                                
                                <!-- Endereço -->
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class="control-label">País</label>
                                        <input type="text" name="pais" class="form-control" value="<?php echo $user->pais;?>" readonly>
                                    </div>

                                    <div class="col-sm-2">
                                        <label>Estado</label>
                                        <input type="text" name="estado" class="form-control" value="<?php echo $user->estado;?>" readonly>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <label>Cidade</label>
                                        <input type="text" name="cidade" class="form-control" value="<?php echo $user->cidade;?>" readonly>
                                    </div>
                                    
                                    <div class="col-sm-5">
                                        <label>Endereço</label>
                                        <input type="text" name="endereco" class="form-control" value="<?php echo $user->endereco;?>" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="profile">
                            Profile conteudo
                        </div>
                        
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>