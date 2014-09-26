<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li><?php echo anchor('libros', 'Libros'); ?></li>
				<li><?php echo anchor('libros/query', 'Consulta'); ?></li>
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

						<?php if( ! empty($mensaje_ok) && $mensaje_ok === 'OK'): ?>
							<div class="alert alert-success alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Ok!! </strong>Documento modificado exitosamente
							</div>
						<?php elseif($mensaje_ok === 'ERROR'): ?>
							<div class="alert alert-danger alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Error!! </strong>Intentelo de Nuevo
							</div>
						<?php endif; ?>
						
						<?php echo form_open_multipart('libros/update/'.$section_actual, array('class' => 'form-signin', 'spellcheck' => 'true')); ?>						

							<div class="form-group">
								<input class="form-control" type="text" name="titulo_p" value="<?php echo set_value('titulo_p', $documento['titulo_p']);?>" placeholder="Título Principal" autofocus>								
							</div>
							<?php echo form_error('titulo_p', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="titulo_s" value="<?php echo set_value('titulo_s', $documento['titulo_s']);?>" placeholder="Título Secundario">								
							</div>
							<?php echo form_error('titulo_s', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_autor" name="autor[]" multiple="">									
									<?php foreach($autores as $value) : ?>
										<?php 
											$selected = FALSE;
											if(in_array($value['nombre'], $autors_doc))
											{
												$selected = TRUE;
											}
										?>
										<option value="<?php echo $value['id'];?>" <?php echo set_select('autor[]', $value['id'], $selected);?> ><?php echo $value['nombre'];?></option>									
									<?php endforeach; ?>
	        					</select>
	        					<span class="help-block">
	        						Elige el autor del documento, puedes elegir varios o seleccionar Anonimo, si no encuentras
	        						el autor buscado crealo <?php echo anchor('autores/create', 'Aquí', array('data-toggle' => 'modal', 'data-target'=> '#create_autor_modal')); ?>.
	        					</span>
	        				</div>
	        				<?php echo form_error('autor[]', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">								
								<select class="form-control" id="selct_editorial" name="editorial">								
									<?php foreach ($editoriales as $value) : ?>
										<?php $selected = ($value['nombre'] === $documento['nombre']) ? TRUE : ''; ?>
										<option value="<?php echo $value['id'];?>" <?php echo set_select('editorial', $value['id'], $selected);?> ><?php echo $value['nombre'];?></option>
									<?php endforeach; ?>
	        					</select>
	        					<span class="help-block">
	        						Elige el editorial del documento, si no tiene selecciona 'No Aplica', si no encuentras la
	        						editorial buscada creala <?php echo anchor('editoriales/create', 'Aquí', array('data-toggle' => 'modal', 'data-target'=> '#create_editorial_modal')); ?>.
	        					</span>
	        				</div>
								
							<div class="form-group">
								<?php echo form_dropdown('idioma', $idiomas, $documento['idioma'], 'class="form-control" id="selct_idioma"'); ?>
	        					<span class="help-block">
	        						Elige el idioma principal del documento.
	        					</span>
	        				</div>
	        				<?php echo form_error('idioma', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<textarea class="form-control" rows="5" id="descripcion" name="descripcion" placeholder="Breve descripción"><?php echo set_value('descripcion', $documento['descripcion']);?></textarea>								
							</div>
							<?php echo form_error('descripcion', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<?php echo form_dropdown('tipo', $tipos, $documento['tipo'], 'class="form-control" id="selct_formato"'); ?>
								<span class="help-block">
	        						Elige el Tipo del documento.
	        					</span>
	        				</div>
	        				<?php echo form_error('tipo', '<div class="alert alert-danger">', '</div>'); ?>

	        				<div class="form-group">
	        					<input type="text" name="wrap_keys" id="wrap_keys" placeholder="clave1, clave2, clave3" value="<?php echo set_value('wrap_keys', $documento['palabras_clave']) ?>" class="form-control">
	        					<span class="help-block">
	        						Digita palabras claves alucivas al documento, ingresalas separadas por comas(,)
	        					</span>
	        				</div>
	        				<?php echo form_error('wrap_keys', '<div class="alert alert-danger">', '</div>'); ?>
							
							<div class="form-group">
								<input class="form-control" type="file" name="userfile" placeholder="Archivo" value="<?php echo set_value('userfile') ?>">
								<span class="help-block">
	        						Elige el archivo a subir.
	        					</span>
							</div>
							<?php echo form_error('userfile', '<div class="alert alert-danger">', '</div>'); ?>
							<?php echo $error_file ?>
	        				
	        				<input class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar" value="Modificar"> 
						</form>
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