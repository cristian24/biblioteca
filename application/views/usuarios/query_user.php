<section class="container-fluid paddin-topottom-lg">
			<ul class="breadcrumb">
				<li><?php echo anchor('', 'Inicio'); ?></li>
				<li><?php echo anchor('usuarios', 'Usuarios'); ?></li>
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

						<?php echo $mensaje_ok; ?>
						<?php echo $mensaje_err; ?>
						
				    	<div class="input-group">
				    		<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
				     		<input class="form-control col-lg-4" id="camp_query_user" placeholder="nombre/login usuario" type="text" for="<?php echo $for; ?>">
				     	</div> 

				     	<div id="resultados" class="table-responsive">
				     		<h2 id="result-mensaje" class="text-center"></h2>
				     		<table class='table table-hover table-striped'>
	                           	<thead>
	                                <tr>
	                                    <th>Id</th>
	                                    <th>Nombre</th>
	                                   	<th>Login</th>
	                                    <th>Telefono</th>
	                                    <th>Correo</th>
	                                    <th>Perfil</th>
	                                    <th>Accion</th>
	                                </tr>
	                            </thead>
	                            <tbody>

	                            </tbody>
                        	</table>
				     	</div>

				     	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
						    	<div class="modal-content">
							      	
						    	</div>
						  	</div>
						</div>					
							
					</div>		
				</div>
			</div>
		</section>