<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session{

  	//protected $ci;

    /**
     * Constructor
     */
	public function __construct()
	{
		parent::__construct();
        //$this->ci =& get_instance();
	}

    /**
     * Verifica que el usuario este logueado y coteja
     * el perfil que se envia como parametro y el perfil
     * del usuario logueado, para verificar su acceso.
     * @param  String $level  Perfil necesario para acceder.
     * @return boolean        TRUE si el usuario tiene 
     *                        permiso, caso contrario FALSE.
     */
    public function accesoView($level)
    {
        if( ! $this->userdata('is_logued_in'))
        {
            return false;
        }
        if($this->getLevel($level) > $this->getLevel($this->userdata('perfil'))){
            return false;
        }       
        return true;
    }

    /**
     * Verifica que el usuario este logueado y coteja
     * el perfil que se envia como parametro y el perfil
     * del usuario logueado, para verificar su acceso, si
     * no cumple se redirige a un area restringida.
     * @param  String $level Perfil necesario para acceder.
     * @return void        Se redirige o no, a un area restringida.
     */
	public function acceso($level){
		if( ! $this->userdata('is_logued_in'))
		{
			redirect('restringido');
		}else
		{
			if($this->getLevel($level) > $this->getLevel($this->userdata('perfil'))){
				redirect('restringido');
			}
		}
	}

    /**
     * Verifica si el usuario esta logueado
     * @param  String  $valor variable de session.
     * @return void        redirige al index
     */
	public function is_logueado(){
        if($this->userdata('is_logued_in') === TRUE)
        {            
            redirect('');
        }
    }

    /**
     * Asocia el perfil con un level numerico,
     * es una funcion auxiliar para ayudar a cotejar
     * privilegios.
     * @param  String $level perfil a convertir.
     * @return Array        contiene un valor numerico
     *                      referente al perfil.
     */
    public function getLevel($level)
    {
    	$role['Administrador'] = 3;
    	$role['Catalogador'] = 2;            
        $role['Usuario'] = 1;
            
        if( ! array_key_exists($level, $role)){
            redirect('restringido');
        }else{
            return $role[$level];
        }
    }

	

}

/* End of file MY_Session.php */
/* Location: ./application/libraries/MY_Session.php */
