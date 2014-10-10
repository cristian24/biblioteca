<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador de la vista principal, da inicio al flujod e información.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Home extends CI_Controller {
	
	public function index()
	{
		$data['title'] = 'BiblioCristian';
		$data['title-section'] = '';
		$data['libros_class'] = '';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'Inicio';
		$this->load->view('template/header', $data);
		$this->load->view('home', $data);
		$this->load->view('template/footer');
	}

	public function index_ajax(){
		$data['title'] = 'BiblioCristian';
		$data['title-section'] = '';
		$data['libros_class'] = '';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'Inicio';
		$this->load->view('home', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */