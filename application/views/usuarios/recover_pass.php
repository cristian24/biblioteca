<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li class="active"><?php echo $section_actual ?></li>		  	
			</ul>

			<div class="row">				
				<div class="col-md-12">
					
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>

						<?php if(isset($mensaje_err)): ?>
							<div class="alert alert-warning alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Error!! </strong><?php echo $mensaje_err;?>
							</div>
						<?php endif; ?>

						<?php if(isset($mensaje_ok)): ?>
							<div class="alert alert-success alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Ok!! </strong><?php echo $mensaje_ok;?>
							</div>
						<?php else: ?>
							<?php echo form_open('usuarios/recover_pass/'.$id.'/'.$code, array('class' => 'form-signin')); ?>					
								<div class="form-group">
									<input class="form-control" type="password" name="pass" placeholder="Contraseña">								
								</div>
								<?php echo form_error('pass', '<div class="alert alert-danger">', '</div>'); ?>

								<div class="form-group">
									<input class="form-control" type="password" name="pass2" placeholder="Repetir Contraseña">								
								</div>
								<?php echo form_error('pass2', '<div class="alert alert-danger">', '</div>'); ?>					
		        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Cambiar</button>		        				
							</form>
						<?php endif; ?>
					</div>		
				</div>
			</div>
		</section>