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
						<?php echo anchor('libros/create', 'Crear Libro', array('class' => 'list-group-item')); ?>
						<?php echo anchor('libros/update', 'Modificar Libro', array('class' => 'list-group-item')); ?>
						<?php echo anchor('libros/delete', 'Eliminar Libro', array('class' => 'list-group-item')); ?>					
					</div>	
					<h3>Autores</h3>
					<div class="list-group">
						<?php echo anchor('#', 'Crear Autor', array('class' => 'list-group-item')); ?>
						<?php echo anchor('#', 'Modificar Autor', array('class' => 'list-group-item')); ?>
						<?php echo anchor('#', 'Eliminar Autor', array('class' => 'list-group-item')); ?>
					</div>
					<h3>Editoriales</h3>		
					<div class="lis-group">
						<?php echo anchor('#', 'Crear Editorial', array('class' => 'list-group-item')); ?>
						<?php echo anchor('#', 'Modificar Editorial', array('class' => 'list-group-item')); ?>
						<?php echo anchor('#', 'Eliminar Editorial', array('class' => 'list-group-item')); ?>						
					</div>		
				</div>
				<div class="col-md-9">			
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>						
						
						<?php echo form_open('libros/create', array('class' => 'form-signin')); ?>						

							<div class="form-group">
								<input class="form-control" type="text" name="titulo_P" value="<?php echo set_value('titulo_P');?>" placeholder="Título Principal" autofocus>								
							</div>
							<?php echo form_error('titulo_P', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="titulo_s" value="<?php echo set_value('titulo_s');?>" placeholder="Título Secundario">
							</div>
							<?php echo form_error('titulo_s', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_autor" name="autor" placeholder="Autor">
									<option value="" <?php echo set_select('autor', '');?> ></option>
									<option value="Usuario" <?php echo set_select('autor', 'Usuario');?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('autor', 'Catalogador');?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('autor', 'Administrador');?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('autor', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_editorial" name="editorial">
									<option value="" <?php echo set_select('editorial', '');?> ></option>
									<option value="Usuario" <?php echo set_select('editorial', 'Usuario');?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('editorial', 'Catalogador');?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('editorial', 'Administrador');?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('editorial', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_idioma" name="idioma">
									<option value="" <?php echo set_select('idioma', '');?> ></option>
									<option value="Usuario" <?php echo set_select('idioma', 'Usuario');?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('idioma', 'Catalogador');?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('idioma', 'Administrador');?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('idioma', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<textarea class="form-control" name="descripcion" rows="3"></textarea>
							</div>
							<?php echo form_error('descripcion', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<select class="form-control" id="selct_formato" name="formato">
									<option value="" <?php echo set_select('formato', '');?> ></option>
									<option value="Usuario" <?php echo set_select('formato', 'Usuario');?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('formato', 'Catalogador');?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('formato', 'Administrador');?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('formato', '<div class="alert alert-danger">', '</div>'); ?>
							
							<div class="form-group">
								<input class="form-control" type="file" name="archivo" placeholder="Archivo">
							</div>
							<?php echo form_error('archivo', '<div class="alert alert-danger">', '</div>'); ?>
	        				
	        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Crear</button>
						</form>
					</div>						
				</div>
			</div>			
		</section>