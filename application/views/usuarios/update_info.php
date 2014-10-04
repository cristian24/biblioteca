<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li class="active"><?php echo $section_actual ?></li>		  	
			</ul>

			<div class="row">				
				<div class="col-md-12">
					<div class="well">  				
		  				<h4>Nota!</h4>
		  				<p>Si lo que deseas es modificar tu contraseña ingresa 
		  				<?php echo anchor('usuarios/update_pass', 'Aqui', array('class' => 'alert-link')); ?></p>  
					</div>
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
								<strong>Ok!! </strong>Actualización Exitosa
							</div>
						<?php endif; ?>

						<?php echo form_open('usuarios/update_info', array('class' => 'form-signin')); ?>					

							<div class="form-group">
								<input class="form-control" type="text" name="nombre" value="<?php echo set_value('nombre', $usuario['nombre']);?>" placeholder="Nombre" autofocus>
								<span class="help-block">
	        						Actualiza tu Nombre.
	        					</span>
							</div>
							<?php echo form_error('nombre', '<div class="alert alert-danger">', '</div>'); ?> 

							<div class="form-group">
								<input class="form-control" type="text" name="telefono" value="<?php echo set_value('telefono', $usuario['telefono']);?>" placeholder="Telefono">
								<span class="help-block">
	        						Actualiza tu Telefono.
	        					</span>
							</div>
							<?php echo form_error('telefono', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="email" name="correo" value="<?php echo set_value('correo', $usuario['correo']);?>" placeholder="Correo">
								<span class="help-block">
	        						Actualiza tu Correo.
	        					</span>
							</div>
							<?php echo form_error('correo', '<div class="alert alert-danger">', '</div>'); ?>

							<div class="form-group">
								<input class="form-control" type="text" name="login" value="<?php echo set_value('login', $usuario['login']);?>" placeholder="Login">
								<span class="help-block">
	        						Actualiza tu login/nick.
	        					</span>
							</div>
							<?php echo form_error('login', '<div class="alert alert-danger">', '</div>'); ?>
							
							
	        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Actualizar</button>
						</form>
					</div>		
				</div>
			</div>
		</section>