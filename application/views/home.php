		<header>
			<div class="container-fluid">
				<h1 class="text-center">Bienvenido a BiblioCristian</h1>
				<p class="small text-center">Creado por Cristian Cuspoca</p>
			</div>			
		</header>
		
		<section class="container-fluid paddin-topottom-md">
			<ul class="breadcrumb">
			  	<li class="active"><?php echo $section_actual ?></li>
			</ul>
			<h1 class="text-center">B&uacute;squeda</h1>										
			
			<div class="input-group">
	    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
	     		<input class="form-control input-lg" id="camp_query_docs" placeholder="Titulo/Autor/Editorial" type="text">
	     		<span class="input-group-btn">
		      		<button class="btn btn-default input-lg" id="btn_query_docs" type="button">Buscar</button>
		    	</span>
	     	</div>	     	
	     	<div id="resultados_docs" class="table-responsive paddin-topottom-sm">
	     		<h2 id="result-mensaje" class="text-center"></h2>
	     		<table class='table table-hover table-striped'>
	     		</table>
			</div>

			

		</section>	