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
								<strong>Advertencia!! </strong><?php echo $mensaje_err;?>
							</div>
						<?php endif; ?>

						<?php if(isset($mensaje_ok)): ?>
							<div class="alert alert-success alert-dismissable" role="alert">
								<button type="button" class="close" data-dismiss="alert">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
								<strong>Ok!! </strong><?php echo $mensaje_ok;?>, si el correo no ha llegado puedes 
								volver a <?php echo anchor('usuarios/recover_data/true', 'intentarlo', array('class'=>'alert-link')); ?>
							</div>
						<?php else: ?>
							<!-- Si entra a quí es porque el proceso de envio de correo no se ha llevado acabo -->
							<?php if($type_recover === 'pass'): ?>

							<?php echo form_open('usuarios/recover_data/true', array('class' => 'form-signin', 'id' => 'form_recover_pass')); ?>					
								<div class="form-group">
									<input class="form-control" type="email" id="camp_email" <?php echo (empty($usuario)) ? "value=''" : "value='".$usuario['correo']."' readonly";?> name="correo" placeholder="Correo">								
								</div>
								<?php echo form_error('correo', '<div class="alert alert-danger">', '</div>'); ?>					
		        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Recuperar</button>
		        				<?php if( ! empty($usuario)): ?>
			        				<span class="help-block">
		        						Si cambiaste de correo, actualiza esta info <?php echo anchor('usuarios/update_info', 'Aquí'); ?>.
		        					</span>
	        					<?php endif; ?>
							</form>

							<?php else: ?>

							<?php echo form_open('usuarios/recover_data/', array('class' => 'form-signin', 'id' => 'form_recover_login')); ?>					
								<div class="form-group">
									<input class="form-control" type="email" id="camp_email" value="<?php echo set_value('correo');?>" name="correo" placeholder="Correo">								
								</div>
								<?php echo form_error('correo', '<div class="alert alert-danger">', '</div>'); ?>						
		        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Recuperar</button>		        				
							</form>
							<?php endif; ?>
						<?php endif; ?>
					</div>		
				</div>
			</div>
		</section>