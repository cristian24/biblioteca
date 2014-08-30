<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap.css');?>">
		<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap-responsive.css');?>"> -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css');?>">
	</head>

	<body>
		
		<nav class="navbar navbar-default navbar-fixed-top">	
			<div class="container-fluid"> 	
				<div class="navbar-header">
		    		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
	    			</button>
	    			<?php echo anchor('', 'BIBLIOCRISTIAN', array('class' => 'navbar-brand')); ?>
		  		</div>

		  		<div class="navbar-collapse collapse navbar-responsive-collapse">
			  		<ul class="nav navbar-nav navbar-float">
			  			<?php if($this->session->accesoView('Catalogador')): ?>
			  			<li class="<?php echo $libros_class;?>">
			  				<?php echo anchor('libros', 'Libros');?>
			  			</li>
			  			<?php endif; ?>
						
						<?php if($this->session->accesoView('Administrador')): ?>
						<li class="<?php echo $usuario_class;?>">
							<?php echo anchor('usuarios', 'Usuarios');?>
						</li>
						<?php endif; ?>	
				    </ul>
					
					<?php if( ! $this->session->userdata('is_logued_in')): ?>
				    <ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">								
								<li><?php echo anchor('usuarios/login', 'Iniciar Sesion'); ?></li>
								<li><?php echo anchor('usuarios/create', 'Crear Cuenta');?></li>
							</ul>							
						</li>
				    </ul>
					<?php else: ?>

					<ul class="nav navbar-nav navbar-right">
					    <li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Modificar Contraseña</a></li>
								<li><a href="#">Modificar Info</a></li>
								<li class="divider"></li>
								<li><?php echo anchor('usuarios/salir', 'Salir');?></li>
							</ul>
							
						</li>
					</ul>
					<?php endif; ?>

				    <form class="navbar-form navbar-right">
				    	<div class="input-group">
				    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
				     		<input class="form-control col-lg-4" placeholder="Titulo/Autor/Editorial" type="text">
				     	</div>
				    </form>					    
					
			  	</div>
			</div>	 		  			
		</nav>

		<div id="contenido">