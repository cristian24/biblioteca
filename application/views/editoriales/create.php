			<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title" id="create_editorial_modalLabel">Crear Editorial</h4>
	      	</div>
	      	<?php echo form_open('editoriales/create_rqst', array('id' => 'form_create_editorial', 'spellcheck' => 'true')); ?>
		      	<div class="modal-body">	      		
		      		<div class="form-group">
		      			<label for="nombre">Nombre Editorial</label>
						<input class="form-control" type="text" id="input_nombre_editorial" name="nombre" value="<?php echo set_value('nombre');?>" placeholder="Nombre de la Editorial">								
					</div>
					<div class="alert alert-danger error" id="err_name_editorial">					
						<?php echo validation_errors(); ?>
					</div>
					<div class="alert alert-success success" id="ok_name_editorial"></div>
				</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        	<input type="submit" id="btn_create_editorial" class="btn btn-primary" role="button" value="Crear">	        	
		      	</div>
	      	</form>