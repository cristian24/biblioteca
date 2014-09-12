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
						<?php echo anchor('libros/query/update', 'Modificar Libro', array('class' => 'list-group-item '.$libro_edit_class)); ?>
						<?php echo anchor('libros/query/delete', 'Eliminar Libro', array('class' => 'list-group-item '.$libro_delete_class)); ?>					
					</div>	
					<h3>Autores</h3>
					<div class="list-group">
						<?php echo anchor('autores/create', 'Crear Autor', array('class' => 'list-group-item '.$autor_create_class, 'data-toggle' => 'modal', 'data-target'=> '#create_autor_modal')); ?>
						<?php echo anchor('#', 'Modificar Autor', array('class' => 'list-group-item '.$autor_edit_class)); ?>
						<?php echo anchor('#', 'Consultar Autor', array('class' => 'list-group-item '.$autor_delete_class)); ?>
					</div>
					<h3>Editoriales</h3>		
					<div class="lis-group">
						<?php echo anchor('editoriales/create', 'Crear Editorial', array('class' => 'list-group-item '.$editorial_create_class, 'data-toggle' => 'modal', 'data-target'=> '#create_editorial_modal')); ?>	
						<?php echo anchor('#', 'Modificar Editorial', array('class' => 'list-group-item '.$editorial_create_class)); ?>
						<?php echo anchor('#', 'Consultar Editorial', array('class' => 'list-group-item')); ?>
					</div>		
				</div>
				<div class="col-md-9">			
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>						
						
						<?php echo form_open_multipart('libros/create', array('class' => 'form-signin', 'spellcheck' => 'true')); ?>						

							<div class="form-group">								
								<input class="form-control" type="text" name="titulo_p" value="<?php echo set_value('titulo_p');?>" placeholder="Título Principal" autofocus>								
							</div>
							<?php echo form_error('titulo_p', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="titulo_s" value="<?php echo set_value('titulo_s');?>" placeholder="Título Secundario">								
							</div>
							<?php echo form_error('titulo_s', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_autor" name="autor[]" multiple="">
									<?php foreach ($autores as $value) : ?>
										<option value="<?php echo $value['id'];?>" <?php echo set_select('autor[]', $value['id']);?> ><?php echo $value['nombre'];?></option>
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
										<option value="<?php echo $value['id'];?>" <?php echo set_select('editorial', $value['id']);?> ><?php echo $value['nombre'];?></option>
									<?php endforeach; ?>					          	
	        					</select>
	        					<span class="help-block">
	        						Elige el editorial del documento, si no tiene selecciona 'No Aplica', si no encuentras la
	        						editorial buscada creala <?php echo anchor('editoriales/create', 'Aquí', array('data-toggle' => 'modal', 'data-target'=> '#create_editorial_modal')); ?>.
	        					</span>
	        				</div>

							<div class="form-group">
								<select class="form-control" id="selct_idioma" name="idioma">
									<option value="" <?php echo set_select('idioma', '');?> >--Elige--</option>
									<option value="Inglés" <?php echo set_select('idioma', 'Inglés');?> >Inglés</option>
						          	<option value="Español" <?php echo set_select('idioma', 'Español');?> >Español</option>
						          	<option value="Francés" <?php echo set_select('idioma', 'Francés');?> >Francés</option>
						          	<option value="Alemán" <?php echo set_select('idioma', 'Alemán');?> >Alemán</option>
						          	<option value="Portugués" <?php echo set_select('idioma', 'Portugués');?> >Portugués</option>
	        					</select>
	        					<span class="help-block">
	        						Elige el idioma principal del documento.
	        					</span>
	        				</div>
	        				<?php echo form_error('idioma', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<textarea class="form-control" rows="5" id="descripcion" name="descripcion" placeholder="Breve descripción"><?php echo set_value('descripcion');?></textarea>								
							</div>
							<?php echo form_error('descripcion', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_formato" name="tipo">
									<option value="" <?php echo set_select('tipo', '');?> >--Elige--</option>
									<option value="Revista" <?php echo set_select('tipo', 'Revista');?> >Revista</option>
						          	<option value="Notas" <?php echo set_select('tipo', 'Notas');?> >Notas</option>
						          	<option value="Libro" <?php echo set_select('tipo', 'Libro');?> >Libro</option>
						          	<option value="Escrito/Resumen" <?php echo set_select('tipo', 'Escrito/Resumen');?> >Escrito/Resumen</option>
						          	<option value="Diagrama" <?php echo set_select('tipo', 'Diagrama');?> >Diagrama</option>	
						          	<option value="Otros" <?php echo set_select('tipo', 'Otros');?> >Otros</option>					          	
	        					</select>
	        					<span class="help-block">
	        						Elige el Tipo del documento.
	        					</span>
	        				</div>
	        				<?php echo form_error('tipo', '<div class="alert alert-danger">', '</div>'); ?>

	        				<div class="form-group">
	        					<input type="text" name="wrap_keys" id="wrap_keys" placeholder="clave1, clave2, clave3" value="<?php echo set_value('wrap_keys') ?>" class="form-control">
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
	        				
	        				<input class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar" value="Crear"> 
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