<? 
class daousuario{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }

    public function verificacionDePermisos($usuario, $modulo, $tipo)
    {
       
      //BUSCO EL ID DEL MODULO DONDE ME ENCUENTRO, EL PARAMETRO MODULO VA A SER EL NOMBRE DEL MODULO EN LA TABLA MODULOS
       
        if(is_numeric($modulo)){
            $mod_id = $modulo;
        }else{
            $query0 = "SELECT MOD_ID FROM modulos where MOD_NOMBRE LIKE '$modulo' OR MOD_ID = '$modulo'";
            $res1 = $this->bd->query($query0);
            if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query0, 1);
            $row = mysqli_fetch_assoc($res1);
            $mod_id= $row['MOD_ID'];

            
        }

        //BUSCO SI TIENE PERMISO DE INS/DEL/UPD EN EL MODULO DONDE SE VA A REALIZAR LA ACCIÓN,
        //SI TIENE PERFIL SOLO_LECTURA PREDOMINA SOBRE LOS DEMAS PERFILES ASOCIADOS
        $query1 = "SELECT PEUS_PER_ID
                                                FROM perfilesxusuario
                                                INNER JOIN perfiles
                                                ON perfilesxusuario.PEUS_PER_ID = perfiles.PER_ID
                                                WHERE
                                                perfilesxusuario.PEUS_USR_ID = '$usuario'
                                                and perfiles.solo_lectura = 1
                                                limit 1";
                                                 $res1 = $this->bd->query($query1);
        if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query1, 1);
        $row1 = mysqli_fetch_assoc($res1);
        
        //Si es solo lectura devuelve falso
        if($row1['PEUS_PER_ID']) return false;
        
        
        //busco los perfiles que tiene asociados
        $query2 = " SELECT PEUS_PER_ID
                    FROM perfilesxusuario
                    WHERE PEUS_USR_ID = '$usuario';";
        $res3 = $this->bd->query($query2);
        
        if (!$res3) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query2, 1);
      
    $string = "PEMO_".$tipo;
    
        while($row3 = mysqli_fetch_assoc($res3)){
            
//Busco para cada perfil si tiene permisos al modulo
            $query= "SELECT PEMO_$tipo
                    FROM permisosxmodulo
                    WHERE PEMO_MOD_ID = '$mod_id'
                    AND PEMO_PER_ID = $row3[PEUS_PER_ID] LIMIT 1;";
        
            $res = $this->bd->query($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            $row = mysqli_fetch_assoc($res);

            if($row[$string] == 1)return true;
        }

        return false;
    }
   
	public function GetUsers($List) {
		$List->gofirst();
        $query = "	SELECT 	usr_id,
                            id_tipousuario, 
                            cod_local, 
                            codigovendedor, 
                            rutvendedor, 
                            upper(usr_nombres) as usr_nombres, 
                            upper(usr_apellidos) as usr_apellidos,
                            usr_login, 
                            usr_clave, 
                            usr_estado,
                            usr_tipo,
                            usr_email,
                            usr_cod_pos,
							usr_dat_extras,
							impresorag
                    FROM 	usuarios 
                    WHERE 1
                    " . (($List->getelem()->usr_estado)? " and usr_estado <> '".$List->getelem()->usr_estado."' " : "") . "
                    " . (($List->getelem()->usr_tipo)? " and codigovendedor <> '0' " : "") . "
                    " . (($List->getelem()->usr_tipo)? " and codigovendedor <> '' " : "") . "
                    " . (($List->getelem()->id_tipousuario)? " and id_tipousuario in (".$List->getelem()->id_tipousuario.")" : "") . "
                    " . (($List->getelem()->usr_id)? " and usr_id = ".$List->getelem()->usr_id : "") . "
                    " . (($List->getelem()->codigovendedor)? " and codigovendedor = '".$List->getelem()->codigovendedor."' " : "") . "
                    " . (($List->getelem()->cod_local)? " and cod_local = '".$List->getelem()->cod_local."'" : "") . "
                    " . (($List->getelem()->usr_dat_extras)? " and usr_dat_extras = '".$List->getelem()->usr_dat_extras."' " : "") . "
					" . (($List->getelem()->sinasignar=='-2')? "NOT IN (SELECT codigovendedor from usuarios where id_tipousuario in (2,3))":""). "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY usr_nombres") . "
                    ";
/* 		die($query); */
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		//general::writeevent('usuarios'.$query);
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
            $User->id = 			$row['usr_id'];
            $User->id_tipousuario = $row['id_tipousuario'];                
            $User->cod_local = 		$row['cod_local'];                 
            $User->codigovendedor = $row['codigovendedor'];                 
            $User->rutvendedor = 	$row['rutvendedor']; 
            $User->usr_nombres = 	$row['usr_nombres'];                 
            $User->usr_apellidos = 	$row['usr_apellidos'];                 
            $User->login = 			$row['usr_login'];   
            $User->usr_clave = 		$row['usr_clave'];                  
            $User->usr_estado = 	$row['usr_estado'];                  
            $User->usr_tipo = 		$row['usr_tipo'];     
            $User->usr_cod_pos = 	$row['usr_cod_pos'];                                 
            $User->usr_dat_extras = $row['usr_dat_extras'];                                 
            $User->impresorag = 	$row['impresorag'];
            $User->usr_email = 		$row['usr_email'];                                 
            $List->addlast($User);
        }
        $res->free();
        return true;
    }

	public function updateusrpassword($List) {
		$List->gofirst();
        $query = "	update usuarios set usr_clave=md5('".$List->getelem()->usr_clave."') where usr_id=".$List->getelem()->usr_id;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        /*while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
            $User->id = $row['usr_id'];
            $User->id_tipousuario = $row['id_tipousuario'];                
            $User->cod_local = $row['cod_local'];                 
            $User->codigovendedor = $row['codigovendedor'];                 
            $User->rutvendedor = $row['rutvendedor']; 
            $User->usr_nombres = $row['usr_nombres'];                 
            $User->usr_apellidos = $row['usr_apellidos'];                 
            $User->login = $row['usr_login'];   
            $User->usr_clave = $row['usr_clave'];                  
            $User->usr_estado = $row['usr_estado'];                  
            $User->usr_tipo = $row['usr_tipo'];     
            $User->usr_cod_pos = $row['usr_cod_pos'];                                 
            $User->usr_dat_extras = $row['usr_dat_extras'];                                 
            $User->impresorag = $row['impresorag'];
            $User->usr_email = $row['usr_email'];                                 
            $List->addlast($User);
        }*/
        //$res->free();
        return true;
    }
    
    public function getlocalusr($List,$usr) {
        $query = "  SELECT u.usr_id,u.cod_local
                    FROM usuarios u
                    join locales loc on (loc.cod_local=u.cod_local)
                    where u.usr_id=$usr";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
            $User->usr_id = $row['usr_id'];
            $User->cod_local = $row['cod_local'];
            $List->addlast($User);
        }
        $res->free();
        return true;
    }  

    public function getcountuser($List) {
        $List->gofirst();
        $query = "	SELECT 	count(usr_id) as usr_id
        			FROM usuarios u 
                    WHERE 1
                    " . (($List->getelem()->id)? " and codigovendedor = '".$List->getelem()->id."'" : "") . "
                    ";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
            $User->id = $row['usr_id'];                                 
            $List->addlast($User);
        }
        $res->free();
        return true;
    }   
    
    public function infousuarioper($List,$usr) {
        $query = "  SELECT distinct pu.PEUS_PER_ID,
                            u.usr_id, 
                            u.usr_nombres, 
                            u.usr_apellidos, 
                            u.usr_login, 
                            loc.cod_local, 
                            loc.nom_local, 
                            u.codigovendedor,
							pe.per_nombre
                    FROM perfilesxusuario pu
                    left join usuarios u on (pu.PEUS_USR_ID=u.USR_ID)
                    left join perfiles pe on (pe.PER_ID=pu.PEUS_PER_ID)
                    left join locales loc on (loc.cod_local=u.cod_local)
                    where u.usr_id= " . ($usr+0) ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
            $User->per_id = $row['PEUS_PER_ID'];
            $User->usr_id = $row['usr_id'];                
            $User->usr_nombres= $row['usr_nombres'];
            $User->usr_apellidos = $row['usr_apellidos'];
            $User->login = $row['usr_login'];
            $User->nom_local = $row['nom_local'];
            $User->cod_local = $row['cod_local'];
            $User->codigovendedor = $row['codigovendedor'];
			$User->per_nombre = $row['per_nombre'];
            $List->addlast($User);
        }
        $res->free();
        return true;
    }
   
    public function getmenu($username, $List) {
        $query = "	SELECT DISTINCT 
                        m.mod_id, 
                        m.mod_nombre, 
                        m.mod_url
                    FROM modulos m
                    JOIN permisosxmodulo xm on m.mod_id = xm.pemo_mod_id
                    JOIN perfilesxusuario xu on xu.peus_per_id = xm.pemo_per_id
                    JOIN usuarios u on xu.peus_usr_id = u.usr_id
                    WHERE m.mod_estado = 1
                        AND mod_padre_id is null
                        AND usr_login = '$username'
                    ORDER by m.mod_orden";

     // die($query);

        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        while ($row = $res->fetch_assoc()){
            $User = new dtomenu;
            $User->mod_id =$row['mod_id'];
            $User->mod_nombre =$row['mod_nombre'];
            $User->mod_url =$row['mod_url'];
            $User->ListHijo = new connlist;
            $this->getmenuhijo($row['mod_id'], $username, $User->ListHijo);
            $List->addlast($User);
        }
        $res->free();
        return true;
	}
                
    public function getmenuhijo($idmenu, $username, $List) {
        $query= "	SELECT DISTINCT 
                        m.mod_id, 
                        m.mod_nombre, 
                        m.mod_url
                    FROM modulos m
                    JOIN permisosxmodulo xm on m.mod_id = xm.pemo_mod_id
                    JOIN perfilesxusuario xu on xu.peus_per_id = xm.pemo_per_id
                    JOIN usuarios u on xu.peus_usr_id = u.usr_id
                    WHERE m.mod_estado = 1
                        AND mod_padre_id = $idmenu
                        AND usr_login = '$username'
                    ORDER by m.mod_orden";

 // print_r("Menu Hijo:".$query);


        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        while ($row = $res->fetch_assoc()){
            $User = new dtomenu;
            $User->mod_id =$row['mod_id'];
            $User->mod_nombre =$row['mod_nombre'];
            $User->mod_url =$row['mod_url'];
            $List->addlast($User);
        }
        $res->free();
        return true;
	}
 
    public function existemodulouser($username, $modulo) {
        $query= "	SELECT DISTINCT m.mod_url
                    FROM modulos m
                    JOIN permisosxmodulo xm on m.mod_id = xm.pemo_mod_id
                    JOIN perfilesxusuario xu on xu.peus_per_id = xm.pemo_per_id
                    JOIN usuarios u on xu.peus_usr_id = u.usr_id
                    WHERE m.mod_estado = 1 AND usr_login = '$username'";
        $res = $this->bd->query($query);
        //general::writeevent('consulta usuario'.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $retorno = false;
        /*
        while ($row = $res->fetch_assoc()) {
            if (trim($modulo) == trim($row['mod_url'])) {
                $retorno = true;
            }
        }*/
        if($res !== false){
        	while($row = mysqli_fetch_assoc($res)){
	            if (trim($modulo) == trim($row['mod_url'])) {
	                $retorno = true;
	            }
        	}
    	}
    	
        $res->free();
        return $retorno;
	}
  
    public function tienepermisodefuncionalidad($funcionalidad_nombre) 
    {
      global $ses_usr_id; 
      // Obtengo los ID de los perfiles del usuario logeado
      $res = $this->bd->query("select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id);      
      if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), "select peus_per_id as perfil_id from perfilesxusuario where peus_usr_id=".$ses_usr_id, 1);
      $strPerfilesIDs='(';
      while ($row = $res->fetch_assoc()){
        $strPerfilesIDs.=$row['perfil_id'].',';     
      }
      $strPerfilesIDs.='-999)';    
      
      $query= "select funcionalidades.nombre as nombre from funcionalidades, perfilesxfuncionalidad where perfilesxfuncionalidad.funcionalidad_id=funcionalidades.id and perfilesxfuncionalidad.perfil_id in $strPerfilesIDs";
      $res = $this->bd->query($query);
      if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
      
      $retorno = false;
      if($res !== false)
      {
      	while($row = mysqli_fetch_assoc($res))
        {
            if (trim($funcionalidad_nombre) == trim($row['nombre'])) 
            {
                $retorno = true;
            }
      	}
      }    	
      $res->free();
      return $retorno;
	  }   
