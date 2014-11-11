<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo del módulo documentos, en esta clase se hacen todas las consultas
 * relacionadas con la gestión de documentos, extiende del core del modelo
 * de codeigniter, carga la base de datos.
 * @author Cristia Andres Cuspoca <cristian.cuspoca@correounivalle.edu.co>
 * @version 1.0
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
	 * Obtiene los autores de un documento específico, si se envía como true
	 * la variable $with_id se inserta en el select el id del autor, caso contrario
	 * se consulta solo su nombre.
	 * @param  [type]  $id_doc  Documento especifico del cual se consultaran sus autores.
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

	/**
	 * Obtiene todos los documentos de la base de datos.
	 * @return array() resultados de búsqueda, si no se encuentra nada se retorna un array vacío.
	 */
	public function get_docs_all()
	{
		$this->db->distinct();
		$this->db->select('documento.id, documento.ruta, documento.titulo_p, documento.titulo_s, documento.idioma, documento.descripcion, editorial.nombre');
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

	/**
	 * Obtiene los documentos que coinciden con el filtro de búsqueda.
	 * @param  String $query  Filtro de búsqueda.
	 * @return Array          Resultados de búsqueda, retorna un array vacío si no se encuentran
	 *                        Registros.          	
	 */
	public function get_docs_by_query($query)
	{
		if($query)
		{
			$this->db->distinct();
			$this->db->select('documento.id, documento.ruta, documento.titulo_p, documento.titulo_s, documento.idioma, documento.descripcion, editorial.nombre');
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

	/**
	 * Obtiene un documento que coincide con el id que se envía por parámetro.
	 * @param  String $id  Id del documento buscado.
	 * @return Array()     Resultados del documento con id $id.
	 */
	public function get_doc_id($id)
	{
		$this->db->distinct();
		$this->db->select('documento.id, documento.ruta, documento.titulo_p, documento.titulo_s, documento.tipo, documento.idioma, documento.descripcion, documento.palabras_clave, editorial.nombre');
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

	/**
	 * Ingresa un nuevo registro de documento en la base de datos
	 * @param  String $titulo_p      Título Principal del documento.
	 * @param  String $titulo_s      Titulo Secundario del documento.
	 * @param  String $idioma        Idioma del documento.
	 * @param  String $tipo          Tipo de documento.
	 * @param  String $nombre_file   Ruta del documento.
	 * @param  String $descripcion   Descripción del documento.
	 * @param  String $palabra_clave Palabras del documento.
	 * @param  String $id_editorial  Id del editorial del documento.
	 * @param  String $ids_autor     Ids de/los autores del documento.
	 * @return void/false            Registro creado, o false si falla la creación.
	 */
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

	/**
	 * Elimina un registro de la tabla escrito, si este registro existe.
	 * @param  String $id_documento Id del documento.
	 * @param  String $ids_autors   Id del autor.
	 * @return True/False           - si $ids_autors esta vacío se retorna true, caso contrario false.
	 *                              - si se encuentra un registro en la tabla escrito que responda
	 *                              al $id_documento y al $ids_autors se elimina el registro, caso
	 *                              Contrario se retorna un true.
	 */
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

	/**
	 * Actualiza un registro de la tabla documento, si se envía algún valor
	 * en el paramento $nombre_file también se actualiza este valor caso contrario
	 * no se hace.
	 * @param  String $id            ID del Documento.
	 * @param  String $titulo_p      Título Principal del Documento.
	 * @param  String $titulo_s      Titulo Secundario del Documento.
	 * @param  String $idioma        Idioma del Documento.
	 * @param  String $tipo          Tipo del Documento.
	 * @param  String $nombre_file   Ruta del Documento.
	 * @param  String $descripcion   Descripción del Documento.
	 * @param  String $palabra_clave Palabras claves del Documento.
	 * @param  String $id_editorial  ID de la editorial del Documento.
	 * @param  String $ids_autors    Id autores del Documento.
	 * @return False/True            True si la petición se lleva a término, caso contrario false.
	 */
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

	/**
	 * Crea nuevo registro de la tabla escrito.
	 * @param  String $id_documento Id del documento.
	 * @param  String $ids_autor    Id del autor, asociado al documento.
	 * @return True/False           False si falla, true si no.
	 */
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

	/**
	 * Elimina un registro de la tabla documento.
	 * @param  String $id id del documento a eliminar.
	 * @return void
	 */
	public function delete($id)
	{
		$this->db->where('id', $id);
        $this->db->delete('documento');
	}

}

/* End of file libros_model.php */
/* Location: ./application/models/libros_model.php */