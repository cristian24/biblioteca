<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li><?php echo anchor('libros', 'Libros'); ?></li>
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
				     		<input class="form-control col-lg-4" id="camp_query_doc" placeholder="Titulo/Autor/editorial" type="text">
				     	</div> 

				     	<div id="resultados_docs" class="table-responsive paddin-topottom-sm">
				     		<h2 id="result-mensaje" class="text-center"></h2>
				     		<table class='table table-hover table-striped'>
	                           	<thead>
	                                <tr>
	                                    <th>Id</th>
	                                    <th>Titulo P</th>
	                                   	<th>Titulo S</th>
	                                   	<th>Autor/es</th>
	                                    <th>Idioma</th>
	                                    <th>Descripción</th>
	                                    <th>Editorial</th>
	                                    <th>Accion</th>
	                                    <th>Accion</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	<?php foreach($libros as $key => $value): ?>
										<tr>
											<td><?php echo $value['id']?></td>
											<td><?php echo $value['titulo_p']?></td>
											<td><?php echo $value['titulo_s']?></td>
											<td>
												<?php 
													$nombres_autores = $value[0];
													$list = "";
													foreach($nombres_autores as $llave => $valor)
													{
														$list = $list." <span>-".$valor['nombre']."</span>";
													}
													echo $list;
												?>
											</td>
											<td><?php echo $value['idioma']?></td>
											<td><?php echo $value['descripcion']?></td>
											<td><?php echo $value['nombre']?></td>
											<td><?php echo anchor('libros/update/'.$value['id'], 'Modificar'); ?></td>
											<td><?php echo anchor('#', 'Eliminar', array('id' => 'eliminar_documento', 'uri' => base_url().'index.php/libros/delete/'.$value['id'])); ?></td>
										</tr>
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