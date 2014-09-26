<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autores extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('autores_model');
	}

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

	public function create()
	{
		$this->load->view('autores/create');
	}

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