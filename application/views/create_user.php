		<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<?php if($is_admin): ?>
				<li><?php echo anchor('usuarios', 'Usuarios'); ?></li>
				<li class="active"><?php echo $section_actual ?></li>
				<?php else: ?>
				<li class="active"><?php echo $section_actual ?></li>
				<?php endif; ?>			  	
			</ul>

			<?php if($is_admin): ?>
			<div class="row">
				<div class="col-sm-3">					
					<h3>Usuarios</h3>
					<div class="list-group">
						<?php echo anchor('usuarios/create/true', 'Crear Usuario', array('class' => 'list-group-item '.$user_create_class)); ?>
						<?php echo anchor('#', 'Modificar Usuario', array('class' => 'list-group-item '.$user_edit_class)); ?>
						<?php echo anchor('#', 'Consultar Usuario', array('class' => 'list-group-item '.$user_query_class)); ?>
						<?php echo anchor('#', 'Eliminar Usuario', array('class' => 'list-group-item '.$user_delete_class)); ?>
					</div>					
				</div>
				<div class="col-md-9">
			<?php else: ?>
			<div class="container">
			<?php endif; ?>
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>
						
						<?php if($is_admin): ?>
						<?php echo form_open('usuarios/create/true', array('class' => 'form-signin')); ?>
						<?php else: ?>
						<?php echo form_open('usuarios/create', array('class' => 'form-signin')); ?>
						<?php endif; ?>

							<div class="form-group">
								<input class="form-control" type="text" name="nombre" value="<?php echo set_value('nombre');?>" placeholder="Nombre" autofocus>								
							</div>
							<?php echo form_error('nombre', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="telefono" value="<?php echo set_value('telefono');?>" placeholder="Telefono">
							</div>
							<?php echo form_error('telefono', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="email" name="correo" value="<?php echo set_value('correo');?>" placeholder="Correo">
							</div>
							<?php echo form_error('correo', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="text" name="login" value="<?php echo set_value('login');?>" placeholder="Login">
							</div>
							<?php echo form_error('login', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="password" name="pass" placeholder="Contraseña">
							</div>
							<?php echo form_error('pass', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="password" name="pass2" placeholder="Repetir Contraseña">
							</div>
							<?php echo form_error('pass2', '<div class="alert alert-danger">', '</div>'); ?>
							<?php if($is_admin): ?>
							<div class="form-group">
								<select class="form-control" id="select" name="perfil">
									<option value="" <?php echo set_select('perfil', '');?> ></option>
									<option value="Usuario" <?php echo set_select('perfil', 'Usuario');?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('perfil', 'Catalogador');?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('perfil', 'Administrador');?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('perfil', '<div class="alert alert-danger">', '</div>'); ?>
	        				<?php endif; ?>
	        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Crear</button>
						</form>
					</div>
				<?php if($is_admin): ?>			
				</div>
			</div>
			<?php else: ?>
			</div>
			<?php endif; ?>
		</section>