<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li><?php echo anchor('autores', 'Autores'); ?></li>
				<li class="active"><?php echo $section_actual ?></li>
			</ul>
			
			<div class="row">
				<div class="col-sm-3">
					<h3>Libros</h3>
					<div class="list-group">
						<?php echo anchor('libros/create', 'Crear Libro', array('class' => 'list-group-item '.$libro_create_class)); ?>
						<?php echo anchor('libros/query', 'Consultar Libro', array('class' => 'list-group-item '.$libro_query_class)); ?>						
					</div>	
					<h3>Autores</h3>
					<div class="list-group">
						<?php echo anchor('autores/create', 'Crear Autor', array('class' => 'list-group-item '.$autor_create_class, 'data-toggle' => 'modal', 'data-target'=> '#create_autor_modal')); ?>
						<?php echo anchor('autores/query', 'Modificar Autor', array('class' => 'list-group-item '.$autor_edit_class)); ?>
					</div>
					<h3>Editoriales</h3>		
					<div class="lis-group">
						<?php echo anchor('editoriales/create', 'Crear Editorial', array('class' => 'list-group-item '.$editorial_create_class, 'data-toggle' => 'modal', 'data-target'=> '#create_editorial_modal')); ?>	
						<?php echo anchor('editoriales/query', 'Modificar Editorial', array('class' => 'list-group-item '.$editorial_edit_class)); ?>
					</div>		
				</div>
				<div class="col-md-9">			
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>

						<div class="input-group">
				    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
				     		<input class="form-control col-lg-4" id="camp_query_autor" placeholder="Nombre Autor" type="text">
				     	</div> 

				     	<div id="resultados_autors" class="table-responsive paddin-topottom-sm">
				     		<h2 id="result-mensaje" class="text-center"></h2>
				     		<table class='table table-hover table-striped'>
	                           	<thead>
	                                <tr>
	                                    <th>Id</th>
	                                    <th>Nombre</th>
	                                    <th>Acción</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	<?php foreach($autores as $key => $value): ?>
										<tr>
											<td><?php echo $value['id']?></td>
											<td><?php echo $value['nombre']?></td>										
											<td><?php echo anchor('autores/update/'.$value['id'], 'Modificar', array('data-id' => $value['id'], 'data-name' => $value['nombre'])); ?></td>
										</tr><!-- , array('data-toggle' => 'modal', 'data-target'=> '#edit_autor_modal') -->
	                            	<?php endforeach; ?>
	                            </tbody>
                        	</table>
				     	</div>
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

		<div class="modal fade" id="edit_autor_modal" tabindex="-1" role="dialog" aria-labelledby="edit_autor_modalLabel" aria-hidden="true">
			<div class="modal-dialog">
		    	<div class="modal-content">
		    		<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        	<h4 class="modal-title" id="create_autor_modalLabel">Modificar Autor</h4>
			      	</div>
			      	<?php echo form_open('', array('id' => 'form_edit_autor', 'spellcheck' => 'true', 'uri_action' => base_url().'index.php/autores/update_rqst')); ?>
				      	<div class="modal-body">	      		
				      		<div class="form-group">
				      			<label for="nombre">Nombre Autor</label>
								<input class="form-control" type="text" id="input_nombre_autor" name="nombre" value="<?php echo set_value('nombre');?>" placeholder="Nombre del Autor">								
							</div>
							<div class="alert alert-danger error" id="err_name_autor">					
								<?php echo validation_errors(); ?>
							</div>
							<div class="alert alert-success success" id="ok_name_autor"></div>
						</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				        	<input type="submit" id="btn_edit_autor" class="btn btn-primary" role="button" value="Modificar">	        	
				      	</div>
			      	</form>			      	
				</div>
		  	</div>
		</div>