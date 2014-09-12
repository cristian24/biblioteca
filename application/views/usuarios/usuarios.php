		<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
			  	<li class="active"><?php echo $section_actual ?></li>			  				
			 	<!-- <li><a href="#">Library</a></li> -->
			</ul>		
			<div class="row">
				<div class="col-sm-3">	
					<h3>Usuarios</h3>
					<div class="list-group">
						<?php echo anchor('usuarios/create/true', 'Crear Usuario', array('class' => 'list-group-item')); ?>
						<?php echo anchor('usuarios/query/update', 'Modificar Usuario', array('class' => 'list-group-item')); ?>						
						<?php echo anchor('usuarios/query/delete', 'Eliminar Usuario', array('class' => 'list-group-item')); ?>
					</div>		
				</div>
				<div class="col-md-9">
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>
						<?php echo $mensaje_ok; ?>
						<?php echo $mensaje_err; ?>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>
					</div>					
				</div>
			</div>
		</section>