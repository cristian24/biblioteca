		<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
			  	<li class="active"><?php echo $section_actual ?></li>			  				
			 	<!-- <li><a href="#">Library</a></li> -->
			</ul>		
			<div class="row">
				<div class="col-sm-3">
					<h3>Libros</h3>
					<div class="list-group">
						<?php echo anchor('libros/create', 'Crear Libro', array('class' => 'list-group-item')); ?>
						<?php echo anchor('libros/query', 'Consultar Libro', array('class' => 'list-group-item')); ?>						
					</div>	
					<h3>Autores</h3>
					<div class="list-group">
						<?php echo anchor('autores/create', 'Crear Autor', array('class' => 'list-group-item', 'data-toggle' => 'modal', 'data-target'=> '#create_autor_modal')); ?>
						<?php echo anchor('autores/query', 'Modificar Autor', array('class' => 'list-group-item')); ?>
					</div>
					<h3>Editoriales</h3>
					<div class="lis-group">
						<?php echo anchor('editoriales/create', 'Crear Editorial', array('class' => 'list-group-item', 'data-toggle' => 'modal', 'data-target'=> '#create_editorial_modal')); ?>	
						<?php echo anchor('editoriales/query', 'Modificar Editorial', array('class' => 'list-group-item')); ?>
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

		<div class="modal fade" id="create_autor_modal" tabindex="-1" role="dialog" aria-labelledby="create_autor_modalLabel" aria-hidden="true">
			<div class="modal-dialog">
		    	<div class="modal-content">			      	
		    	</div>
		  	</div>
		</div>

		<div class="modal fade" id="create_editorial_modal" tabindex="-1" role="dialog" aria-labelledby="create_editorial_modalLabel" aria-hidden="true">
			<div class="modal-dialog">
		    	<div class="modal-content">			      	
		    	</div>
		  	</div>
		</div>