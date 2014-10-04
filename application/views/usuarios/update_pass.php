<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li class="active"><?php echo $section_actual ?></li>		  	
			</ul>

			<div class="row">				
				<div class="col-md-12">

					<div class="well">  				
		  				<h4>Nota!</h4>
		  				<p>Si olvidaste tu contraseña accede 
		  				<?php echo anchor('usuarios/recover_data/true', 'Aqui', array('class' => 'alert-link')); ?>, para recuperarla</p>  
					</div>
									
					<div class="paddin-topottom-sm">
						<h1 class="text-center">
							<?php echo $title_section; ?><br>
							<small><?php echo $subtitle_section; ?></small>
						</h1>
						
						<?php echo form_open('usuarios/update_pass', array('class' => 'form-signin', 'id' => 'form_update_pass')); ?>					

							<div class="form-group">
								<input class="form-control" type="password" id="camp_pass_last" name="pass_last" placeholder="Contraseña Actual">								
							</div>
							<div class="alert alert-danger error" id="error_pass_last">					
								<?php echo validation_errors(); ?>
							</div>							

							<div class="form-group">
								<input class="form-control" type="password" id="camp_pass" name="pass" placeholder="Contraseña Nueva">
							</div>
							<div class="alert alert-danger error" id="error_pass">					
								<?php echo validation_errors(); ?>
							</div>

							<div class="form-group">
								<input class="form-control" type="password" id="camp_pass2" name="pass2" placeholder="Repetir Contraseña Nueva">
							</div>
							<div class="alert alert-danger error" id="error_pass2">					
								<?php echo validation_errors(); ?>
							</div>							
							
	        				<button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Actualizar</button>
						</form>
					</div>		
				</div>
			</div>
		</section>