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

	/**
	 * Obtiene los autores de un documento especifico, si se envia como true
	 * la variable $with_id se inserta en el select el id del autor, caso contrario
	 * se consulta solo su nombre.
	 * @param  [type]  $id_doc  Docuemnto especifico del cual se consultaran sus autores.
	 * @param  boolean $with_id true/false si es true se consulta nombre e id del autor,
	 *                          si es false se consulta solo su nombre.
	 * @return array           array de autores, si no hay resultados se retorna un array.
	 */
	public function get_autores_doc($id_doc, $with_id=FALSE)
	{
		if($with_id)
		{
			$this->db->select('autores.id, autores.nombre');
		}
		else
		{
			$this->db->select('autores.nombre');
		}		
		$this->db->from('autores');
		$this->db->join('escrito', 'escrito.id_autor = autores.id', 'inner');
		$this->db->where('escrito.id_documento', $id_doc);
		$this->db->order_by("nombre", "asc");
		$result = $this->db->get();
		if($result->num_rows() > 0)
        {
            return $result->result_array();
        }
        return array();
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
			//return $result->result_array();
			$result = $result->result_array();
            foreach($result as $key => $value)
			{
				//hacemos que la misma llave de cada documento en el array result, sea la misma
				//en el array de autores.
				$autores[$key] = $this->get_autores_doc($value['id']);
				//agregamos los autores de cada documento al array de documentos.
				$result[$key] = $result[$key] + array($autores[$key]);
			}
			return $result;
		}else
		{
			return array();
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
				//return $result->result_array();
				$result = $result->result_array();
	            foreach($result as $key => $value)
				{
					//hacemos que la misma llave de cada documento en el array result, sea la misma
					//en el array de autores.
					$autores[$key] = $this->get_autores_doc($value['id']);
					//agregamos los autores de cada documento al array de documentos.
					$result[$key] = $result[$key] + array($autores[$key]);
				}
				return $result;
			}else
			{
				return array();
			}
		}
		return FALSE;
	}

	public function get_doc_id($id)
	{
		$this->db->distinct();
		$this->db->select('documento.id, documento.titulo_p, documento.titulo_s, documento.tipo, documento.idioma, documento.descripcion, documento.palabras_clave, editorial.nombre');
		$this->db->from('documento');
		$this->db->join('editorial', 'editorial.id = documento.id_editorial', 'inner');
		$this->db->or_where('documento.id', $id);
		$this->db->order_by("documento.id", "asc");
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			//return $result->result_array();
			$result = $result->result_array();
            foreach($result as $key => $value)
			{
				//hacemos que la misma llave de cada documento en el array result, sea la misma
				//en el array de autores.
				$autores[$key] = $this->get_autores_doc($value['id']);
				//agregamos los autores de cada documento al array de documentos.
				$result[$key] = $result[$key] + array($autores[$key]);
			}
			return $result;
		}else
		{
			return array();
		}
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

	public function delete_escrito_by($id_documento, $ids_autors)
	{
		$response = FALSE;
		//si ids autor esta vacio significa qu el archivo no tiene autores
		//por tanto no ejecutamos busquedas ni eliminación ya que se nos
		//retornaria un error, por ello solo retornamos un true.
		if(empty($ids_autors))
		{
			return TRUE;
		}else
		{
			foreach($ids_autors as $value)
			{
				$result = $this->db->get_where('escrito', array('id_documento' => $id_documento,
																'id_autor' => $value['id']));
				if($result->num_rows() > 0)
				{
					$response = $this->db->delete('escrito',
							  array('id_documento' => $id_documento,
							  		'id_autor' => $value['id']));
				}else{
					$response = TRUE;
				}
			}
		}
		return $response;
	}

	public function update_libro($id, $titulo_p, $titulo_s, $idioma,
						   $tipo, $nombre_file, $descripcion, 
						   $palabra_clave, $id_editorial, $ids_autors)
	{
		if($nombre_file)
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
		}else
		{
			$data = array(
    				'titulo_p' 		=> $titulo_p,
    				'titulo_s'  	=> $titulo_s,
    				'idioma'	 	=> $idioma,
    				'tipo' 			=> $tipo,
    				'descripcion' 	=> $descripcion,
    				'palabras_clave'=> $palabra_clave,
    				'id_editorial' 	=> $id_editorial
    				);
		}
		
		//actualizamos la info del documento
		$response = $this->db->update('documento', $data, array('id' => $id));
		//si la actualizacion se lleva acabo actualizamos la info referente al o los 
		//creadores del documento
		if($response)
		{
			//obtenemos los id de los autores anteriores, es decir loas autores
			//antes de modificar el documento
			$ids_autors_last = $this->get_autores_doc($id, TRUE);
			//eliminamos las filas correspondienteas a esos autores que escribieron
			//esos documentos.
			$response = $this->delete_escrito_by($id, $ids_autors_last);
			//si se eliminan de manera correcta creamos de nuevo esas filas eliminadas
			//pero ya con los autores nuevos o en su defecto con los mismos autores.
			if($response)
			{
				return $this->create_escrito($id, $ids_autors);
			}
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