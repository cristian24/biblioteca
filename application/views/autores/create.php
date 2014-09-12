			<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title" id="create_autor_modalLabel">Crear Autor</h4>
	      	</div>
	      	<?php echo form_open('autores/create_rqst', array('id' => 'form_create_autor', 'spellcheck' => 'true')); ?>
		      	<div class="modal-body">	      		
		      		<div class="form-group">
		      			<label for="nombre">Nombre Autor</label>
						<input class="form-control" type="text" id="input_nombre_autor" name="nombre" value="<?php echo set_value('nombre');?>" placeholder="Nombre del Autor">								
					</div>
					<div class="alert alert-danger error" id="err_name_autor">					
						<?php echo validation_errors(); ?>
					</div>
					<div class="alert alert-success success" id="ok_name_autor"></div>
				</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        	<input type="submit" id="btn_create_autor" class="btn btn-primary" role="button" value="Crear">	        	
		      	</div>
	      	</form>