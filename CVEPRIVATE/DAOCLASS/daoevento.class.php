<?
class daoevento{
	/*** atributos ***/
	private $bd = NULL; 

	/*** constructor ***/
    public function __construct(){
		$this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
	    
    public function setevento($tipo_id_evento = NULL, $nombre_objeto = NULL, $ip = NULL,
        $tipo_objeto = NULL, $descripcion_objeto = NULL, $estado_anterior = NULL, $estado_posterior = NULL, $usuario_accion = NULL) {


        // Query que inserta los datos en la base de datos.

        $query = "  INSERT INTO evento(idSubTipoEvento,fecha,tipoObjeto,ipOrigen,objeto,descripcion,estadoAnterior,estadoPosterior,usuario) 
        VALUES ('".$tipo_id_evento."',NOW(),'".$nombre_objeto."','".$ip."','".$tipo_objeto."','".$descripcion_objeto."',
            '".$estado_anterior."','".$estado_posterior."','".$usuario_accion."')";

        $res = $this->bd->query($query);

        //general::writeevent('locales '.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        /*$List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Loc = new dtolocal;
            $Loc->nom_local	= $row['nom_local'];
            $Loc->cod_local	= $row['cod_local']; 
            $Loc->cod_local_selected	= $row['cod_local_selected'];  	 								
            $Loc->dir_local	= $row['dir_local']; 
            $Loc->ip_local	= $row['ip_local']; 
            $Loc->plaza	= $row['plaza']; 
            $Loc->ofventa	= $row['ofventa']; 
            $Loc->foliofct	= $row['foliofct'];				
            $Loc->foliogde	= $row['foliogde'];
            $Loc->cod_local_pos = $row['cod_local_pos'];
            $Loc->id_localizacion = $row['id_localizacion'];
            $Loc->almacen_cod = $row['almacen_cod']; 
            $Loc->oneeasy = $row['oneeasy'];
            $List->addlast($Loc);
        }
        $res->free();*/
        return true;
    }

        public function getevento($List) {  
        $List->gofirst();       
        $id = $List->getelem()->id_evento;
        $feini = $List->getelem()->feini;
        $fefin = $List->getelem()->fefin;
        $filtroTipoEvento = "";
        if( !($id == 0) ){
                $filtroTipoEvento = " AND (tipoevento.idTipoEvento = ".$id.")";
        }
        $filtro_tipo_evento = "".$filtro_tipo_evento."";  

        $feini = "'".$feini." 00:00:00"."'";
        $fefin = "'".$fefin." 23:59:59"."'";

        $filtroFecha = '';
        $filtroFecha2 = '';
        if($List->getelem()->feini){
            $filtroFecha .= " AND evento.fecha >= " . $feini;
            $filtroFecha2 .= " AND evento_historico.fecha >= " . $feini;
        }
        if($List->getelem()->fefin){
            $filtroFecha .= " AND evento.fecha <= " . $fefin;
            $filtroFecha2 .= " AND evento_historico.fecha <= " . $fefin;
        }
        
        
        $query = "SELECT RESULT.* FROM(
            SELECT evento.idEvento as id_evento, 
                            subtipoevento.nombre as 'tipo_evento', 
                            evento.fecha as Fecha,
                            evento.tipoObjeto,
                            evento.ipOrigen as ip_cliente,
                            evento.objeto as nombre_objeto,
                            evento.descripcion as descripcion,
                            evento.estadoAnterior as estado_anterior,
                            evento.estadoPosterior as estado_posterior,
                            evento.usuario as usuario
                        FROM evento
                        inner join subtipoevento
                        on evento.idSubTipoEvento = subtipoevento.idSubTipoEvento
                        inner join tipoevento
                        on subtipoevento.idTipoEvento = tipoevento.idTipoEvento
                        where (1 ".$filtroFecha.$filtroTipoEvento.")
             UNION ALL
             SELECT evento_historico.idEvento as id_evento, 
                            subtipoevento.nombre as 'tipo_evento', 
                            evento_historico.fecha as Fecha,
                            evento_historico.tipoObjeto,
                            evento_historico.ipOrigen as ip_cliente,
                            evento_historico.objeto as nombre_objeto,
                            evento_historico.descripcion as descripcion,
                            evento_historico.estadoAnterior as estado_anterior,
                            evento_historico.estadoPosterior as estado_posterior,
                            evento_historico.usuario as usuario
                        FROM evento_historico
                        inner join subtipoevento
                        on evento_historico.idSubTipoEvento = subtipoevento.idSubTipoEvento
                        inner join tipoevento
                        on subtipoevento.idTipoEvento = tipoevento.idTipoEvento
                        where (1 ".$filtroFecha2.$filtroTipoEvento.")
                            ) RESULT
            ORDER BY id_Evento ASC";