// valida solo el usuario y no la password
	// active directory
    public function usuariovalido($username) {
    
        $query= "	SELECT	usr_id
                    FROM	usuarios 
                    WHERE	usr_login = '$username'
                        AND	usr_estado <> 2 and usr_estado <> 0";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		
    	if($res !== false){
        	while($row = mysqli_fetch_assoc($res)){
				$this->grabaloginusuario($row['usr_id']);
				return ($row['usr_id'] + 0);
			}
		}
		/*
		if ($row = $res->fetch_assoc()) {
            $this->grabaloginusuario($row['usr_id']);
            return ($row['usr_id'] + 0);
        }*/
        $res->free();
        return false;
	}
	
	public function usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo) {
		
           file_put_contents('Listusuariovalidoimp.txt', $idmodulo);


        $query= "	SELECT	usr_id,usr_nombres,usr_apellidos FROM  usuarios join permisosxmodulo
                    WHERE	PEMO_PER_ID=usr_id
                      AND PEMO_MOD_ID='".$idmodulo."'
                      AND usr_login = '".$usuariolis.
                      "' AND usr_clave = md5('".$clavelist."')
                        AND	usr_estado <> 2";

        file_put_contents('usuariomodulovalido.txt', $query);

        $res = $this->bd->query($query);
        $Listusuariovalidoimp->clearlist();
        while ($row = $res->fetch_assoc()){
            $User = new dtousuario;
           	$User->id				= $row['usr_id'];
            $User->usr_nombres		= $row['usr_nombres'];
            $User->usr_apellidos 	= $row['usr_apellidos'];
            $Listusuariovalidoimp->addlast($User);
        }
        $res->free();
        return true;
	}

    public function ipusuariovalida($idusuario, $ip) {
        $query= "	SELECT 	usr_id, 
                            u.cod_local cod_localu, 
                            i.cod_local cod_locali,
                            i.ip
                    FROM 	usuarios u
                    LEFT JOIN iplocal i on i.cod_local = u.cod_local
                    WHERE 	usr_id = $idusuario";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $retorno = false;
        while (($row = $res->fetch_assoc()) && !$retorno) {
            if (!$row['cod_localu'])
                $retorno = true;
            if (trim($row['ip']) == trim(substr($ip, 0, strlen(trim($row['ip'])))))
                $retorno = true;
        }
        $res->free();
        return $retorno;
	}
	
	
	public function getTipoUsuarioCotiza($idusuario) {
        $query= "	SELECT 	u.id_tipousuario
                    FROM 	usuarios u
                    WHERE 	usr_id = $idusuario";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
		if ($row = $res->fetch_assoc()) {
			   return ($row['id_tipousuario'] + 0);
        }
        
        $res->free();
        return false;
	}
	
	
    public function grabaloginusuario($user_id) {
    	global $ses_usr_login;
    	
    	$query= "	UPDATE 	usuarios 
                    SET 	USR_ULT_LOGIN = now()
                            , USR_EST_LOGIN = 1 
                        	, usr_usr_mod = '".$ses_usr_login."' 
                        	, usr_fec_mod = now() 
                    WHERE 	usr_id = " . ($user_id+0) ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
	}

    public function grabaimpresorausuario($Impresoraf, $Impresorag) {
    	global $ses_usr_login, $ses_usr_id;
    	
        $query= "	UPDATE 	usuarios 
                    SET 	usr_usr_mod = '".$ses_usr_login."' 
							" . (($Impresoraf !== null)?", usr_dat_extras = '$Impresoraf'":"" ) . "
							" . (($Impresorag !== null)?", impresorag = '$Impresorag'":"" ) . "
                        	, usr_fec_mod = now() 
                    WHERE 	usr_id = " . ($ses_usr_id+0) ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
	}

    public function nombresDenombreParecido($list){
            $list->gofirst();
            $uname = $list->getelem()->usr_nombres;
            if( !($uname == '') ){
                $query = "SELECT usr_login,
                                usr_apellidos,
                                usr_nombres
                            FROM usuarios
                            WHERE ( (usr_nombres LIKE '%".$uname."%') OR (usr_apellidos LIKE '%".$uname."%') )
                            ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC";
            }else{
                $query = "SELECT usr_login,
                                usr_apellidos,
                                usr_nombres
                            FROM usuarios
                            ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC";
            }
            $res = $this->bd->query($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            
            $list->clearlist();
            while ($row = $res->fetch_assoc()){
                $Est = new dtousuario();
                $Est->login =  $row['usr_login'];
                $Est->usr_apellidos = $row['usr_apellidos'];
                $Est->usr_nombres = $row['usr_nombres'];
                $list->addlast($Est);
            }
                $res->free();
                return TRUE;
        }
        
        public function reporteUsuariosPorPerfiles($list){
            $list->gofirst();
            $query = "SELECT x.PEUS_PER_ID, x.PEUS_USR_ID, "
                    . "x.PEUS_USR_CREA, "
                    . "x.PEUS_FEC_CREA, x.PEUS_USR_MOD, x.PEUS_FEC_MOD "
                    . "FROM perfilesxusuario x";

            $res = $this->bd->query($query);
            if (!$res){throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);}
            
            $list->clearlist();
            while ($row = $res->fetch_assoc()){
                $list->addlast($row);
            }
                $res->free();
                return TRUE;
                
        }

        public function reporteDeUsuarios($list){
            $list->gofirst();
            $uname = $list->getelem()->login;
            if($uname == 'todos'){
                $condicion = ' ';
            }else{
                $condicion = " WHERE usr_login='".$uname."' ";
            }
            $query = "SELECT usr_nombres, 
                            usr_apellidos, 
                            cod_local,
                            usr_login,
                            codigovendedor,
                            usr_fec_crea,
                            usr_ult_login ,
                            PER_NOMBRE,
                            PER_DESCRIPCION ,
                            mod_descripcion 
                        FROM usuarios
                            INNER JOIN perfilesxusuario on usr_id=PEUS_USR_ID
                            INNER JOIN perfiles on PEUS_PER_ID=PER_ID
                            INNER JOIN permisosxmodulo ON permisosxmodulo.PEMO_PER_ID = perfiles.PER_ID
                            INNER JOIN modulos ON modulos.mod_id = permisosxmodulo.pemo_mod_id".$condicion."
                                ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC, PER_NOMBRE ASC, PER_DESCRIPCION ASC, mod_descripcion ASC";
            
            $res = $this->bd->query($query);
            if (!$res){throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);}
            
            $list->clearlist();
            while ($row = $res->fetch_assoc()){
                $Est = new dtousuario();
                $Est->login =  $row['usr_login'];
                $Est->usr_apellidos = $row['usr_apellidos'];
                $Est->usr_nombres = $row['usr_nombres'];
                $Est->cod_local = $row['cod_local'];
                $Est->codigovendedor = $row['codigovendedor'];
                $Est->fecha_creacion = date("d/m/Y H:i:s", strtotime($row['usr_fec_crea']) );
                $Est->ult_login = date("d/m/Y H:i:s", strtotime($row['usr_ult_login']) );
                $Est->nombre_perfil = $row['PER_NOMBRE'];
                $Est->descripcion_perfil = $row['PER_DESCRIPCION'];
                $Est->modulo = $row['mod_descripcion'];
                $list->addlast($Est);
            }
                $res->free();
                return TRUE;
                
        }

        public function nombresDeLoginParecido($list){
            $list->gofirst();
            $uname = $list->getelem()->login;
            if( !($uname == '') ){
                $query = "SELECT usr_login,
                                usr_apellidos,
                                usr_nombres
                            FROM usuarios
                            WHERE usr_login LIKE '%".$uname."%'
                            ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC";
            }else{
                $query = "SELECT usr_login,
                                usr_apellidos,
                                usr_nombres
                            FROM usuarios
                            ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC";
            }
            $res = $this->bd->query($query);
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            
            $list->clearlist();
            while ($row = $res->fetch_assoc()){
                $Est = new dtousuario();
                $Est->login =  $row['usr_login'];
                $Est->usr_apellidos = $row['usr_apellidos'];
                $Est->usr_nombres = $row['usr_nombres'];
                $list->addlast($Est);
            }
                $res->free();
                return TRUE;
        }

        public function reporteDeUsuariosEx($list){
            $list->gofirst();
            $uname = $list->getelem()->login;
            
            $filename = "reporteUsuariosPorPerfiles";
            if($uname == 'todos'){
                $condicion = ' ';
                $filename .= "TodosLosUsuarios";
            }else{
                $condicion = " WHERE usr_login='".$uname."' ";
                $filename .= "Usuario".$uname;
            }
            $filename .= ".xls";
            
            $fp = "Nombres\tApellidos\tCod. local\tLogin\tCod. vendedor\tFecha creación\tÚltimo login\tPerfil\tDescripción\tMódulos\n";

            $fp = utf8_decode($fp);
            
            $query = "SELECT usr_nombres, 
                            usr_apellidos, 
                            cod_local,
                            usr_login,
                            codigovendedor,
                            usr_fec_crea,
                            usr_ult_login ,
                            PER_NOMBRE,
                            PER_DESCRIPCION ,
                            mod_descripcion 
                        FROM usuarios
                            INNER JOIN perfilesxusuario on usr_id=PEUS_USR_ID
                            INNER JOIN perfiles on PEUS_PER_ID=PER_ID
                            INNER JOIN permisosxmodulo ON permisosxmodulo.PEMO_PER_ID = perfiles.PER_ID
                            INNER JOIN modulos ON modulos.mod_id = permisosxmodulo.pemo_mod_id".$condicion."
                                ORDER BY usr_apellidos ASC, usr_nombres, usr_id ASC, PER_NOMBRE ASC, PER_DESCRIPCION ASC, mod_descripcion ASC";
            
            $res = $this->bd->query($query);  
            if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
            
            
            while ($row = $res->fetch_assoc()){
                $fp .= $row['usr_nombres']."\t";
                $fp .= $row['usr_apellidos']."\t";
                $fp .= $row['cod_local']."\t";
                $fp .= $row['usr_login']."\t";
                $fp .= $row['codigovendedor']."\t";
                $fp .= date("d.m.Y H:i:s", strtotime($row['usr_fec_crea']) )."\t";
                $fp .= date("d.m.Y H:i:s", strtotime($row['usr_ult_login']) )."\t";
                $fp .= $row['PER_NOMBRE']."\t";
                $fp .= $row['PER_DESCRIPCION']."\t";
                $fp .= sinSaltos( $row['mod_descripcion'] )."\t";
                $fp .= "\n";
            }
                header( 'Content-Type: application/vnd.ms-excel' );
        header("Content-Length: ".strlen($fp));
        header( 'Content-Disposition: attachment;filename='.$filename);

        echo $fp;
        $res->free();
        }
}

function sinSaltos($param) {
            return str_replace( "\r", " ", ( str_replace("\n", " ", $param) ) );
        }

?>
