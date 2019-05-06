<?
class daoinfocliente{
    /*** atributos ***/
    private $bd = NULL; 

    /*** constructor ***/
    public function __construct(){
        $this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
    public function initrx(){
        $res = $this->bd->querynoselect("SET AUTOCOMMIT=0");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
    }

    public function rollback(){
        $res = $this->bd->querynoselect("ROLLBACK");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $this->bd->querynoselect("SET AUTOCOMMIT=1");
        return true;
    }

    public function commit(){
        $res = $this->bd->querynoselect("COMMIT");
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $this->bd->querynoselect("SET AUTOCOMMIT=1");
        return true;
    }
    //Cambio de prueba infocliente.
    public function getCliente($List){
        $List->gofirst();
                //Mantis 30518: Deshabilitacion boton de generacion de cotizacion
                // Se agrega el campo c.feccrea
        $query = "  SELECT  c.rut,
                            c.rete_iva,
                            c.rete_ica,
                            c.rete_renta,
                            c.id_comuna as localizacion,
                            m.id_comuna,
                            m.descripcion nomcomuna,
                            d.id_ciudad,
                            d.descripcion nomciudad,
                            r.id_rubro,
                            r.descripcion nomrubro,
                            t.id_tipocliente,
                            t.descripcion nomtipcliente,
                            g.id_tipodocpago,
                            g.descripcion nomtipdocpago,
                            c.codigovendedor,
                            concat(u.USR_NOMBRES, ' ', u.USR_APELLIDOS) vendedor,
                            c.razonsoc,
                            c.id_giro,
                            f.descripcion as giro,
                            c.contacto,
                            c.fonocontacto,
                            c.email,
                            c.direccion,
                            c.bloqueo1 locksap,
                            c.bloqueo2 lockmoro,
                            c.bloqueo3 lockcve,
                            if(c.valdisp<now(), true, false) lockfecha,
                            c.valdisp,
                            c.diascondicion,
                            c.codclisap,
                            c.comentario,
                            c.codlocaluco,
                            l.nom_local nomlocaluco,
                            c.fechauco,
                            tc.id_tipoconpago,
                            tc.descripcion as diascondicion,
                            c.diascondicion as  numdiaspago,
                            c.id_contribuyente,
                            tct.descripcion as tipocontri,
                            cp.nombre_pref,cp.id_clientepref,
                            c.id_documento_identidad,
                            c.id_clasificacion_cli,
                            c.apellido,
                            c.apellido1,
                            c.celcontactoe,
                            c.fax,
                            c.id_regimencontri,
                            c.genero,
                            c.id_profesion,
                            c.feccrea
                                                        
                    FROM cliente c
                    LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                    LEFT JOIN tipogiro f on f.id_giro = c.id_giro
                    LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                    LEFT JOIN usuarios u on (u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2 and u.codigovendedor <> '')
                    LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                    LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                    LEFT JOIN locales l on l.cod_local = c.codlocaluco
                    LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago
                    LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                    LEFT JOIN cliente_preferente cp on cp.id_clientepref = c.id_clientepref
                    LEFT JOIN tipocontribuyente tct on tct.id_contribuyente = c.id_contribuyente
                    WHERE 1
                    " . (($List->getelem()->razonsoc)? " and  c.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "
                    " . (($List->getelem()->id_contribuyente)? " and c.id_contribuyente = ".$List->getelem()->id_contribuyente : "") . "
                    " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                    " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                    " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                    " . (($List->getelem()->sinasignar=='-2')? "NOT IN (SELECT codigovendedor from usuarios where id_tipousuario in (2,3))":""). "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1") . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                    ";
/*      
        $query1 = " SELECT COUNT(*) cont
                    FROM    cliente c
                    LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                    LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                    LEFT JOIN usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
                    LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                    LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                    LEFT JOIN locales l on l.cod_local = c.codlocaluco 
                    LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago 
                    LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                    WHERE   1 
                    " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                    " . (($List->getelem()->codigovendedor)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": null) . "
                    " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                    " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                    ";
        $res1 = $this->bd->query($query1);
        if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query1, 1);
        $row1 = $res1->fetch_assoc();
        $total_encontrado       =   $row1['cont'];*/
        //general::writeevent('consulta inf ven'.$query);
        $total_encontrado               =       $List->getelem()->limite;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->rut              =   $row['rut'];
            $Registro->id_comuna        =   $row['localizacion'];
            $Registro->nomcomuna        =   $row['nomcomuna'];
            $Registro->id_ciudad        =   $row['id_ciudad'];
            $Registro->nomciudad        =   $row['nomciudad'];
            $Registro->id_rubro         =   $row['id_rubro'];
            $Registro->nomrubro         =   $row['nomrubro'];
            $Registro->id_tipocliente   =   $row['id_tipocliente'];
            //$Registro->nomtipcliente  =   $row['nomtipcliente'];
            $Registro->id_tipodocpago   =   $row['id_tipodocpago'];
            $Registro->nomtipdocpago    =   $row['nomtipdocpago'];
            $Registro->codigovendedor   =   $row['codigovendedor'];
            $Registro->diascondicion    =   $row['diascondicion'];
            $Registro->vendedor         =   $row['vendedor'];
            $Registro->razonsoc         =   $row['razonsoc'];
            $Registro->id_giro          =   $row['id_giro'];
            $Registro->giro             =   $row['giro'];
            $Registro->contacto         =   $row['contacto'];
            $Registro->fonocontacto     =   $row['fonocontacto']; 
            $Registro->email            =   $row['email'];
            $Registro->direccion        =   $row['direccion'];
            $Registro->locksap          =   (($row['id_tipocliente']==1)?$row['locksap']:false); //Sólo si el cliente SAP
            $Registro->lockmoro         =   (($row['id_tipocliente']==1)?$row['lockmoro']:false); //Sólo si el cliente SAP
            $Registro->lockcve          =   $row['lockcve'];
            $Registro->lockfecha        =   (($row['id_tipocliente']==1)?$row['lockfecha']:false); //Sólo si el cliente SAP
            $Registro->valdisp          =   $row['valdisp'];
            $Registro->codclisap        =   $row['codclisap'];
            $Registro->comentario       =   $row['comentario'];
            $Registro->codlocaluco      =   $row['codlocaluco'];
            $Registro->nomlocaluco      =   $row['nomlocaluco'];
            $Registro->fechauco         =   $row['fechauco'];
            $Registro->diascondicion    =   $row['diascondicion'];            
            $Registro->id_tipoconpago   =   $row['id_tipoconpago'];             
            $Registro->numdiaspago      =   $row['numdiaspago'];    
            $Registro->total_encontrado =   $total_encontrado;         
            $Registro->nomtipcliente    =   $row['nombre_pref'];
            $Registro->id_contribuyente =   $row['id_contribuyente'];             
            $Registro->rete_iva     =   $row['rete_iva'];
            $Registro->rete_ica     =   $row['rete_ica'];
            $Registro->rete_renta   =   $row['rete_renta'];
            $Registro->id_documento_identidad   =   $row['id_documento_identidad'];
            $Registro->id_clasificacion_cli     =   $row['id_clasificacion_cli'];
            $Registro->apellido         =   $row['apellido'];
            $Registro->apellido1        =   $row['apellido1'];
            $Registro->celcontactoe     =   $row['celcontactoe']; 
            $Registro->fax              =   $row['fax']; 
            $Registro->id_regimencontri =   $row['id_regimencontri'];
            $Registro->genero           =   $row['genero'];
            $Registro->direccionservicio = $row['tipocontri']; 
            $Registro->id_profesion = $row['id_profesion'];          
            $Registro->feccrea = $row['feccrea'];//Mantis 30518: Deshabilitacion boton de generacion de cotizacion          
            
            $List->addlast($Registro);
        }
            //Mantis 30518: Deshabilitacion boton de generacion de cotizacion Inicio
            $query_fchalimite = "SELECT fchalimite FROM fechalimite";
            $res_fchalimite = $this->bd->query($query_fchalimite);
            if (!$res_fchalimite) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query_fchalimite, 1);
            while ($row_limite = $res_fchalimite->fetch_assoc()){
                $Registro->fchalimite = $row_limite['fchalimite'];          
                $List->addlast($Registro);
            }
            //Mantis 30518: Deshabilitacion boton de generacion de cotizacion Fin
        $res->free();
        return true;
    }

    public function getClienteRepor($List){
        $List->gofirst();
        $query = "  SELECT  c.rut,
                            c.rete_iva,
                            c.rete_ica,
                            c.rete_renta,
                            c.id_comuna as localizacion,
                            m.id_comuna,
                            m.descripcion nomcomuna,
                            d.id_ciudad,
                            d.descripcion nomciudad,
                            r.id_rubro,
                            r.descripcion nomrubro,
                            t.id_tipocliente,
                            t.descripcion nomtipcliente,
                            g.id_tipodocpago,
                            g.descripcion nomtipdocpago,
                            c.codigovendedor,
                            concat(u.USR_NOMBRES, ' ', u.USR_APELLIDOS, ' (',if(u.cod_local is null,'NO ASIGNADO',u.cod_local), ')') vendedor,
                            c.razonsoc,
                            c.id_giro,
                            f.descripcion as giro,
                            c.contacto,
                            c.fonocontacto,
                            c.email,
                            c.direccion,
                            c.bloqueo1 locksap,
                            c.bloqueo2 lockmoro,
                            c.bloqueo3 lockcve,
                            if(c.valdisp<now(), true, false) lockfecha,
                            c.valdisp,
                            c.diascondicion,
                            c.codclisap,
                            c.comentario,
                            c.codlocaluco,
                            l.nom_local nomlocaluco,
                            c.fechauco,
                            tc.id_tipoconpago,
                            tc.descripcion as diascondicion,
                            c.diascondicion as  numdiaspago,
                            c.id_contribuyente,
                            tct.descripcion as tipocontri,
                            cp.nombre_pref,cp.id_clientepref,
                            c.id_documento_identidad,
                            c.id_clasificacion_cli,
                            c.apellido,
                            c.apellido1,
                            c.celcontactoe,
                            c.fax,
                            c.id_regimencontri,
                            c.genero
                    FROM cliente c
                    LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                    LEFT JOIN tipogiro f on f.id_giro = c.id_giro
                    LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                    LEFT JOIN usuarios u on (u.codigovendedor = c.codigovendedor and u.codigovendedor<>'')
                    LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                    LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                    LEFT JOIN locales l on l.cod_local = c.codlocaluco
                    LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago
                    LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                    LEFT JOIN cliente_preferente cp on cp.id_clientepref = c.id_clientepref
                    LEFT JOIN tipocontribuyente tct on tct.id_contribuyente = c.id_contribuyente
                    WHERE 1
                    " . (($List->getelem()->razonsoc)? " and  c.razonsoc like '%".$List->getelem()->razonsoc."%'" : "") . "
                    " . (($List->getelem()->id_contribuyente)? " and c.id_contribuyente = ".$List->getelem()->id_contribuyente : "") . "
                    " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                    " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                    " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                    " . (($List->getelem()->sinasignar=='-2')? "NOT IN (SELECT codigovendedor from usuarios where id_tipousuario in (2,3))":""). "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1") . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                    ";

        //general::writeevent('consulta inf ven'.$query);
        $total_encontrado               =       $List->getelem()->limite;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->rut              =   $row['rut'];
            $Registro->id_comuna        =   $row['localizacion'];
            $Registro->nomcomuna        =   $row['nomcomuna'];
            $Registro->id_ciudad        =   $row['id_ciudad'];
            $Registro->nomciudad        =   $row['nomciudad'];
            $Registro->id_rubro         =   $row['id_rubro'];
            $Registro->nomrubro         =   $row['nomrubro'];
            $Registro->id_tipocliente   =   $row['id_tipocliente'];
            //$Registro->nomtipcliente  =   $row['nomtipcliente'];
            $Registro->id_tipodocpago   =   $row['id_tipodocpago'];
            $Registro->nomtipdocpago    =   $row['nomtipdocpago'];
            $Registro->codigovendedor   =   $row['codigovendedor'];
            $Registro->diascondicion    =   $row['diascondicion'];
            $Registro->vendedor         =   $row['vendedor'];
            $Registro->razonsoc         =   $row['razonsoc'];
            $Registro->id_giro          =   $row['id_giro'];
            $Registro->giro             =   $row['giro'];
            $Registro->contacto         =   $row['contacto'];
            $Registro->fonocontacto     =   $row['fonocontacto']; 
            $Registro->email            =   $row['email'];
            $Registro->direccion        =   $row['direccion'];
            $Registro->locksap          =   (($row['id_tipocliente']==1)?$row['locksap']:false); //Sólo si el cliente SAP
            $Registro->lockmoro         =   (($row['id_tipocliente']==1)?$row['lockmoro']:false); //Sólo si el cliente SAP
            $Registro->lockcve          =   $row['lockcve'];
            $Registro->lockfecha        =   (($row['id_tipocliente']==1)?$row['lockfecha']:false); //Sólo si el cliente SAP
            $Registro->valdisp          =   $row['valdisp'];
            $Registro->codclisap        =   $row['codclisap'];
            $Registro->comentario       =   $row['comentario'];
            $Registro->codlocaluco      =   $row['codlocaluco'];
            $Registro->nomlocaluco      =   $row['nomlocaluco'];
            $Registro->fechauco         =   $row['fechauco'];
            $Registro->diascondicion    =   $row['diascondicion'];            
            $Registro->id_tipoconpago   =   $row['id_tipoconpago'];             
            $Registro->numdiaspago      =   $row['numdiaspago'];    
            $Registro->total_encontrado =   $total_encontrado;         
            $Registro->nomtipcliente    =   $row['nombre_pref'];
            $Registro->id_contribuyente =   $row['id_contribuyente'];             
            $Registro->rete_iva     =   $row['rete_iva'];
            $Registro->rete_ica     =   $row['rete_ica'];
            $Registro->rete_renta   =   $row['rete_renta'];
            $Registro->id_documento_identidad   =   $row['id_documento_identidad'];
            $Registro->id_clasificacion_cli     =   $row['id_clasificacion_cli'];
            $Registro->apellido         =   $row['apellido'];
            $Registro->apellido1        =   $row['apellido1'];
            $Registro->celcontactoe     =   $row['celcontactoe']; 
            $Registro->fax              =   $row['fax']; 
            $Registro->id_regimencontri =   $row['id_regimencontri'];
            $Registro->genero           =   $row['genero'];
            $Registro->direccionservicio = $row['tipocontri'];           
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getClienteReporExcel($List){
        $List->gofirst();
      $query = "select c.razonsoc as razonsoc, c.rut as rut, t.descripcion as id_tipocliente, c.codigovendedor as codigovendedor, (SELECT concat(usr_apellidos,'  ',usr_nombres) FROM usuarios where codigovendedor = c.codigovendedor limit 1) as vendedor,c.contacto  as contacto,c.fonocontacto as fonocontacto,c.email    as email,c.direccion as direccion,c.usrcrea as usuario_creacion,c.feccrea as fecha_creacion,c.usrmod as usuario_modificacion,c.fecmod as fecha_modificacion,c.celcontactoe as celular_contacto,c.fax  as fax,prof.descripcion as profesion,c.id_contribuyente  as id_contribuyente, ac.descripcion  as contribuyente from cliente c inner join tipocliente t inner join tipocontribuyente ac inner join cu_profesion prof where c.id_tipocliente = t.id_tipocliente and c.id_contribuyente = ac.id_contribuyente and prof.id = c.id_profesion";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;          
            $Registro->razonsoc         =   $row['razonsoc'];
            $Registro->rut              =   $row['rut'];
            $Registro->id_tipocliente           =   $row['id_tipocliente'];
            $Registro->codigovendedor           =   $row['codigovendedor'];
            $Registro->vendedor         =   $row['vendedor'];
            $Registro->contacto         =   $row['contacto'];
            $Registro->fonocontacto         =   $row['fonocontacto'];
            $Registro->email            =   $row['email'];
            $Registro->direccion            =   $row['direccion'];
            $Registro->usrcrea          =   $row['usuario_creacion'];
            $Registro->feccrea          =   $row['fecha_creacion'];
            $Registro->usrmod           =   $row['usuario_modificacion'];
            $Registro->fecmod           =   $row['fecha_modificacion'];
            $Registro->celcontactoe         =   $row['celular_contacto'];
            $Registro->fax          =   $row['fax'];
            $Registro->profesion            =   $row['profesion'];
            $Registro->id_contribuyente         =   $row['id_contribuyente'];             
            $Registro->contribuyente            =   $row['contribuyente'];
         
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }    
    
    public function gettipojur($rut, $List){
        $query = "SELECT c.id_contribuyente
                  FROM cliente c
                  WHERE c.rut = $rut";
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        $List->clearlist();
        While($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->id_contribuyente = $row['id_contribuyente'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    
    public function getMonitorCliente($List){
        $List->gofirst();
        $query = "  SELECT  c.rut,
                            c.codigovendedor,
                            concat(u.USR_NOMBRES, ' ', u.USR_APELLIDOS) vendedor,
                            c.razonsoc,
                            c.codlocaluco,
                            l.nom_local nomlocaluco,
                            c.fechauco,
                            cp.nombre_pref,cp.id_clientepref
                    FROM cliente c
                    LEFT JOIN usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
                    LEFT JOIN locales l on l.cod_local = c.codlocaluco 
                    LEFT JOIN cliente_preferente cp on cp.id_clientepref = c.id_clientepref
                    WHERE 1
                    " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                    " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->sinasignar=='-2')? "NOT IN (SELECT codigovendedor from usuarios where id_tipousuario in (2,3))":""). "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1") . "
                    " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                    ";

        $total_encontrado               =       $List->getelem()->limite;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->rut              =   $row['rut'];
            $Registro->codigovendedor   =   $row['codigovendedor'];
            $Registro->vendedor         =   $row['vendedor'];
            $Registro->razonsoc         =   $row['razonsoc'];
            $Registro->codlocaluco      =   $row['codlocaluco'];
            $Registro->nomlocaluco      =   $row['nomlocaluco'];
            $Registro->fechauco         =   $row['fechauco'];
            $Registro->total_encontrado =   $total_encontrado;         
            $Registro->nomtipcliente    =   $row['nombre_pref'];             
            $Registro->id_clientepref   =   $row['id_clientepref'];             
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    /*Valida Usuario para Reimpresion OP GD*/
    /*public function usuariomodulovalido($Listusuariovalidoimp,$usuariolis,$clavelist,$idmodulo) {

        $query= "   SELECT  usr_id,usr_nombres,usr_apellidos FROM  usuarios join permisosxmodulo
                    WHERE   PEMO_PER_ID=usr_id
                    AND PEMO_MOD_ID='".$idmodulo."'
                    AND usr_login = '".$usuariolis."' 
                    AND usr_clave = md5('".$clavelist."')
                    AND usr_estado <> 2";

        $res = $this->bd->query($query); 

        $Listusuariovalidoimp->clearlist();

        while ($row = $res->fetch_assoc()){

            $User = new dtousuario;
            $User->id               = $row['usr_id'];
            $User->usr_nombres      = $row['usr_nombres'];
            $User->usr_apellidos    = $row['usr_apellidos'];
            $Listusuariovalidoimp->addlast($User);

        }

        $res->free();

        return true;

    }*/

    
    /*Fin Valida Usuario para Reimpresion OP GD*/
    
    public function getRegistro($List){
        $List->gofirst();
        $query = "  SELECT  c.rut,
                            m.id_comuna,
                            m.descripcion nomcomuna,
                            d.id_ciudad,
                            d.descripcion nomciudad,
                            r.id_rubro,
                            r.descripcion nomrubro,
                            t.id_tipocliente,
                            t.descripcion nomtipcliente,
                            g.id_tipodocpago,
                            g.descripcion nomtipdocpago,
                            c.codigovendedor,
                            concat(u.USR_NOMBRES, ' ', u.USR_APELLIDOS) vendedor,
                            c.razonsoc,
                            c.id_giro,
                            c.giro,
                            c.contacto,
                            c.fonocontacto,
                            c.email,
                            c.direccion,
                            c.bloqueo1 locksap,
                            c.bloqueo2 lockmoro,
                            c.bloqueo3 lockcve,
                            if(c.valdisp<now(), true, false) lockfecha,
                            c.valdisp,
                            c.codclisap,
                            c.comentario,
                            c.codlocaluco,
                            l.nom_local nomlocaluco,
                            c.fechauco,
                            tc.id_tipoconpago,
                            tc.descripcion as diascondicion,
                            c.diascondicion as  numdiaspago,
                            cp.nombre_pref,cp.id_clientepref
                    FROM cliente c
                    LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                    LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                    LEFT JOIN usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
                    LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                    LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                    LEFT JOIN locales l on l.cod_local = c.codlocaluco 
                    LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago 
                    LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                    LEFT JOIN cliente_preferente cp on cp.id_clientepref = c.id_clientepref
                    WHERE 1
                    " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                    " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                    " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                    " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                    " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                    " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                    " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1") . "
                    ";
        
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->rut              =   $row['rut'];
            $Registro->id_comuna        =   $row['id_comuna'];
            $Registro->nomcomuna        =   $row['nomcomuna'];
            $Registro->id_ciudad        =   $row['id_ciudad'];
            $Registro->nomciudad        =   $row['nomciudad'];
            $Registro->id_rubro         =   $row['id_rubro'];
            $Registro->nomrubro         =   $row['nomrubro'];
            $Registro->id_tipocliente   =   $row['id_tipocliente'];
           //$Registro->nomtipcliente   =   $row['nomtipcliente'];
            $Registro->id_tipodocpago   =   $row['id_tipodocpago'];
            $Registro->nomtipdocpago    =   $row['nomtipdocpago'];
            $Registro->codigovendedor   =   $row['codigovendedor'];
            $Registro->vendedor         =   $row['vendedor'];
            $Registro->razonsoc         =   $row['razonsoc'];
            $Registro->id_giro          =   $row['id_giro'];
            $Registro->giro             =   $row['giro'];
            $Registro->contacto         =   $row['contacto'];
            $Registro->fonocontacto     =   $row['fonocontacto'];
            $Registro->email            =   $row['email'];
            $Registro->direccion        =   $row['direccion'];
            $Registro->locksap          =   (($row['id_tipocliente']==1)?$row['locksap']:false); //Sólo si el cliente SAP
            $Registro->lockmoro         =   (($row['id_tipocliente']==1)?$row['lockmoro']:false); //Sólo si el cliente SAP
            $Registro->lockcve          =   $row['lockcve'];
            $Registro->lockfecha        =   (($row['id_tipocliente']==1)?$row['lockfecha']:false); //Sólo si el cliente SAP
            $Registro->valdisp          =   $row['valdisp'];
            $Registro->codclisap        =   $row['codclisap'];
            $Registro->comentario       =   $row['comentario'];
            $Registro->codlocaluco      =   $row['codlocaluco'];
            $Registro->nomlocaluco      =   $row['nomlocaluco'];
            $Registro->fechauco         =   $row['fechauco'];
            $Registro->diascondicion    =   $row['diascondicion'];            
            $Registro->id_tipoconpago   =   $row['id_tipoconpago'];             
            $Registro->numdiaspago      =   $row['numdiaspago'];    
            $Registro->nomtipcliente    =   $row['nombre_pref'];             
            $Registro->id_clientepref   =   $row['id_clientepref'];             
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
        
    public function getdatosbasicos($List){
            $List->gofirst();
         $query = " SELECT  c.rut,
                                m.id_comuna,
                                m.descripcion nomcomuna,
                                d.id_ciudad,
                                d.descripcion nomciudad,
                                r.id_rubro,
                                r.descripcion nomrubro,
                                t.id_tipocliente,
                                t.descripcion nomtipcliente,
                                g.id_tipodocpago,
                                g.descripcion nomtipdocpago,
                                c.codigovendedor,
                                concat(u.USR_NOMBRES, ' ', u.USR_APELLIDOS) vendedor,
                                c.razonsoc,
                                c.id_giro,
                                c.giro,
                                c.contacto,
                                c.fonocontacto,
                                c.email,
                                c.direccion,
                                c.bloqueo1 locksap,
                                c.bloqueo2 lockmoro,
                                c.bloqueo3 lockcve,
                                if(c.valdisp<now(), true, false) lockfecha,
                                c.valdisp,
                                c.codclisap,
                                c.comentario,
                                c.codlocaluco,
                                l.nom_local nomlocaluco,
                                c.fechauco,
                                tc.id_tipoconpago,
                                tc.descripcion as diascondicion,
                                c.diascondicion as  numdiaspago,
                                cp.nombre_pref,cp.id_clientepref
                        FROM cliente c
                        LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                        LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                        LEFT JOIN usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
                        LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                        LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                        LEFT JOIN locales l on l.cod_local = c.codlocaluco 
                        LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago 
                        LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                        LEFT JOIN cliente_preferente cp on cp.id_clientepref = c.id_clientepref
                        WHERE 1
                        " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                        " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                        " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                        " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                        " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                        " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                        " . (($List->getelem()->orderby)? " ORDER BY ".$List->getelem()->orderby : "ORDER BY 1") . "
                        " . (($List->getelem()->limite)? " LIMIT ".$List->getelem()->limite : "") . "
                        ";
/*         
                  $query1 = "   SELECT COUNT(*) cont
                        FROM cliente c
                        LEFT JOIN comuna m on m.id_comuna = c.id_comuna
                        LEFT JOIN ciudad d on d.id_ciudad = m.id_ciudad
                        LEFT JOIN usuarios u on u.codigovendedor = c.codigovendedor and u.id_tipousuario = 2
                        LEFT JOIN rubro r on r.id_rubro = c.id_rubro
                        LEFT JOIN tipocliente t on t.id_tipocliente = c.id_tipocliente
                        LEFT JOIN locales l on l.cod_local = c.codlocaluco 
                        LEFT JOIN tipodocpago g on g.id_tipodocpago = c.id_tipodocpago 
                        LEFT JOIN tipocondicionpago tc on (tc.id_tipoconpago=c.diascondicion)
                        WHERE 1
                        " . (($List->getelem()->rut)? " and c.rut = ".$List->getelem()->rut : "") . "
                        " . (($List->getelem()->codigovendedor!==null)? " and c.codigovendedor = '".$List->getelem()->codigovendedor ."'": "") . "
                        " . (($List->getelem()->codlocaluco)? " and c.codlocaluco = '".$List->getelem()->codlocaluco."'" : "") . "
                        " . (($List->getelem()->fechaucofini)? " and c.fechauco >= '".$List->getelem()->fechaucofini."'" : "") . "
                        " . (($List->getelem()->fechaucoffin)? " and c.fechauco <= '".$List->getelem()->fechaucoffin."'" : "") . "
                        " . (($List->getelem()->id_rubro)? " and r.id_rubro = '".$List->getelem()->id_rubro."'" : "") . "
                        " . (($List->getelem()->id_tipocliente)? " and t.id_tipocliente = '".$List->getelem()->id_tipocliente."'" : "") . "
                        ";
                
                $res1 = $this->bd->query($query1);
                if (!$res1) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query1, 1);
                $row1 = $res1->fetch_assoc();
                $total_encontrado       =   $row1['cont'];*/
                    $total_encontrado               =       $List->getelem()->limite;
                $res = $this->bd->query($query);
                if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
                $List->clearlist();
                $i = 1;
                while ($row = $res->fetch_assoc()){
                    $Registro = new dtoinfocliente;
                    $Registro->rut              =   $row['rut'];
                    $Registro->id_comuna        =   $row['id_comuna'];
                    $Registro->id_rubro         =   $row['id_rubro'];
                    $Registro->nomrubro         =   $row['nomrubro'];
                    $Registro->id_tipocliente   =   $row['id_tipocliente'];
                    //$Registro->nomtipcliente  =   $row['nomtipcliente'];
                    $Registro->id_tipodocpago   =   $row['id_tipodocpago'];
                    $Registro->nomtipdocpago    =   $row['nomtipdocpago'];
                    $Registro->codigovendedor   =   $row['codigovendedor'];
                    $Registro->vendedor         =   $row['vendedor'];
                    $Registro->razonsoc         =   $row['razonsoc'];
                    $Registro->id_giro          =   $row['id_giro'];
                    $Registro->giro             =   $row['giro'];
                    $Registro->contacto         =   $row['contacto'];
                    $Registro->fonocontacto     =   $row['fonocontacto'];
                    $Registro->email            =   $row['email'];
                    $Registro->direccion        =   $row['direccion'];
                    $Registro->locksap          =   (($row['id_tipocliente']==1)?$row['locksap']:false); //Sólo si el cliente SAP
                    $Registro->lockmoro         =   (($row['id_tipocliente']==1)?$row['lockmoro']:false); //Sólo si el cliente SAP
                    $Registro->lockcve          =   $row['lockcve'];
                    $Registro->lockfecha        =   (($row['id_tipocliente']==1)?$row['lockfecha']:false); //Sólo si el cliente SAP
                    $Registro->valdisp          =   $row['valdisp'];
                    $Registro->codclisap        =   $row['codclisap'];
                    $Registro->comentario       =   $row['comentario'];
                    $Registro->codlocaluco      =   $row['codlocaluco'];
                    $Registro->nomlocaluco      =   $row['nomlocaluco'];
                    $Registro->fechauco         =   $row['fechauco'];
                    $Registro->diascondicion    =   $row['diascondicion'];            
                    $Registro->id_tipoconpago   =   $row['id_tipoconpago'];             
                    $Registro->numdiaspago      =   $row['numdiaspago'];    
                    $Registro->total_encontrado =   $total_encontrado;      
                    $Registro->nomtipcliente    =   $row['nombre_pref'];             
                    $Registro->id_clientepref   =   $row['id_clientepref'];                 
                    $List->addlast($Registro);
                    if(!$Registro->rut||!$Registro->razonsoc||!$Registro->contacto||!$Registro->fonocontacto||!$Registro->direccion||!$Registro->id_comuna||!$Registro->giro||!$Registro->id_rubro||!$Registro->email){
                        $Registro->registro = 0; 
                    }elseif($Registro->rut && !$Registro->razonsoc||!$Registro->contacto||!$Registro->fonocontacto||!$Registro->direccion||!$Registro->id_comuna||!$Registro->giro||!$Registro->id_rubro||!$Registro->email){
                        $Registro->registro = 1; 
                    }elseif($Registro->rut && $Registro->razonsoc && $Registro->contacto && $Registro->fonocontacto && $Registro->direccion && $Registro->id_comuna && $Registro->giro && $Registro->id_rubro && $Registro->email){
                        $Registro->registro = 2;                
                    }
                }
            $res->free();
            return true;
    }

    public function existecliente($List){
        $List->gofirst();
        $query = "  SELECT  count(*) cuenta
                    FROM cliente
                    WHERE rut = " . ($List->getelem()->rut + 0) ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        if ($row = $res->fetch_assoc()){
            return ($row['cuenta'] && true);
        }
        $res->free();
        return false;
    }

    public function insertcliente($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  INSERT INTO cliente (   
                        rut,
                        id_comuna, 
                        id_rubro, 
                        id_tipocliente, 
                        id_tipodocpago, 
                        codigovendedor, 
                        razonsoc, 
                        id_giro, 
                        giro, 
                        contacto, 
                        fonocontacto, 
                        email, 
                        direccion, 
                        bloqueo1, 
                        bloqueo2, 
                        bloqueo3, 
                        valdisp, 
                        codclisap, 
                        comentario, 
                        codlocaluco, 
                        fechauco, 
                        usrcrea, 
                        feccrea, 
                        usrmod, 
                        fecmod,
                        id_clientepref,
                        apellido,
                        apellido1,
                        id_documento_identidad,
                        id_clasificacion_cli,
                        celcontactoe,
                        fax,
                        id_contribuyente,
                        id_regimencontri,
                        rete_iva,
                        rete_ica,
                        rete_renta,
                        genero,
                        id_profesion
                        
                    )
                    VALUES (
                        ".$List->getelem()->rut.",
                            ".(($List->getelem()->id_comuna)?$List->getelem()->id_comuna:"null").",
                            ".(($List->getelem()->id_rubro)?$List->getelem()->id_rubro:"null").",
                            2,
                            ".(($List->getelem()->id_tipodocpago)?$List->getelem()->id_tipodocpago:2).",
                            '".$List->getelem()->codigovendedor."',
                            upper('".addslashes($List->getelem()->razonsoc)."'),
                            ".(($List->getelem()->id_giro)?"'".$List->getelem()->id_giro."'":"null").",
                            ".(($List->getelem()->giro!==null)?"upper('".addslashes($List->getelem()->giro)."')":"null").",
                            upper('".addslashes($List->getelem()->contacto)."'),
                            '".$List->getelem()->fonocontacto."',
                            ".(($List->getelem()->email!==null)?"upper('".$List->getelem()->email."')":"null").",
                            ".(($List->getelem()->direccion!==null)?"upper('".addslashes($List->getelem()->direccion)."')":"null").",
                            ".($List->getelem()->locksap + 0).",
                            ".($List->getelem()->lockmoro + 0).",
                            ".($List->getelem()->lockcve + 0).",
                            ".(($List->getelem()->valdisp)?"'".$List->getelem()->valdisp."'":"null").",
                            ".(($List->getelem()->codclisap)?"'".$List->getelem()->codclisap."'":"null").",
                            ".(($List->getelem()->comentario!==null)?"upper('".$List->getelem()->comentario."')":"null").",
                            '".$List->getelem()->codlocaluco."',
                            now(), 
                            '".$ses_usr_login."',
                            now(),
                            '".$ses_usr_login."',
                            now(),
                            ".(($List->getelem()->id_clientepref)?$List->getelem()->id_clientepref:2).",
                            ".(($List->getelem()->apellido)?"upper('".$List->getelem()->apellido."')":"''").",
                            ".(($List->getelem()->apellido1)?"upper('".$List->getelem()->apellido1."')":"''").",
                            ".(($List->getelem()->id_documento_identidad)?"'".$List->getelem()->id_documento_identidad."'":"0").",
                            ".(($List->getelem()->id_clasificacion_cli)?"'".$List->getelem()->id_clasificacion_cli."'":"3").",
                            ".(($List->getelem()->celcontactoe)?"'".$List->getelem()->celcontactoe."'":"''").",
                            ".(($List->getelem()->fax)?"'".$List->getelem()->fax."'":"''").",
                            ".(($List->getelem()->id_contribuyente)?"'".$List->getelem()->id_contribuyente."'":"0").",
                            ".(($List->getelem()->id_regimencontri)?"'".$List->getelem()->id_regimencontri."'":"0").",
                            ".(($List->getelem()->rete_iva)?"".$List->getelem()->rete_iva."":"0").",
                            ".(($List->getelem()->rete_ica)?"".$List->getelem()->rete_ica."":"0").",
                            ".(($List->getelem()->rete_renta)?"".$List->getelem()->rete_renta."":"0").",
                            ".(($List->getelem()->genero)?"upper('".$List->getelem()->genero."')":"''").",
                            ".(($List->getelem()->id_profesion)?"'".$List->getelem()->id_profesion."'":"'1'")."
                    )";
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        return true;
    }
    
    public function putclientesap($List){
        $List->gofirst();
        $ctrlcom = new ctrltipos();
        
        /*******busco ciudad******/
        $ctrlcom->getciudad($ListCiu = new connlist(new dtocomuna(array('nomciudad'=>$List->getelem()->nomciudad))));
        $ListCiu->gofirst();
        if (!$ListCiu->numelem()){
            $ctrlcom->setciudad($ListCiu = new connlist(new dtocomuna(array('nomciudad'=>$List->getelem()->nomciudad,
                                                                            'usrcrea'=>$List->getelem()->usrcrea,
                                                                            'usrmod'=>$List->getelem()->usrcrea
                                                                            ))));
            $ctrlcom->getciudad($ListCiu = new connlist(new dtocomuna(array('nomciudad'=>$List->getelem()->nomciudad))));
            $ListCiu->gofirst();
        }
        
        /****** busco region*******/
        $ctrlcom->getregion($ListReg = new connlist(new dtocomuna(array('id_region'=>$List->getelem()->id_region))));
        $ListReg->gofirst();
        if (!$ListReg->numelem()){
            $ctrlcom->setregion($ListReg = new connlist(new dtocomuna(array('nomregion'=>$List->getelem()->nomregion,
                                                                            'id_region'=>$List->getelem()->id_region,
                                                                            'usrcrea'=>$List->getelem()->usrcrea,
                                                                            'usrmod'=>$List->getelem()->usrcrea
                                                                            ))));
            $ctrlcom->getregion($ListReg = new connlist(new dtocomuna(array('id_region'=>$List->getelem()->id_region))));
            $ListReg->gofirst();
        }
        /****** busco comuna*******/
        $ctrlcom->getcomuna($ListCom = new connlist(new dtocomuna(array('nomcomuna'=>$List->getelem()->nomcomuna))));
        $ListCom->gofirst();
        
        if (!$ListCom->numelem()){
            $ctrlcom->setcomuna($ListReg = new connlist(new dtocomuna(array('nomcomuna'=>$List->getelem()->nomcomuna,
                                                                            'id_ciudad'=>$ListCiu->getelem()->id_ciudad,
                                                                            'id_region'=>$ListReg->getelem()->id_region,
                                                                            'usrcrea'=>$List->getelem()->usrcrea,
                                                                            'usrmod'=>$List->getelem()->usrcrea
                                                                            ))));
            $ctrlcom->getcomuna($ListCom = new connlist(new dtocomuna(array('nomcomuna'=>$List->getelem()->nomcomuna))));
            $ListCom->gofirst();                                                            
        }
        /****** busco giro*******/
        
        $ctrlcom->getgiro($listagiro = new connlist(new dtotipo(array('id'=>$List->getelem()->id_giro))));
        $listagiro->gofirst();
                
        if(!$listagiro->numelem()){
            $ctrlcom->setgiro($listag =  new connlist(new dtotipos(array('id'=>$List->getelem()->id_giro,
                                                                         'nombre'=>$List->getelem()->giro,
                                                                         'usrcrea'=>$List->getelem()->usrcrea,
                                                                         'usrmod'=>$List->getelem()->usrcrea
                                                                         ))));
                        }
                        
        $query = "  INSERT INTO cliente (   
                        rut,
                        id_comuna, 
                        id_rubro, 
                        id_tipocliente, 
                        id_tipodocpago, 
                        codigovendedor, 
                        razonsoc, 
                        id_giro, 
                        giro, 
                        contacto, 
                        fonocontacto, 
                        email, 
                        direccion, 
                        bloqueo1, 
                        bloqueo2, 
                        bloqueo3, 
                        valdisp, 
                        comentario, 
                        usrcrea, 
                        feccrea, 
                        usrmod, 
                        fecmod,
                        codclisap,
                        diascondicion,
                        id_clientepref                          
                    )
                    VALUES (
                            ".($List->getelem()->rut + 0).",
                            ".(($List->getelem()->id_comuna)?$List->getelem()->id_comuna : "null").",
                            ".(($List->getelem()->id_rubro)?$List->getelem()->id_rubro : "null").",
                            ".($List->getelem()->id_tipocliente + 0).",
                            ".(($List->getelem()->id_tipodocpago)?$List->getelem()->id_tipodocpago:1).",       
                            ".(($List->getelem()->codigovendedor)?"'".$List->getelem()->codigovendedor."'" : "null").",
                            ".(($List->getelem()->razonsoc)?"'".addslashes($List->getelem()->razonsoc)."'" : "null").",
                            ".(($List->getelem()->id_giro)?"'".$List->getelem()->id_giro."'" : "null").",
                            ".(($List->getelem()->giro)?"'".addslashes($List->getelem()->giro)."'" : "null").",
                            ".(($List->getelem()->contacto)?"'".addslashes($List->getelem()->contacto)."'" : "null").",
                            ".(($List->getelem()->fonocontacto)?"'".$List->getelem()->fonocontacto."'" : "null").",
                            ".(($List->getelem()->email)?"'".$List->getelem()->email."'" : "null").",
                            ".(($List->getelem()->direccion)?"'".addslashes($List->getelem()->direccion)."'" : "null").",
                            ".($List->getelem()->locksap + 0).",
                            ".($List->getelem()->lockmoro + 0).",
                            ".($List->getelem()->lockcve + 0).",
                            ".(($List->getelem()->valdisp)?$List->getelem()->valdisp : "null").",
                            ".(($List->getelem()->comentario)?$List->getelem()->comentario : "null").",
                            '".$ses_usr_login."',
                            now(),
                            '".$ses_usr_login."',
                            now(),
                            ".(($List->getelem()->codclisap)?"'".$List->getelem()->codclisap."'" : "null").",
                            ".($List->getelem()->diascondicion+0)." ,
                            ".(($List->getelem()->id_clientepref)?$List->getelem()->id_clientepref:2)."
                            )";
                            //".(($List->getelem()->diascondicion+0)?"'".$List->getelem()->codclisap."'" : "null")." 
        
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        $this->deldisponible($List);       
        
        $this->setdisponible($ListDis = new connlist(new dtodisponible(array('id_tipomovimiento'=>1,
                                                                             'rut'=>$List->getelem()->rut,
                                                                             'monto'=>$List->getelem()->disponible,
                                                                             'usrcrea'=>$List->getelem()->usrcrea,
                                                                             'usrmod'=>$List->getelem()->usrcrea
                                                                             ))));
        
        return true;
    }
    //".  (($List->getelem()->razonsoc)?", razonsoc = '".addslashes($List->getelem()->razonsoc)."'" : ", razonsoc=null"). "
    //" . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) ."'": "") . "
    public function modifyclientesap($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  UPDATE cliente 
                    SET usrcrea = '".$List->getelem()->usrcrea."'
                    " . (($List->getelem()->id_comuna)? ", id_comuna = ". $List->getelem()->id_comuna : ", id_comuna=null") . "
                    " . (($List->getelem()->id_rubro)? ", id_rubro = ". $List->getelem()->id_rubro : "") . "
                    " . (($List->getelem()->id_tipocliente)? ", id_tipocliente = ".$List->getelem()->id_tipocliente : "") . "
                    " . (($List->getelem()->id_tipodocpago)? ", id_tipodocpago = ".$List->getelem()->id_tipodocpago : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'" : ", codigovendedor=null") . "
                    " . (($List->getelem()->razonsoc)? ", razonsoc = '". addslashes($List->getelem()->razonsoc) ."'": ", razonsoc=null") . "
                    " . (($List->getelem()->id_giro)? ", id_giro = '". addslashes($List->getelem()->id_giro) ."'": ", id_giro=null") . "
                    " . (($List->getelem()->giro)? ", giro = '". addslashes($List->getelem()->giro) ."'": ", giro=null") . "
                    " . (($List->getelem()->contacto)? ", contacto = '". addslashes($List->getelem()->contacto) ."'": ", contacto=null") . "
                    " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto ."'": ", fonocontacto=null") . "
                    " . (($List->getelem()->email)? ", email = '". $List->getelem()->email ."'": ", email=null") . "
                    " . (($List->getelem()->direccion)? ", direccion = '". addslashes($List->getelem()->direccion) ."'": ", direccion=null") . "
                    " . (($List->getelem()->locksap!==null)? ", bloqueo1 = ". $List->getelem()->locksap : "") . "
                    " . (($List->getelem()->lockmoro!==null)? ", bloqueo2 = ". $List->getelem()->lockmoro : "") . "
                    " . (($List->getelem()->valdisp)? ", valdisp = '".$List->getelem()->valdisp."'" :"") . "
                    " . (($List->getelem()->comentario)? ", comentario = '". $List->getelem()->comentario ."'": ", comentario=null") . "
                    " . (($List->getelem()->codclisap)? ", codclisap = '". $List->getelem()->codclisap ."'": "") . "
                    " . (($List->getelem()->diascondicion)? ",diascondicion = ".$List->getelem()->diascondicion : "")."
                    " . (($List->getelem()->id_clientepref)? ",id_clientepref = ".$List->getelem()->id_clientepref : "")."
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    WHERE rut = ".$List->getelem()->rut ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $this->deldisponible($List);       
        
        $this->setdisponible($ListDis = new connlist(new dtodisponible(array('id_tipomovimiento'=>1,
                                                                             'rut'=>$List->getelem()->rut,
                                                                             'monto'=>$List->getelem()->disponible,
                                                                             'usrcrea'=>$List->getelem()->usrcrea,
                                                                             'usrmod'=>$List->getelem()->usrcrea
                                                                             ))));
        return true;
    }
    
    public function modifycliente($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  UPDATE cliente 
                    SET usrcrea = usrcrea
                    " . (($List->getelem()->id_comuna)? ", id_comuna = ". $List->getelem()->id_comuna : "") . "
                    " . (($List->getelem()->id_rubro)? ", id_rubro = ". $List->getelem()->id_rubro : ", id_rubro = null") . "
                    " . (($List->getelem()->id_tipodocpago)? ", id_tipodocpago = ".$List->getelem()->id_tipodocpago : "") . "
                    " . (($List->getelem()->codigovendedor!==null)? ", codigovendedor = '". $List->getelem()->codigovendedor ."'": "") . "
                    " . (($List->getelem()->razonsoc!==null)? ", razonsoc = upper('". addslashes($List->getelem()->razonsoc) ."')": "") . "
                    " . (($List->getelem()->id_giro)? ", id_giro = '". addslashes($List->getelem()->id_giro) ."'": "") . "
                    " . (($List->getelem()->giro!==null)? ", giro = upper('". addslashes($List->getelem()->giro) ."')": "") . "
                    " . (($List->getelem()->contacto!==null)? ", contacto = upper('". addslashes($List->getelem()->contacto) ."')": "") . "
                    " . (($List->getelem()->fonocontacto!==null)? ", fonocontacto = '". $List->getelem()->fonocontacto ."'": "") . "
                    " . (($List->getelem()->email!==null)? ", email = upper('". $List->getelem()->email ."')": "") . "
                    " . (($List->getelem()->direccion!==null)? ", direccion = upper('". addslashes($List->getelem()->direccion) ."')": "")/* . "
                    " . (($List->getelem()->codlocaluco)? ", codlocaluco = '". $List->getelem()->codlocaluco."'" : ""). "
                    "*/ . (($List->getelem()->fechauco)? ", fechauco = now()" : ""). "
                    " . (($List->getelem()->comentario!==null)? ", comentario = upper('". $List->getelem()->comentario ."')": "") . "
                    " . (($List->getelem()->lockcve!==null)? ", bloqueo3 = ". $List->getelem()->lockcve : "") . "
                    " . (($List->getelem()->id_clientepref)? ",id_clientepref = ".$List->getelem()->id_clientepref : "")."
                    " . (($List->getelem()->id_documento_identidad)? ",id_documento_identidad = ".$List->getelem()->id_documento_identidad : "")."
                    " . (($List->getelem()->id_clasificacion_cli)? ",id_clasificacion_cli = ".$List->getelem()->id_clasificacion_cli : "")."
                    " . (($List->getelem()->apellido)? ",apellido = upper('".$List->getelem()->apellido."')" : "")."
                    " . (($List->getelem()->apellido1)? ",apellido1 = upper('".$List->getelem()->apellido1."')" : "")."
                    " . (($List->getelem()->celcontactoe)? ",celcontactoe = '".$List->getelem()->celcontactoe."'" : "")."
                    " . (($List->getelem()->fax)? ",fax = '".$List->getelem()->fax."'" : "")."
                    " . (($List->getelem()->id_regimencontri)? ",id_regimencontri = '".$List->getelem()->id_regimencontri."'" : "")."
                    " . (($List->getelem()->accionupdate && $List->getelem()->id_contribuyente)? ",id_contribuyente = '".$List->getelem()->id_contribuyente."'" : "")."
                    " . (($List->getelem()->rete_iva)? ",rete_iva = ".$List->getelem()->rete_iva."" : "")."
                    " . (($List->getelem()->rete_ica)? ",rete_ica = ".$List->getelem()->rete_ica."" : "")."
                    " . (($List->getelem()->rete_renta)? ",rete_renta = ".$List->getelem()->rete_renta."" : "")."
                    " . (($List->getelem()->genero)? ",genero = upper('".$List->getelem()->genero."')" : "")."
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    " . (($List->getelem()->id_profesion)? ",id_profesion = '".$List->getelem()->id_profesion."'" : "")."
                    WHERE rut = ".$List->getelem()->rut ;
        //general::writeevent($List->getelem()->id_profesion);
        //general::writeevent($query."IvA".$List->getelem()->rete_iva."ICA".$List->getelem()->rete_ica."RENTA".$List->getelem()->rete_renta);
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        return true;
    }

    public function getdirdesp($List){
        $List->gofirst();
        $query = "  SELECT
                        d.id_direccion,
                        d.id_comuna,
                        cd.descripcion as nomcomuna,
                        d.rut,
                        d.descripcion,
                        d.direccion,
                        d.contacto,
                        d.fonocontacto,
                        d.email,
                        d.comentario,
                        d.tipo_dir,
                        upper(ciu.descripcion) as nomciudad
                    FROM direccion d
                    LEFT join comuna cd on (cd.id_comuna=d.id_comuna)
                    LEFT join ciudad ciu on (cd.id_ciudad=ciu.id_ciudad)
                    WHERE 1
                    " . (($List->getelem()->id_direccion)? " and id_direccion = ".$List->getelem()->id_direccion : "") . "
                    " . (($List->getelem()->rut)? " and rut = ".$List->getelem()->rut : "") . "
                    ";


/*$query = "    SELECT
                        d.id_direccion,
                        d.id_comuna,
                        cd.descripcion as nomcomuna,
                        d.rut,
                        d.descripcion,
                        d.direccion,
                        d.contacto,
                        d.fonocontacto,
                        d.email,
                        d.comentario
                    FROM direccion d
                    LEFT join comunad cd on (cd.id_comuna=d.id_comuna)
                    WHERE  rut = " . (($List->getelem()->rut)?$List->getelem()->rut : ""). "";*/
        
        $res = $this->bd->query($query);
        //general::writeevent(''.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodireccion;
            $Registro->id_direccion     =   $row['id_direccion'];
            $Registro->id_comuna        =   $row['id_comuna'];
            $Registro->nomcomuna        =   $row['nomcomuna'];
            $Registro->id_ciudad        =   $row['id_ciudad'];
            $Registro->nomciudad        =   $row['nomciudad'];
            $Registro->rut              =   $row['rut'];
            $Registro->descripcion      =   $row['descripcion'];
            $Registro->direccion        =   $row['direccion'];
            $Registro->contacto         =   $row['contacto'];
            $Registro->fonocontacto     =   $row['fonocontacto'];
            $Registro->email            =   $row['email'];
            $Registro->comentario       =   $row['comentario'];
            $Registro->tipo_dir         =   $row['tipo_dir'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }

    public function getdirdespicking($List){
        
        $List->gofirst();
        $query = "  SELECT id_dirdespacho FROM cotizacion_e cot
              where id_cotizacion =
                    (SELECT id_cotizacion FROM ordenpicking_e join ordenent_e using(id_ordenent)
                    where id_ordenpicking=".$List->getelem()->id_direccion.")";
                    
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtodireccion;
            $Registro->id_direccion     =   $row['id_dirdespacho'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
    }
    public function existedirdesp($List){
        $List->gofirst();
        $query = "  SELECT  count(*) cuenta
                    FROM direccion
                    WHERE id_direccion = " . ($List->getelem()->id_direccion + 0) ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        if ($row = $res->fetch_assoc()){
            return ($row['cuenta'] && true);
        }
        $res->free();
        return false;
    }

    public function insertdirdesp($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  INSERT INTO direccion ( 
                        id_direccion,
                        id_comuna,
                        rut,
                        descripcion,
                        direccion,
                        contacto,
                        fonocontacto,
                        email,
                        comentario,
                        usrcrea, 
                        feccrea, 
                        usrmod, 
                        fecmod,
                        tipo_dir    
                    )
                    VALUES (
                        null,
                        ".(($List->getelem()->id_comuna)?$List->getelem()->id_comuna:"null").",
                        ".($List->getelem()->rut+0).",
                        upper('".$List->getelem()->descripcion."'),
                        upper('".addslashes($List->getelem()->direccion)."'),
                        upper('".addslashes($List->getelem()->contacto)."'),
                        '".$List->getelem()->fonocontacto."',
                        upper('".$List->getelem()->email."'),
                        upper('".$List->getelem()->comentario."'),
                        '".$ses_usr_login."',
                        now(),
                        '".$ses_usr_login."',
                        now(),
                        1)";
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        $List->getelem()->id_direccion = $this->bd->last_insert_id();
        return true;
    }
    
    public function modifydirdesp($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  UPDATE direccion 
                    SET usrcrea = usrcrea
                    " . (($List->getelem()->id_comuna)? ", id_comuna = ". $List->getelem()->id_comuna : "") . "
                    " . (($List->getelem()->rut)? ", rut = ". $List->getelem()->rut : "") . "
                    " . (($List->getelem()->descripcion)? ", descripcion = upper('". $List->getelem()->descripcion ."')": "") . "
                    " . (($List->getelem()->direccion)? ", direccion = upper('". addslashes($List->getelem()->direccion) ."')": "") . "
                    " . (($List->getelem()->contacto)? ", contacto = upper('". addslashes($List->getelem()->contacto) ."')": "") . "
                    " . (($List->getelem()->fonocontacto)? ", fonocontacto = '". $List->getelem()->fonocontacto ."'": "") . "
                    " . (($List->getelem()->email)? ", email = upper('". $List->getelem()->email ."')": "") . "
                    " . (($List->getelem()->comentario)? ", comentario = upper('". $List->getelem()->comentario ."')": "") . "
                    " . (($List->getelem()->tipo_dir)? ", tipo_dir = '". $List->getelem()->tipo_dir ."'": "") . "
                    , usrmod = '".$ses_usr_login."' 
                    , fecmod = now()
                    WHERE id_direccion = ".$List->getelem()->id_direccion ;
        //general::writeevent('xxx'.$query);
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        return true;
    }

    public function deletedirdesp($List){
        global $ses_usr_login;
        $List->gofirst();
        $query = "  DELETE FROM direccion 
                    WHERE id_direccion = ".$List->getelem()->id_direccion ;
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        return true;
    }

    public function getdisponible($List){
        
        $List->gofirst();
        $this->getcliente($List = new connlist(new dtoinfocliente(array('rut' => $List->getelem()->rut))));
        
        $List->gofirst();
        
        $query = "  SELECT sum(case when id_tipomovimiento = 1 then monto when id_tipomovimiento = 2 then monto*-1 end) disp 
                    FROM disponible
                    WHERE rut = " . ($List->getelem()->rut+0) ;
        $res = $this->bd->query($query);
      
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        if ($List->getelem()->id_tipocliente == 1 || $List->getelem()->id_tipocliente == 2) {
            if ($row = $res->fetch_assoc()){
                return ($row['disp'] + 0);
            }
            else{
                return 0;
            }
        }
        $res->free();
        return 0;
    }
    public function setdisponible($List){
        $List->gofirst();
        $query = "  INSERT INTO disponible (    
                        id_linea,
                        id_tipomovimiento,
                        rut,
                        monto,
                        id_ordenent,
                        usrcrea, 
                        feccrea, 
                        usrmod, 
                        fecmod,
                        indmsgsap   
                    )
                    VALUES (
                            null,
                            '".$List->getelem()->id_tipomovimiento."',
                            '".$List->getelem()->rut."',
                            '".$List->getelem()->monto."',
                            ".($List->getelem()->id_ordenent+0).",
                            '".$List->getelem()->usrcrea."',
                            now(),
                            '".$List->getelem()->usrmod."',
                            now(),
                            ".($List->getelem()->indmsgsap+0).")";
                           
        $res = $this->bd->query($query);
      
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);    
        return true;                    
    }
    
    private function deldisponible($List){
        $List->gofirst();
        $query = "  DELETE FROM disponible 
                    WHERE rut = ". ($List->getelem()->rut + 0) ."
                        and (indmsgsap = 1 or id_tipomovimiento = 1)";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        return true;
    }
   
    public function marcasapdisponible($List){
        $List->gofirst();
        $query = "  UPDATE disponible 
                    SET indmsgsap = 1 
                    WHERE id_documento = ". ($List->getelem()->id_documento + 0) ."";
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        return true;
    }
   
    public function putcargo($ListDoc){
        global $ses_usr_login;

        $ListDoc->gofirst();
        if ($ListDoc->numelem()!=1){
            throw new CTRLException("Número incorrecto de elementos", 0);
        }
        if (!$ListDoc->getelem()->id_ordenent){
            throw new CTRLException("No viene id de orden de entrega", 0);
        }
        if (!$ListDoc->getelem()->rutcliente){
            throw new CTRLException("No viene rut de cliente", 0);
        }
        if (!$ListDoc->getelem()->monto){
            throw new CTRLException("No viene monto a cargar", 0);
        }
        
        $ListDoc->gofirst();
        $query = "  INSERT INTO disponible (id_tipomovimiento,
                                            rut,
                                            monto,
                                            id_ordenent,
                                            id_documento,
                                            usrcrea, 
                                            feccrea, 
                                            usrmod, 
                                            fecmod  
                                            )
                    VALUES (                2,
                                            ".$ListDoc->getelem()->rutcliente.",
                                            ".$ListDoc->getelem()->monto.",
                                            ".($ListDoc->getelem()->id_ordenent+0).",
                                            ".$ListDoc->getelem()->id_documento.",
                                            '".$ses_usr_login."',
                                            now(),
                                            '".$ses_usr_login."',
                                            now())";
        
        $res = $this->bd->querynoselect($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }

    public function ordenentcargo($id_ordenent){
        $query = "  SELECT  count(*) cuenta
                    FROM disponible
                    WHERE id_ordenent = " . ($id_ordenent+0) ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        if ($row = $res->fetch_assoc()){
            return ($row['cuenta'] && true);
        }
        $res->free();
        return false;
    }
    
    public function buscadisponible($List){
        $List->gofirst();
        $query="SELECT id_linea, rut, monto, id_ordenent
        FROM disponible 
        WHERE 1 
        and id_documento=0 
        and rut = " . ($List->getelem()->rutcliente+0)."
        and id_ordenent=".($List->getelem()->id_ordenent+0);
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $List->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoinfocliente;
            $Registro->id_linea         =   $row['id_linea'];
            $Registro->monto            =   $row['monto'];
            $Registro->rut              =   $row['rut'];            
            $Registro->id_ordenent      =   $row['id_ordenent'];
            $List->addlast($Registro);
        }
        $res->free();
        return true;
        
        
    }
    
    public function modificadisponible($List){
        $List->gofirst();
        global $ses_usr_login;
        $List->gofirst();
        $query = "  UPDATE disponible 
                    SET monto = ".$List->getelem()->monto."
                    where id_linea = ".$List->getelem()->id_linea ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }   
     
    public function eliminadisponible($List){
        $List->gofirst();
        global $ses_usr_login;
        $List->gofirst();
        $query = "  DELETE FROM disponible 
                    WHERE id_linea = ".$List->getelem()->id_linea ;
        $res = $this->bd->query($query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        return true;
    }
    
    
    
}

?>
