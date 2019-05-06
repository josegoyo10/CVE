<?
class daoflete{
    /*** atributos ***/
    private $bd = NULL; 

    /*** constructor ***/
    public function __construct(){
        $this->bd = $_SESSION["DBACESS"];
    }
    public function __destruct(){
        //$this->bd->close();
    }   
    
    public function getDatosFlete($Listf){
        $Listf->gofirst();
        $query = "  SELECT e.id_ordenent,
                           e.rutcliente, 
                           e.direccion, 
                           e.comuna, 
                           e.id_estado, 
                           e.codlocalventa, 
                           e.id_tipoentrega, 
                           d.codtipo
                    FROM ordenent_e e
                    LEFT JOIN ordenent_d d on d.id_ordenent = e.id_ordenent
                    WHERE 1
                    " . (($Listf->getelem()->rut)? " and e.rutcliente = ".$Listf->getelem()->rut : "") . "
                    and e.id_estado = 'OG'
                    " . (($Listf->getelem()->codlocalventa)? " and e.codlocalventa = '".$Listf->getelem()->codlocalventa."'" : "") . "
                    " . (($Listf->getelem()->codlocalventa)? " and e.codlocalventa = '".$Listf->getelem()->codlocalventa."'" : "") . "
                    and e.id_tipoentrega = 2
                    " . (($Listf->getelem()->fechad)? " and e.fecha_despacho_programado = '".$Listf->getelem()->fechad."'" : "") . "
                    
                    " . (($Listf->getelem()->dirdesp)? " and e.direccion = '".$Listf->getelem()->dirdesp."'" : "") . "                  
                   
                    ";
       
        //general::writeevent($query);
        $res = $this->bd->query($query);

         file_put_contents("listf.txt", print_r($res,true));
        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);

        $Listf->clearlist();
        while ($row = $res->fetch_assoc()){
            $Registro = new dtoflete;
            $Registro->id_ordenent      =   $row['id_ordenent'];
            $Registro->rut              =   $row['rutcliente'];
            $Registro->id_estado        =   $row['id_estado'];
            $Registro->codlocalventa    =   $row['codlocalventa'];
            $Registro->id_tipoentrega   =   $row['id_tipoentrega'];
            $Registro->comuna           =   $row['comuna'];
            $Registro->direccion        =   $row['direccion'];
            $Registro->fechad           =   $row['fechad'];
            $Registro->cod_tipo         =   $row['codtipo'];    
            $Listf->addlast($Registro);
        }
        $res->free();
        return true;
    }



   
   // Funcion Añadida J.G 05-04-2019.
    public function getDataFlete($id_location,$id_store, $tipo_despacho){

       $query = " SELECT zn.*, dz.*
                  FROM fl_zonesxneighborhood zn, 
                  fl_delivery_zones dz 
                  WHERE zn.id_location = ".$id_location."
                    AND zn.id_zone = dz.id_zone 
                     AND dz.id_company = 0  AND id_store =  ".$id_store." ";
        
        $res    = $this->bd->query($query);
        $numero = $this->bd->num_rows($res);
        
        //file_put_contents("numeroQuery.txt",print_r($numero,true));
        

        if (!$res) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);
        

        if ($numero != '') {

           $resultado = $res;

        } else {

            $query = " SELECT zn.*, dz.*
                  FROM fl_zonesxneighborhood zn, 
                  fl_delivery_zones dz 
                  WHERE zn.id_location = ".$id_location."
                    AND zn.id_zone = dz.id_zone 
                     AND dz.id_company = 0  ";

             $res    = $this->bd->query($query);

             $resultado = $res;

        }




        while ($row = $resultado->fetch_assoc()){

              file_put_contents("queryGetDataFlete01.txt",print_r($row,true));
              $id           = $row['id'];
              $id_zone      = $row['id_zone'];  
              $id_location  = $row['id_location'];  

             
        }

        // Luego de Obtener el ID de la zona de la tienda tengo que buscar los valores del fletes de la tienda en la siguiente tabla.

        $sql_fletes = "SELECT r.* 
                    FROM fl_rates r 
                    WHERE r.id_type_rate = '".$tipo_despacho."'
                    AND r.id_zone = '".$id_zone."' ";

         $res_fletes = $this->bd->query($sql_fletes);
       
        if (!$res_fletes) throw new DAOException(__CLASS__ , __FUNCTION__ , $this->bd->error(), $query, 1);


        while ($row = $res_fletes->fetch_assoc()){

              file_put_contents("queryGetDataFlete02.txt",print_r($row,true));
              $id_type_rate     = $row['id_type_rate'];
              $id_zone          = $row['id_zone'];  
              $value1           = $row['value1'];  
              $value2           = $row['value2'];
              $value3           = $row['value3'];  
              $prd_sap          = $row['prd_sap']; 
              $prd_sap_kg_adic  = $row['prd_sap_kg_adic']; 
        }


          
       $res->free();
       $res_fletes->free();

        return $data = array(
            'id' => $id_type_rate,
             'tipoflete' => "0",
             'tipodesp'  => $tipo_despacho,
             'tipoenv'   => "1",
             'valorflet' => $value1,
             'cantidad'  => "1",
             'codsap'    => $prd_sap,
            'zona'    => $id_zone,
            'id_location' => $id_location
         );
        
         
     
      // return  $res_fletes;

  }

     














    
    
    
}

?>
