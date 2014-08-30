<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Biblioteca Virtual</title>
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
		    		<a class="navbar-brand" href="#">BIBLIOCRISTIAN</a>
		  		</div>

		  		<div class="navbar-collapse collapse navbar-responsive-collapse">
			  		<ul class="nav navbar-nav navbar-float">		      	
				      	<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-book"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Crear Libro</a></li>
								<li><a href="#">Modificar Libro</a></li>
								<li><a href="#">Eliminar Libro</a></li>
								<li class="divider"></li>
								<li><a href="#">Crear Autor</a></li>
								<li><a href="#">Modificar Autor</a></li>
								<li><a href="#">Eliminar Autor</a></li>
								<li class="divider"></li>
								<li><a href="#">Crear Editorial</a></li>
								<li><a href="#">Modificar Editorial</a></li>
								<li><a href="#">Eliminar Editorial</a></li>
							</ul>
						</li> 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-eye-open"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Crear Perfil</a></li>
								<li><a href="#">Modificar Perfil</a></li>
								<li class="divider"></li>
								<li><a href="#">Crear Usuario</a></li>
								<li><a href="#">Modificar Usuario</a></li>
								<li><a href="#">Eliminar Usuario</a></li>
							</ul>
						</li>						
				    </ul>
					
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
								<li><a href="#">Salir</a></li>
							</ul>
							
						</li>
					</ul>
				    <form class="navbar-form navbar-right">
				    	<div class="input-group">
				    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
				     		<input class="form-control col-lg-4" placeholder="Titulo/Autor/Editorial" type="text">
				     	</div>
				    </form>					    
					
			  	</div>
			</div>	 		  			
		</nav>			

		<header>
			<div class="container-fluid">
				<h1 class="text-center">Bienvenido a BiblioCristian</h1>
				<p class="small text-center">Creado por Cristian Cuspoca</p>
			</div>			
		</header>
		
		<section class="container-fluid paddin-topottom-md">
			<ul class="breadcrumb">
			  	<li class="active">Inicio</li>
			</ul>
			<h1 class="text-center">B&uacute;squeda</h1>										
			<form class="form-group">
				<div class="input-group">
		    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
		     		<input class="form-control input-lg" placeholder="Titulo/Autor/Editorial" type="text">
		     		<span class="input-group-btn">
			      		<button class="btn btn-default input-lg" type="button">Buscar</button>
			    	</span>
		     	</div>
		    </form>
			

		</section>

		<footer>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<span class="copyright">
							Copyright © 2014
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="copyright">
							Creado por Cristian Andr&eacute;s Cuspoca
						</span>
					</div>
				</div>
			</div>			
		</footer>

		<script type="text/javascript" src="<?php echo base_url('js/jquery-1.10.2.js');?>"></script>
		<!-- <script type="text/javascript" src="<?php echo base_url('js/funciones.js');?>"></script> -->
		<script type="text/javascript" src="<?php echo base_url('js/bootstrap.js');?>"></script>
	</body>
</html>	