<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador de peticiones restringidas.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
 */
class Restringido extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Acceso Restringido';
		$data['title_section'] = 'Acceso Denegado';
		$data['subtitle_section'] = 'No tienes privilegios para acceder a esta secci&oacute;n';
		$data['libros_class'] = '';
		$data['usuario_class'] = '';
		$data['section_actual'] = 'restringido';
		$this->load->view('template/header', $data);
		$this->load->view('restringido', $data);
		$this->load->view('template/footer');
	}

}

/* End of file restringido.php */
/* Location: ./application/controllers/restringido.php */