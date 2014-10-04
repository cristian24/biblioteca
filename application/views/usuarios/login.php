		<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
			  	<li class="active"><?php echo $section_actual ?></li>
			</ul>

			<div class="container">

				<?php echo $mensaje_ok; ?>
				<?php echo $mensaje_err; ?>

				<div class="well">  				
	  				<h4>Nota!</h4>
	  				<p>Para poder descargar libros es necesario iniciar sesion, si no tienes una cuenta creala 
	  				<?php echo anchor('#', 'Aqui', array('class' => 'alert-link')); ?></p>  
				</div>
				<div class="alert alert-danger error" id="user_invalid">					
					
				</div>				

				<?php echo form_open('usuarios/login_rqst', array('class' => 'form-signin', 'id' => 'form_login', 'role' => 'form')); ?>
				    <h1 class="form-signin-heading">
				    	<?php echo $title_section; ?>
				    </h1>

				    <div class="form-group">
				    	<input class="form-control" id="inputLogin" value="<?php echo set_value('login'); ?>" placeholder="Login" name="login" type="text" autofocus>
				    </div>
				    <div class="alert alert-danger error" id="error_login">					
						<?php echo validation_errors(); ?>
					</div>

					<div class="form-group">
						<input class="form-control" id="inputPass" placeholder="Contraseña" name="pass" type="password">			        
					</div>
					<div class="alert alert-danger error" id="error_pass">					
						<?php echo validation_errors(); ?>
					</div>		        
			        <button class="btn btn-primary btn-block btn-success" type="submit" title="Presiona para enviar">Ingresar</button>
			        <?php echo anchor('usuarios/recover_data/true', '¿Has olvidado tú contraseña?'); ?> |
			        <?php echo anchor('usuarios/recover_data', '¿Has olvidado tú Login?'); ?>	        
      			</form>										
			</div>
		</section>