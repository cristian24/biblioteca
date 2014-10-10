<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador del módulo Editoriale, en esta clase se hacen y responden todas las peticiones
 * relacionadas con la gestión de Editoriale, se encarga de cargar la vista adecuada para cada 
 * petición, extiende del core del controller de codeigniter y carga el modelo de Editoriale.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Editoriales extends CI_Controller {

    /**
     * Constructor, carga el modelo de editoriales.
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('editoriales_model');
	}

    /**
     * Responde y envia a través de una petición ajax una lista de editoriales.
     * @return json envio de dtos solicitados por json.
     */
    public function list_editoriales()
    {
        if($this->input->is_ajax_request())
        {
            $editoriales = $this->editoriales_model->get_editoriales();
            if($editoriales)
            {
                $data = array('list_editoriales' => $editoriales, 'res' => 'success');
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
     * Responde y envia a través de ajax etición de creación de una editorial.
     * @return json envio de respuesta por json
     */
    public function create_rqst()
	{
		if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('nombre', 'Nombre Editorial', 'trim|required|min_length[3]|max_length[30]|is_unique[editorial.nombre]|xss_clean');

            if($this->form_validation->run() === FALSE)
        	{
        		$data = array('res' => 'error', 'name' => form_error('nombre'));
        		echo json_encode($data);  
        		return false;
        	}else
        	{
        		$nombre = $this->input->post('nombre');
        		$peticion = $this->editoriales_model->create($nombre);
        		$data = array('res' => 'success', 'name' => $nombre, 'rqst' => $peticion);
        		echo json_encode($data);
        	}

        }else
        {
        	show_404();
        }
	}

    /**
     * Renderiza vista de creacion de editoriales.
     * @return void
     */
	public function create()
	{
		$this->load->view('editoriales/create');
	}

    /**
     * Recibe y envia petición ajax de actualización de una editorial.
     * @param  String $id Identificador de la editorial a actualizar.
     * @return json       Envio de respuesta por json.
     */
    public function update_rqst($id)
    {
        if($this->input->is_ajax_request())
        {            
            $this->form_validation->set_rules('nombre', 'Nombre Eidtorial', 'trim|required|min_length[3]|max_length[30]|xss_clean');
            if($this->form_validation->run() === FALSE)
            {
                $data = array('res' => 'error', 'name' => form_error('nombre'));
                echo json_encode($data);  
                return false;
            }else
            {
                $nombre = $this->input->post('nombre');
                $peticion = $this->editoriales_model->update($id,$nombre);
                $data = array('res' => 'success', 'rqst' => $peticion);
                echo json_encode($data);
            }
        }else
        {
            show_404();
        }
    }

    /**
     * Renderiza vista de búsqueda de editoriales.
     * @return void.
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
        $data['editorial_edit_class'] = 'active';
        $data['title'] = 'Modificar Editorial';
        $data['title_section'] = 'Modificar Editorial';
        $data['subtitle_section'] = 'Consulta, Elije y Actualiza';
        $data['section_actual'] = 'Modificar Editorial';
        $data['libro_query_class'] = '';
        $data['editoriales'] = $this->editoriales_model->get_editoriales();
        $this->load->view('template/header', $data);
        $this->load->view('editoriales/query', $data);
        $this->load->view('template/footer');
    }

    /**
     * Recibe y envia petición ajax de búsqueda de editoriales.
     * @param  boolean $query  filtro de búsqueda.
     * @return json            Respuesta a través de json.
     */
    public function query_rqst($query=FALSE)
    {
        if($this->input->is_ajax_request())
        {
            if($query === 'TODO')
            {
                $response = $this->editoriales_model->get_editoriales();
                $data = array('res' => 'success', 'datos' => $response);
                echo json_encode($data);
            }else
            {
                $response = $this->editoriales_model->get_editoriales_by($query);
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

}

/* End of file editoriales.php */
/* Location: ./application/controllers/editoriales.php */