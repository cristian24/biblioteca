<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador del módulo Documentos, en esta clase se hacen y responden todas las peticiones
 * relacionadas con la gestión de Documentos, se encarga de cargar la vista adecuada para cada 
 * petición, extiende del core del controller de codeigniter y carga el modelo de Documentos.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Libros extends CI_Controller {

	/**
	 * Constructor, carga los modelos necesario
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('libros_model');
		$this->load->model('autores_model');
		$this->load->model('editoriales_model');
	}

	/**
	 * Función que carga la vista de resultados de búsqueda hecha por un usuario
	 * normal, debido a que esta petición se hace de manera dinámica, verificamos
	 * que sea una llamado ajax, caso contrario mostramos el error 404.
	 * @return void renderizado de la vista.
	 */
	function rqst_view_query()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->view('libros/result_query');
		}else
		{
			show_404();
		}
	}

	/**
	 * Función auxiliar que se encarga de omitir de una cadena pasada por parámetro
	 * pronombres, preposiciones, tambien de convertir el texto a minúscula.
	 * @param  string $string   cadena a procesar
	 * @param  string $encoding codificación alfanumérica.
	 * @return array()          Resultado de la palabra procesada.
	 */
	function tags($string, $encoding = 'ISO-8859-1'){
        $string = trim(strip_tags(html_entity_decode(urldecode($string))));
        if(empty($string)){ return false; }
     
        $extras = array(
            'p'=>array('ante', 'bajo', 'con', 'contra', 'desde', 'durante', 'entre',
                       'hacia', 'hasta', 'mediante', 'para', 'por', 'pro', 'segun',
                       'sin', 'sobre', 'tras', 'via'
            ),
            'a'=>array('los', 'las', 'una', 'unos', 'unas', 'este', 'estos', 'ese',
                       'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esa', 'esas',
                       'aquella', 'aquellas', 'usted', 'nosotros', 'vosotros',
                       'ustedes', 'nos', 'les', 'nuestro', 'nuestra', 'vuestro',
                       'vuestra', 'mis', 'tus', 'sus', 'nuestros', 'nuestras',
                       'vuestros', 'vuestras'
            ),
            'o'=>array('esto', 'que'),
        );
     
        $string = strtr(mb_strtolower((string)$string, $encoding),
                        'âàåáäèéêëïîìíôöòóúûüùñ',
                        'aaaaaeeeeiiiioooouuuun'
        );
        if(preg_match_all('/\pL{3,}/s', $string, $m)){
            $m = array_diff(array_unique($m[0]), $extras['p'], $extras['a'], $extras['o']);
        }
        return $m;
    }

    /**
     * Función auxiliar que elimina espacio en blanco al inicio y al final, y convierte 
     * los espacios en blanco en caracteres '|', además de reemplazar múltiples espacios, 
     * por uno solo.
     * @param  String $palabra Texto a procesar
     * @return String          Texto Procesado.
     */
	public function procesar_palabra($palabra){
        if(!empty($palabra)){
            $valor = $this->tags($palabra);
            if(!empty($valor[0])){
        	  	$palabra = implode("|", $valor);
        	  	$palabra = ltrim($palabra);
        	  	$palabra = rtrim($palabra);                           
        	  	$palabra = preg_replace("/\s\s+/", " " ,$palabra);                 
                return $palabra;
            }                         
        }
    }
	
	/**
	 * Carga la vista principal del módulo de documentos
	 * @param  boolean $mensaje se envía o no mensaje de éxito o error en la creación de un usuario
	 * @return void             se imprime la vista principal del módulo de documentos.
	 */
	public function index($mensaje = FALSE)
	{		
		if($mensaje)
		{
			if($mensaje === 'ok')
			{
				$data['mensaje_ok'] = "<div class='alert alert-success alert-dismissible' role='alert'>
											<button type='button' class='close' data-dismiss='alert'>
												<span aria-hidden='true'>&times;</span>
												<span class='sr-only'>Close</span>
											</button>
											Documento creado con exito!
										</div>";
				$data['mensaje_err'] = "";
			}				
			else
			{
				$data['mensaje_err'] = "<div class='alert alert-danger alert-dismissible' role='alert'>
											<button type='button' class='close' data-dismiss='alert'>
												<span aria-hidden='true'>&times;</span>
												<span class='sr-only'>Close</span>
											</button>
											Error! al crear documento vuelve a 
											<a class='alert-link' href='../create'>intentarlo</a>.
										</div>";
				$data['mensaje_ok'] = "";
			}				
		}else
		{
			$data['mensaje_ok'] = "";
			$data['mensaje_err'] = "";
		}

		$this->session->acceso('Catalogador');		
		$data['title'] = 'Gesti&oacute;n Biblioteca';
		$data['title_section'] = 'Gesti&oacute;n de BiblioCristian';
		$data['subtitle_section'] = 'Gestiona Libros, Autores Editoriales';
		$data['libros_class'] = 'active';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'Libros';
		$this->load->view('template/header', $data);
		$this->load->view('libros/libros', $data);
		$this->load->view('template/footer');		
	}

	/**
	 * Carga la vista de creación de documentos
	 * @return void se imprime la vista de creación de documentos.
	 */
	public function create()
	{
		$this->session->acceso('Catalogador');
		$this->form_validation->set_rules('titulo_s', 'Titulo Secundario', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('titulo_p', 'Titulo Principal', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('autor[]', 'Autor(es)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editorial', 'Autor(es)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('idioma', 'Idioma', 'trim|required|xss_clean');
		$this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required|min_length[3]|max_length[65535]|xss_clean');
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('wrap_keys', 'Palabras Claves', 'trim|required|min_length[3]|max_length[300]|xss_clean');

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc';
		$config['max_size']	= '512000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['max_filename']  = '40';
		$config['remove_spaces']  = TRUE;
		$config['overwrite']  = TRUE;
		$this->load->library('upload', $config);

		$data['title'] = 'Crear Libro';
		$data['title_section'] = 'Crea un Libro';
		$data['subtitle_section'] = 'Puedes crear un libro o documento';
		$data['libros_class'] = 'active';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'Crear Documento';
		$data['libro_create_class'] = 'active';
		$data['libro_query_class'] = '';
		$data['autor_create_class'] = '';
		$data['autor_edit_class'] = '';
		$data['editorial_create_class'] = '';
		$data['editorial_edit_class'] = '';
		$data['editoriales'] = $this->editoriales_model->get_editoriales();
		$data['autores'] = $this->autores_model->get_autores();

		if($this->form_validation->run() === FALSE)
        {        		
			$data['error_file'] =  '';				
			$this->load->view('template/header', $data);
			$this->load->view('libros/create_libro', $data);
			$this->load->view('template/footer');
        }else
        {        	
        	if( ! $this->upload->do_upload())
        	{
        		$data['error_file'] =  $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
        		$this->load->view('template/header', $data);
				$this->load->view('libros/create_libro', $data);
				$this->load->view('template/footer');
        	}else
        	{
        		$titulo_p = $this->input->post('titulo_p');
	        	$titulo_s = $this->input->post('titulo_s');
	        	$idioma = $this->input->post('idioma');        	
	        	$autores = $this->input->post('autor');
	        	$editorial = $this->input->post('editorial');
	        	$descripcion = $this->input->post('descripcion');
	        	$tipo = $this->input->post('tipo');
	        	$wrap_keys = $this->input->post('wrap_keys');
	        	$data_file = $this->upload->data();

	        	$response = $this->libros_model->create($titulo_p, $titulo_s, $idioma, $tipo, 
	        											$data_file['file_name'], $descripcion, 
	        											$wrap_keys, $editorial, $autores);
	        	if($response)
	        	{
	        		redirect('libros/index/ok');
	        	}else
	        	{
	        		redirect('libros/index/err');
	        	}
	        	
        	}
        }		
	}

	/**
	 * Función que responde a una petición ajax de búsqueda de documentos, si no es un llamado
	 * ajax se responde con un 404, caso contrario se verifica el resultado de la petición 
	 * al modelo de datos, si la respuesta del modelo esta vacía significa que no se encontró
	 * el documento buscado, caso contrario se envían a través de json el resultado de la 
	 * consulta.
	 * @param  String $query  Filtro de búsqueda.
	 * @return void           Renderizado de los resultados de búsqueda.
	 */
	public function query_rqst($query)
	{
		if($this->input->is_ajax_request())
		{
			$doc_buscado = $this->procesar_palabra($query);
			$respuesta = $this->libros_model->get_docs_by_query($doc_buscado);
			if( ! empty($respuesta))
			{
				$data = array('res' => 'success', 'docs' => $respuesta);
				echo json_encode($data);
			}else
			{
				$data = array('res' => 'no found');
				echo json_encode($data);
			}
		}else
		{
			show_404();
		}
	}

	/**
	 * Renderiza vista de búsqueda de documentos, se muestran inicialmente todos los documentos de 
	 * la base de datos.
	 * @return void     Renderizado de la vista.
	 */
	public function query()
	{
		$this->session->acceso('Catalogador');
		$data['libros_class'] = 'active';
		$data['usuario_class'] = '';
		$data['libro_create_class'] = '';
		$data['autor_create_class'] = '';
		$data['autor_edit_class'] = '';
		$data['editorial_create_class'] = '';
		$data['editorial_edit_class'] = '';
		$data['title'] = 'Consultar Documento';
		$data['title_section'] = 'Consultar un Documento';
		$data['subtitle_section'] = 'Consulta, actualiza o Elimina';
		$data['section_actual'] = 'Consultar Documento';
		$data['libro_query_class'] = 'active';
		//$query = $this->procesar_palabra('');
		$result = $this->libros_model->get_docs_all();				
		/*foreach($result as $key => $value)
		{
			//hacemos que la misma llave de cada documento en el array result, sea la misma
			//en el array de autores.
			$autores[$key] = $this->autores_model->get_autores_doc($value['id']);
			//agregamos los autores de cada documento al array de documentos.
			$result[$key] = $result[$key] + array($autores[$key]);
		}*/
		$data['libros'] = $result;
		$this->load->view('template/header', $data);
		$this->load->view('libros/query', $data);
		$this->load->view('template/footer');				
	}

	/**
	 * Renderiza vista de actualización de documentos.
	 * @param  String  $id         Id del documento a actualizar.
	 * @param  boolean $mensaje_ok Funciona como bandera para imprimir mensaje de success(true)
	 * ó error(false).
	 * @return void                Renderizado de la vista.
	 */
	public function update($id, $mensaje_ok=FALSE)
	{
		if( ! empty($mensaje_ok) && $mensaje_ok === 'OK')
		{
			$data['mensaje_ok'] = 'OK';
		}elseif( ! empty($mensaje_ok) && $mensaje_ok === 'ERROR')
		{
			$data['mensaje_ok'] = 'ERROR';
		}else
		{
			$data['mensaje_ok'] = FALSE;
		}

		$this->session->acceso('Catalogador');
		$this->form_validation->set_rules('titulo_s', 'Titulo Secundario', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('titulo_p', 'Titulo Principal', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('autor[]', 'Autor(es)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('editorial', 'Autor(es)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('idioma', 'Idioma', 'trim|required|xss_clean');
		$this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required|min_length[3]|max_length[65535]|xss_clean');
		$this->form_validation->set_rules('tipo', 'Tipo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('wrap_keys', 'Palabras Claves', 'trim|required|min_length[3]|max_length[300]|xss_clean');

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc';
		$config['max_size']	= '512000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['max_filename']  = '40';
		$config['remove_spaces']  = TRUE;
		$config['overwrite']  = TRUE;
		$this->load->library('upload', $config);	

		if($this->form_validation->run() === FALSE)
        {
        	$data['libros_class'] = 'active';
			$data['usuario_class'] = '';
			$data['libro_create_class'] = '';
			$data['autor_create_class'] = '';
			$data['autor_edit_class'] = '';
			$data['editorial_create_class'] = '';
			$data['editorial_edit_class'] = '';
			$data['title'] = 'Modificar/Actualizar Documento';
			$data['title_section'] = 'Modificar un Documento';
			$data['subtitle_section'] = '';
			$data['section_actual'] = $id;
			$data['libro_query_class'] = '';
			$documento = $this->libros_model->get_doc_id($id);		
			$data['documento'] = $documento[0];
			//obtenemos los autores del documento
			$name_autores_doc = $documento[0][0];
			$autors_doc = '';

			//convertimos el array en una cadena separada por comas
			foreach ($name_autores_doc as $key => $value) 
			{
				$autors_doc = $autors_doc.$value['nombre'].',';
			}
			//eliminamos la ultima coma
			$autors_doc = substr($autors_doc, 0, (strlen($autors_doc) - 1));
			//convertimos de nuevo en un array mas limpio, el cual es de una sola dimension
			$autors_doc = explode(',', $autors_doc);
			
			$data['autors_doc'] = $autors_doc;
			$data['editoriales'] = $this->editoriales_model->get_editoriales();
			$data['autores'] = $this->autores_model->get_autores();
			$data['idiomas'] = array('' => '--Elige--',
									 'Inglés' => 'Inglés',
									 'Español' => 'Español',
									 'Francés' => 'Francés',
									 'Alemán' => 'Alemán',
									 'Portugués' => 'Portugués');
			$data['tipos'] = array('' => '',
								   'Revista' => 'Revista',
							       'Notas' => 'Notas',
							       'Libro' => 'Libro',
							       'Escrito/Resumen' => 'Escrito/Resumen',
							       'Diagrama' => 'Diagrama',
							       'Otros' => 'Otros');
        	$data['error_file'] = '';
			$this->load->view('template/header', $data);
			$this->load->view('libros/update', $data);
			$this->load->view('template/footer');
		}else
		{
			$titulo_p = $this->input->post('titulo_p');
        	$titulo_s = $this->input->post('titulo_s');
        	$idioma = $this->input->post('idioma');        	
        	$autors = $this->input->post('autor');
        	$editorial = $this->input->post('editorial');
        	$descripcion = $this->input->post('descripcion');
        	$tipo = $this->input->post('tipo');
        	$wrap_keys = $this->input->post('wrap_keys');
			//si el campo del archivo esta vacio significa que no se va a actualizar
			if( ! empty($this->input->post('userfile')))
        	{
        		if( ! $this->upload->do_upload())
	        	{
	        		$data['error_file'] =  $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
	        		$this->load->view('template/header', $data);
					$this->load->view('libros/update', $data);
					$this->load->view('template/footer');
	        	}else
	        	{	        		
		        	$data_file = $this->upload->data();
	        		$this->libros_model->update_libro($id, $titulo_p, $titulo_s, $idioma, $tipo, 
		        											$data_file['file_name'], $descripcion, 
		        											$wrap_keys, $editorial, $autors);
	        	}
        	}else
        	{
        		$response = $this->libros_model->update_libro($id, $titulo_p, $titulo_s, $idioma, $tipo, 
	        									  FALSE, $descripcion, $wrap_keys, 
	        									  $editorial, $autors);
        		if($response)
        		{
        			redirect('libros/update/'.$id.'/OK');
        		}else
        		{
        			redirect('libros/update/'.$id.'/ERROR');
        		}
        	}			
		}
	}


	/**
	 * Función que hace petición al modelo de eliminación de documento.
	 * @param  String $id Id del documento a eliminar.
	 * @return void       redirecciona a la vita de búsqueda.
	 */
	public function delete($id)
	{
		$this->libros_model->delete($id);
        redirect('libros/query/');
	}
}

/* End of file libros.php */
/* Location: ./application/controllers/libros.php */