        $res = $this->bd->query($query);
        $count = (int)$this->bd->num_rows();

        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        
        $List->clearlist();            
        while ($row = $res->fetch_assoc()){
            $Est = new dtoevento;
            $Est->id_evento         = $row['id_evento'];
            $Est->tipo_evento       = $row['tipo_evento']; 
            $Est->fecha             = date("d/m/Y H:i:s", strtotime( $row['Fecha']) ); //para cambiar el formato de fecha
            $Est->tipoObjeto        = $row['tipoObjeto'];
            $Est->ip_cliente        = $row['ip_cliente']; 
            $Est->nombre_objeto     = $row['nombre_objeto'];  
            $Est->descripcion       = $row['descripcion'];
            $Est->estado_anterior   = $row['estado_anterior'];
            $Est->estado_posterior  = $row['estado_posterior'];
             $Est->usuario          = $row['usuario'];
            $List->addlast($Est);
        }
        
        $res->free();
        return $count;
    }
    
    public function geteventoEX($List) {
        $id = $List->getelem()->id_evento;
        $feini = $List->getelem()->feini;
        $fefin = $List->getelem()->fefin;
        $filtroTipoEvento = "";
        if( !($id == 0) ){
                $filtroTipoEvento = " AND (tipoevento.idTipoEvento = ".$id.")";
        }
        $filtro_tipo_evento = "".$filtro_tipo_evento."";  
        switch ($id) {
            case 0:
                $tipo = "todos";
                break;
            case 1:
                $tipo = "Login";
                break;
            case 2:
                $tipo = "ABMusuarios";
                break;
            case 3;
                $tipo = "ABMperfilesRoles";
                break;
            case 4:
                $tipo = "procesosDepuracion";
                break;
            case 5:
                $tipo = "TRXCriticas";
                break;
        }
        $feini = "'".$feini." 00:00:00"."'";
        $fefin = "'".$fefin." 23:59:59"."'";
        $filtroFecha = '';
        $filtroFecha2 = '';
        if($List->getelem()->feini){
            $filtroFecha .= " AND evento.fecha >= " . $feini;
            $filtroFecha2 .= " AND evento_historico.fecha >= " . $feini;
        }
        if($List->getelem()->fefin){
            $filtroFecha .= " AND evento.fecha <= " . $fefin;
            $filtroFecha2 .= " AND evento_historico.fecha <= " . $fefin;
        }
        
        $query = "SELECT RESULT.* FROM(
            SELECT evento.idEvento as id_evento, 
                            subtipoevento.nombre as 'tipo_evento', 
                            evento.fecha as Fecha,
                            evento.tipoObjeto,
                            evento.ipOrigen as ip_cliente,
                            evento.objeto as nombre_objeto,
                            evento.descripcion as descripcion,
                            evento.estadoAnterior as estado_anterior,
                            evento.estadoPosterior as estado_posterior,
                            evento.usuario as usuario
                        FROM evento
                        inner join subtipoevento
                        on evento.idSubTipoEvento = subtipoevento.idSubTipoEvento
                        inner join tipoevento
                        on subtipoevento.idTipoEvento = tipoevento.idTipoEvento
                        where (1 ".$filtroFecha.$filtroTipoEvento.")
             UNION ALL
             SELECT evento_historico.idEvento as id_evento, 
                            subtipoevento.nombre as 'tipo_evento', 
                            evento_historico.fecha as Fecha,
                            evento_historico.tipoObjeto,
                            evento_historico.ipOrigen as ip_cliente,
                            evento_historico.objeto as nombre_objeto,
                            evento_historico.descripcion as descripcion,
                            evento_historico.estadoAnterior as estado_anterior,
                            evento_historico.estadoPosterior as estado_posterior,
                            evento_historico.usuario as usuario
                        FROM evento_historico
                        inner join subtipoevento
                        on evento_historico.idSubTipoEvento = subtipoevento.idSubTipoEvento
                        inner join tipoevento
                        on subtipoevento.idTipoEvento = tipoevento.idTipoEvento
                        where (1 ".$filtroFecha2.$filtroTipoEvento.")
                            ) RESULT
            ORDER BY id_Evento ASC";

        $res = $this->bd->query($query);
        if (!$res) {
            throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        }
        
        require_once '../../INCLUDE/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        general::configureExcel($objPHPExcel, 'Centro Venta Empresa Colombia', 'Reporte de modulos');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'id evento')
                ->setCellValue('B1', 'tipo de evento')
                ->setCellValue('C1', 'fecha')
                ->setCellValue('D1', 'tipoObjeto')
                ->setCellValue('E1', 'cliente')
                ->setCellValue('F1', 'nombre del objeto')
                ->setCellValue('G1', utf8_encode('Descripción'))
                ->setCellValue('H1', 'estado anterior')
                ->setCellValue('I1', 'estado posterior')
                ->setCellValue('J1', 'usuario');
        
        $i = 1;
        if($this->bd->num_rows() > 0){
            while(($row = $res->fetch_assoc()) && $i++) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $row['id_evento'])
                        ->setCellValue("B$i", $row['tipo_evento'])
                        ->setCellValue("C$i", date("d/m/Y H:i:s", strtotime( $row['Fecha']) ))
                        ->setCellValue("D$i", $row['tipoObjeto'])
                        ->setCellValue("E$i", $row['ip_cliente'])
                        ->setCellValue("F$i", $row['nombre_objeto'])
                        ->setCellValue("G$i", $row['descripcion'])
                        ->setCellValue("H$i", $row['estado_anterior'])
                        ->setCellValue("I$i", $row['estado_posterior'])
                        ->setCellValue("J$i", $row['usuario'])
                        ->getStyle("G$i")->getAlignment()->setWrapText(true);
            }
        }else{
            ++$i;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i", 'NO SE HAN ENCONTRADO RESULTADOS PARA LAS FECHAS SELECCIONADAS');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$i:J$i");
        }
        $res->free();
       
        general::formatExcel($objPHPExcel, 'J', $i);
        general::downloadExcel($objPHPExcel, 'reporteSeguridad' . date('Ymd'));

    }


  //J.G 07/03/2019
    /*****************************************************/
       public function LogErrors($clase, $funcion, $error, $query, $code,$url,$usuario_id) {
       
    
       $sql = "SELECT *FROM usuarios
                      where usr_id = ".$usuario_id." ";
     
       //file_put_contents("querylogerrores.txt", print_r($sql,true));
          
        $resultado = $this->bd->query($sql);
        

       if (!$resultado) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $sql, 1);
        
             
            while ($row = $resultado->fetch_assoc()){
         
                $nombre_usuario = $row['usr_nombres'].'-'.$row['usr_apellidos'];
                $tienda =  $row['cod_local'];
          
             }
        
       $resultado->free();
       
      
       $descripcion = '';
      
        // Query que inserta los datos en la base de datos.
      $descripcion .= "Clase:".$clase."-"."function:".$funcion."-";
      $descripcion .= "Descripcion:".preg_replace("/[^a-zA-Z0-9\s]/", "", $error."-");
      $descripcion .= "Query:".preg_replace("/[^a-zA-Z0-9\s]/", "", $query."-");
 
    
        $query = "  INSERT INTO log_errorscve(id_usuario,nombre_usuario,tienda,ruta,descripcion,fecha) 
        VALUES ('".$usuario_id."','".$nombre_usuario."','".$tienda."','".$url."','".$descripcion."',NOW() )";

      //   file_put_contents("queryeRROR.txt", print_r($query,true));

        $res = $this->bd->query($query);

        //general::writeevent('locales '.$query);
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);


        }

    
}

