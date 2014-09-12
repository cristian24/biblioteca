<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase encargada del acceso a los datos, relacionados con libros/documentos
 */
class Libros_model extends CI_Model {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->load->database();		
	}

	public function get_docs_all()
	{
		$this->db->distinct();
		$this->db->select('documento.id, documento.titulo_p, documento.titulo_s, documento.idioma, documento.descripcion, editorial.nombre');
		$this->db->from('documento');
		$this->db->join('editorial', 'editorial.id = documento.id_editorial', 'inner');
		$this->db->order_by("documento.id", "asc");
		$result = $this->db->get();

		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}else
		{
			return FALSE;
		}
	}

	public function get_docs_by_query($query)
	{
		if($query)
		{
			$this->db->distinct();
			$this->db->select('documento.id, documento.titulo_p, documento.titulo_s, documento.idioma, documento.descripcion, editorial.nombre');
			$this->db->from('documento');
			$this->db->join('escrito', 'escrito.id_documento = documento.id', 'inner');
			$this->db->join('autores', 'escrito.id_autor = autores.id', 'inner');
			$this->db->join('editorial', 'editorial.id = documento.id_editorial', 'inner');
			$this->db->or_where('documento.titulo_p REGEXP', $query);
			$this->db->or_where('documento.titulo_s REGEXP', $query);
			$this->db->or_where('documento.descripcion REGEXP', $query);
			$this->db->or_where('documento.palabras_clave REGEXP', $query);
			$this->db->or_where('autores.nombre REGEXP', $query);
			$this->db->or_where('editorial.nombre REGEXP', $query);
			$this->db->order_by("documento.id", "asc");			
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				return $result->result_array();
			}else
			{
				return FALSE;
			}
		}
		return FALSE;
	}

	public function create($titulo_p, $titulo_s, $idioma, 
						   $tipo, $nombre_file, $descripcion, 
						   $palabra_clave, $id_editorial, $ids_autor)
	{
		$data = array(
    				'titulo_p' 		=> $titulo_p,
    				'titulo_s'  	=> $titulo_s,
    				'idioma'	 	=> $idioma,
    				'tipo' 			=> $tipo,
    				'ruta' 			=> $nombre_file,
    				'descripcion' 	=> $descripcion,
    				'palabras_clave'=> $palabra_clave,
    				'id_editorial' 	=> $id_editorial
    			);
    	$response = $this->db->insert('documento', $data);
    	$id_documento = $this->db->insert_id();
    	if($response)
		{
			return $this->create_escrito($id_documento, $ids_autor);
		}else
		{
			return FALSE;
		}

	}

	public function create_escrito($id_documento, $ids_autor)
	{
		$response = FALSE;
		if(is_array($ids_autor))
    	{
    		for($i=0; $i<count($ids_autor); $i++)
    		{
    			$data_escrito = array('id_documento' => $id_documento, 'id_autor' => $ids_autor[$i]);
    			$response = $this->db->insert('escrito', $data_escrito);
    		}
    	}else
    	{
    		$data_escrito = array('id_documento' => $id_documento, 'id_autor' => $ids_autor);
    		$response = $this->db->insert('escrito', $data_escrito);
    	}
    	return $response;
	}

}

/* End of file libros_model.php */
/* Location: ./application/models/libros_model.php */