<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
			  	<li class="active"><?php echo $section_actual ?></li>
			</ul>

			<div class="container">
				<div class="well">  				
	  				<h1 class="text-center">
						<?php echo $title_section; ?><br>
						<small><?php echo $subtitle_section; ?></small>
					</h1>
	  				<p>Para acceder a esta seccion inicia sesion 
	  				<?php echo anchor('usuarios/login', 'Aqui', array('class' => 'alert-link')); ?>,
	  				si ya iniciaste sesion, es posible que no poseas los privilegios necesarios, para acceder a esta area,
	  				si eres administrador y aun así no puedes acceder, reporta el error cuanto antes.</p>  
				</div>												
			</div>
		</section>