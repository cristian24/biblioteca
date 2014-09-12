<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li><?php echo anchor('usuarios', 'Usuarios'); ?></li>
				<li><?php echo anchor('usuarios/query/update', 'Modificar Usuario');?></li>
				<li class="active"><?php echo $section_actual ?></li>		  	
			</ul>

			<div class="row">
				<div class="col-sm-3">					
					<h3>Usuarios</h3>
					<div class="list-group">
						<?php echo anchor('usuarios/create/true', 'Crear Usuario', array('class' => 'list-group-item '.$user_create_class)); ?>
						<?php echo anchor('usuarios/query/update', 'Modificar Usuario', array('class' => 'list-group-item '.$user_edit_class)); ?>						
						<?php echo anchor('usuarios/query/delete', 'Eliminar Usuario', array('class' => 'list-group-item '.$user_delete_class)); ?>
					</div>					
				</div>
				<div class="col-md-9">
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>
						
						<?php if($mensaje_ok): ?>
							<div class="alert alert-success alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Ok!! </strong>Usuario modificado exitosamente
							</div>
						<?php endif; ?>

						<?php echo form_open('usuarios/update/'.$section_actual, array('class' => 'form-signin')); ?>					

							<div class="form-group">
								<input class="form-control" type="text" name="nombre" value="<?php echo set_value('nombre', $usuario['nombre']);?>" placeholder="Nombre" autofocus>								
							</div>
							<?php echo form_error('nombre', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="telefono" value="<?php echo set_value('telefono', $usuario['telefono']);?>" placeholder="Telefono">
							</div>
							<?php echo form_error('telefono', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="email" name="correo" value="<?php echo set_value('correo', $usuario['correo']);?>" placeholder="Correo">
							</div>
							<?php echo form_error('correo', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="text" name="login" value="<?php echo set_value('login', $usuario['login']);?>" placeholder="Login">
							</div>
							<?php echo form_error('login', '<div class="alert alert-danger">', '</div>'); ?>
							
							<div class="form-group">
								<select class="form-control" id="select" name="perfil">
									<option value="" <?php echo set_select('perfil', '');?> ></option>
									<option value="Usuario" <?php echo set_select('perfil', 'Usuario', $dafault);?> >Usuario</option>
						          	<option value="Catalogador" <?php echo set_select('perfil', 'Catalogador', $catalogador);?> >Catalogador</option>
						          	<option value="Administrador" <?php echo set_select('perfil', 'Administrador', $administrador);?> >Administrador</option>
	        					</select>
	        				</div>
	        				<?php echo form_error('perfil', '<div class="alert alert-danger">', '</div>'); ?>
	        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Modificar</button>
						</form>
					</div>		
				</div>
			</div>
		</section>