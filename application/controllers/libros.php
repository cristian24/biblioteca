<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Libros extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->session->acceso('Catalogador');
		$data['title'] = 'Gesti&oacute;n Biblioteca';
		$data['title_section'] = 'Gesti&oacute;n de BiblioCristian';
		$data['subtitle_section'] = 'Gestiona Libros, Autores Editoriales';
		$data['libros_class'] = 'active';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'Libros';
		$this->load->view('template/header', $data);
		$this->load->view('libros', $data);
		$this->load->view('template/footer');		
	}
}

/* End of file libros.php */
/* Location: ./application/controllers/libros.php */