<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador del módulo autores, en esta clase se hacen y responden todas las peticiones
 * relacionadas con la gestión de autores, se encarga de cargar la vista adecuada para cada 
 * petición, extiende del core del controller de codeigniter y carga el modelo de autores.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Autores extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('autores_model');
	}

    /**
     * Función que verifica si es una petición ajax si lo es
     * imprime el resultado de la petición, de lo contrario
     * redirige a la pagina 404. 
     * @return html recibe los datos de una petición o redirige
     *              a un 404.
     */
    public function list_autores()
    {
        if($this->input->is_ajax_request())
        {
            $autores = $this->autores_model->get_autores();
            if($autores)
            {
                $data = array('list_autores' => $autores, 'res' => 'success');
                echo json_encode($data);                
            }else
            {
                $data = array('res' => 'error');
                echo json_encode($data);
                return false;
            }
        }else
        {
            show_404();
        }
    }

    /**
     * Función que verifica si es una petición ajax si lo es verifica
     * los datos de un formulario si son correctos se envió una petición
     * ajax con estos datos y luego se recibe su respuesta, si la petición
     * se ejecuta satisfactoriamente se envía en forma de json un mensaje 
     * de satus success y los datos de la petición.
     * @return void Respuesta de la petición.
     */
	public function create_rqst()
	{
		if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('nombre', 'Nombre Autor', 'trim|required|min_length[3]|max_length[30]|is_unique[autores.nombre]|xss_clean');

            if($this->form_validation->run() === FALSE)
        	{
        		$data = array('res' => 'error', 'name' => form_error('nombre'));
        		echo json_encode($data);  
        		return false;
        	}else
        	{
        		$nombre = $this->input->post('nombre');
        		$peticion = $this->autores_model->create($nombre);
        		$data = array('res' => 'success', 'name' => $nombre, 'rqst' => $peticion);
        		echo json_encode($data);
        	}
        }else
        {
        	show_404();
        }
	}

    /**
     * Imprime la vista de creación de autores.
     * @return void Renderizado de la vista creación de autores.
     */
	public function create()
	{
		$this->load->view('autores/create');
	}

    /**
     * Función que ejecuta una consulta de modificación de datos, de un autor
     * a través de una petición ajax, después de validar los datos de entrada, se 
     * envian a traves de json el resultado de la petición.
     * @param  String $id identificador del autor a modificar
     * @return void     se imprime por medio de json el resultado de la petición.
     */
    public function update_rqst($id)
    {
        if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('nombre', 'Nombre Autor', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            if($this->form_validation->run() === FALSE)
            {
                $data = array('res' => 'error', 'name' => form_error('nombre'));
                echo json_encode($data);  
                return false;
            }else
            {
                $nombre = $this->input->post('nombre');
                $peticion = $this->autores_model->update($id,$nombre);
                $data = array('res' => 'success', 'rqst' => $peticion);
                echo json_encode($data);
            }
        }else
        {
            show_404();
        }
    }

    /**
     * Envió de petición por medio de ajax y json
     * @param  boolean $query filtro de búsqueda, si no se envía nada
     *                        se retorna todos los autores.
     * @return void         respuesta de la petición.
     */
    public function query_rqst($query=FALSE)
    {
        if($this->input->is_ajax_request())
        {
            if($query === 'TODO')
            {
                $response = $this->autores_model->get_autores();
                $data = array('res' => 'success', 'datos' => $response);
                echo json_encode($data);
            }else
            {
                $response = $this->autores_model->get_name_id($query);
                if( ! empty($response))
                {
                    $data = array('res' => 'success', 'datos' => $response);
                    echo json_encode($data);
                }else
                {
                    $data = array('res' => 'no found');
                    echo json_encode($data);
                }
            }            
        }else
        {
            show_404();
        }
    }

    /**
     * Función que imprime la vista de búsqueda de autores.
     * @return void Renderizado de la vista de búsqueda de autores.
     */
    public function query()
    {
        $this->session->acceso('Catalogador');
        $data['libros_class'] = 'active';
        $data['usuario_class'] = '';
        $data['libro_create_class'] = '';
        $data['autor_create_class'] = '';
        $data['autor_edit_class'] = 'active';
        $data['editorial_create_class'] = '';
        $data['editorial_edit_class'] = '';
        $data['title'] = 'Modificar Autor';
        $data['title_section'] = 'Modificar Autor';
        $data['subtitle_section'] = 'Consulta, Elije y Actualiza';
        $data['section_actual'] = 'Modificar Autor';
        $data['libro_query_class'] = '';
        $data['autores'] = $this->autores_model->get_autores();
        $this->load->view('template/header', $data);
        $this->load->view('autores/query', $data);
        $this->load->view('template/footer');
    }

}

/* End of file autores.php */
/* Location: ./application/controllers/autores.php */