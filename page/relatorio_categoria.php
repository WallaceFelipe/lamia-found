<?php

include('class/Conexao.class.php');
$conexao = new Conexao();
$linhas   = $conexao
				->select('p.categoria as cat,  sum(f.valor) as soma')
				->from('projeto p, financiar f')
				->where('f.idprojeto = p.id')
				->groupby('cat')
				->executeNGet();

$cont = array();
$cont['pesquisa'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'pesquisa')")
					->executeNGet('valor');

$cont['competicaotecnologica'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'competicaotecnologica')")
					->executeNGet('valor');

$cont['inovacaoensino'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'inovacaoensino')")
					->executeNGet('valor');

$cont['manutencaoreforma'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'manutencaoreforma')")
					->executeNGet('valor');

$cont['pequenasobras'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'pequenasobras')")
					->executeNGet('valor');

if($_POST['datai'] && $_POST['dataf']){

	$tmp = explode('/', $_POST['datai']);
	$datai = "$tmp[2]-$tmp[1]-$tmp[0]";

	$tmp = explode('/', $_POST['dataf']);
	$dataf = "$tmp[2]-$tmp[1]-$tmp[0]";

	$linhas   = $conexao
				->select('p.categoria as cat,  sum(f.valor) as soma')
				->from('projeto p, financiar f')
				->where("f.idprojeto = p.id and p.prazomaximo >= '$datai' and p.prazomaximo <= '$dataf'")
				->groupby('cat')
				->executeNGet();

$cont = array();
$cont['pesquisa'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'pesquisa' and (prazomaximo is null or (prazomaximo >= '$datai' and prazomaximo <= '$dataf')))")
					->executeNGet('valor');

$cont['competicaotecnologica'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'competicaotecnologica' and (prazomaximo is null or (prazomaximo >= '$datai' and prazomaximo <= '$dataf')))")
					->executeNGet('valor');

$cont['inovacaoensino'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'inovacaoensino' and (prazomaximo is null or (prazomaximo >= '$datai' and prazomaximo <= '$dataf')))")
					->executeNGet('valor');

$cont['manutencaoreforma'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'manutencaoreforma' and (prazomaximo is null or (prazomaximo >= '$datai' and prazomaximo <= '$dataf')))")
					->executeNGet('valor');

$cont['pequenasobras'] = $conexao
					->select('sum(f.valor) as valor')
					->from('financiar f')
					->where(" f.idprojeto in (select id from projeto where categoria = 'pequenasobras' and (prazomaximo is null or (prazomaximo >= '$datai' and prazomaximo <= '$dataf')))")
					->executeNGet('valor');

}
?>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Relatório dos Projetos por Categoria</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Relatório dos Projetos por Categoria</h1>
	</div>
</div><!--/.row-->


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Dados</div>
			<div class="panel-body">

				<div class="col-sm-12 form-group text-center">
					<form action="" method="post" class="form-inline">
						<label for="">Filtrar</label>
						<input required class="form-control data" value="<?php echo $_POST['datai']; ?>" placeholder="Data Inicial" name="datai" type="text">
						<input required class="form-control data" value="<?php echo $_POST['dataf']; ?>" placeholder="Data Final" name="dataf" type="text">
						<button type="submit" class="btn btn-primary">Consultar</button>
					</form>
				</div>
				<div class="col-sm-4">	
					<table class='table table-boredered table-hover'>
						<thead>
							<tr>
								<th data-field="state" data-checkbox="true" >Categoria</th>
								<th data-field="id" data-sortable="true">R$ investidos</th>
							
							</tr>
						</thead>
						<tbody>
							<?php foreach($linhas as $l){ ?>
							<tr>
								<td><?php echo $l['cat']; ?></td>
								<td><?php echo 'R$ '.number_format($l['soma'], 2, ',', '.'); ?></td>
								
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-8">
					<canvas id="secondaryChart"></canvas>
				</div>
				
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script src="https://github.com/chartjs/Chart.js/releases/download/v2.3.0/Chart.bundle.min.js"></script>
<script>
	//Pega o elemento para desenhar o gráfico
       var second = document.getElementById("secondaryChart");
       
       //Desenha de acordo com a fatia clicada

       var alpha = {
        labels: ["Pesquisa", "Competição Tecnológica", "Inovação e Ensino", "Manutençãoe e Reforma", "Pequenas Obras"],
        datasets : [
            {
                label: "Alpha",
                backgroundColor: "#B22200",
                data: [<?php echo floatval($cont['pesquisa']); ?>, <?php echo floatval($cont['competicaotecnologica']); ?>, <?php echo floatval($cont['inovacaoensino']); ?>, <?php echo floatval($cont['manutencaoreforma']); ?>, <?php echo floatval($cont['pequenasobras']); ?>],
            }
        ]
    }


           var barChart = new Chart(second, {
               type: "bar",
               data: alpha
           });
</script>

