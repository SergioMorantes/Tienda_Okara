<?php 
class ClientesModel extends Mysql
{
	private $intIdUsuario;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intStatus;
	private $strDireccion;
	private $strBarrio;
	private $strCiudad;

	public function __construct()
	{
		parent::__construct();
	}	

	public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, string $direccion, string $barrio, string $ciudad){

		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->strDireccion = $direccion;
		$this->strBarrio = $barrio;
		$this->strCiudad = $ciudad;

		$return = 0;
		$sql = "SELECT * FROM persona WHERE 
				email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,direccion,barrio,ciudad) 
							  VALUES(?,?,?,?,?,?,?,?,?,?)";
        	$arrData = array($this->strIdentificacion,
    						$this->strNombre,
    						$this->strApellido,
    						$this->intTelefono,
    						$this->strEmail,
    						$this->strPassword,
    						$this->intTipoId,
    						$this->strDireccion,
    						$this->strBarrio,
    						$this->strCiudad);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}

	public function selectClientes()
	{
		$sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status 
				FROM persona 
				WHERE rolid = 7 and status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectCliente(int $idpersona){
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,direccion,barrio,ciudad,status, DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro 
				FROM persona
				WHERE idpersona = $this->intIdUsuario and rolid = 7";
		$request = $this->select($sql);
		return $request;
	}

	public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, string $direccion, string $barrio, string $ciudad){

		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->strDireccion = $direccion;
		$this->strBarrio = $barrio;
		$this->strCiudad = $ciudad;

		$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
									  OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			if($this->strPassword  != "")
			{
				$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, direccion=?, barrio=?, ciudad=? 
						WHERE idpersona = $this->intIdUsuario ";
				$arrData = array($this->strIdentificacion,
        						$this->strNombre,
        						$this->strApellido,
        						$this->intTelefono,
        						$this->strEmail,
        						$this->strPassword,
        						$this->strDireccion,
        						$this->strBarrio,
        						$this->strCiudad);
			}else{
				$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, direccion=?, barrio=?, ciudad=?  
						WHERE idpersona = $this->intIdUsuario ";
				$arrData = array($this->strIdentificacion,
        						$this->strNombre,
        						$this->strApellido,
        						$this->intTelefono,
        						$this->strEmail,
        						$this->strDireccion,
        						$this->strBarrio,
        						$this->strCiudad);
			}
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	}

	public function deleteCliente(int $intIdpersona)
	{
		$this->intIdUsuario = $intIdpersona;
		$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}

 ?>