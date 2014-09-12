<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editoriales extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('editoriales_model');
	}

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

	public function create()
	{
		$this->load->view('editoriales/create');
	}

}

/* End of file editoriales.php */
/* Location: ./application/controllers/editoriales.php */