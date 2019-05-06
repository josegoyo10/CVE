<?
class dtocotizacion {
    /*** variables de clase ***/
    private $arreglo = array();
        
    /*** Constructor ***/ 
    function __construct($arrelem = null) {
        $this->arreglo['id_cotizacion'] = null;
        $this->arreglo['id_estado'] = null;
        $this->arreglo['nomestado'] = null;        
        $this->arreglo['cargoflete'] = null;        
        $this->arreglo['flete'] = null;        
        $this->arreglo['numlinea1'] = null;        
        $this->arreglo['stock'] = null;
        $this->arreglo['id_tipoventa'] = null;
        $this->arreglo['nomtipoventa'] = null;      
        $this->arreglo['codigovendedor'] = null;
        $this->arreglo['rutcliente'] = null;
        $this->arreglo['codlocalventa'] = null;
        $this->arreglo['nom_local'] = null;        
        $this->arreglo['dir_local'] = null;          
        $this->arreglo['dir_localcsum'] = null;          
        $this->arreglo['codlocalcsum'] = null;
        $this->arreglo['nom_localcsum'] = null;
        $this->arreglo['razonsoc'] = null;
        $this->arreglo['id_giro'] = null;
        $this->arreglo['giro'] = null;
        $this->arreglo['direccion'] = null;
        $this->arreglo['comuna'] = null;
        $this->arreglo['iva'] = null;
        $this->arreglo['validdesde'] = null;
        $this->arreglo['validhasta'] = null;
        $this->arreglo['validdias'] = null;
        $this->arreglo['nvevaliddesde'] = null;
        $this->arreglo['nvevalidhasta'] = null;
        $this->arreglo['nvevaliddias'] = null;
        $this->arreglo['condicion'] = null;
        $this->arreglo['diascondicion'] = null;        
        $this->arreglo['fonocontacto'] = null;
        $this->arreglo['observaciones'] = null;
        $this->arreglo['nota'] = null;
        $this->arreglo['id_usuario'] = null;
        $this->arreglo['usuariocrea'] = null;
        $this->arreglo['valortotal'] = null;        
        $this->arreglo['margentotal'] = null;           
        $this->arreglo['obsdesb'] = null;
        $this->arreglo['puedever'] = null;
        $this->arreglo['puedemodificar'] = null;
        $this->arreglo['puedeeliminar'] = null;
        $this->arreglo['orderby'] = null;
        $this->arreglo['reqdet'] = null;
        $this->arreglo['feccrea'] = null;
        $this->arreglo['usrmod'] = null;        
        $this->arreglo['estado'] = null;       
        $this->arreglo['id_tipopago'] = null;        
        $this->arreglo['fechaucofini'] = null;
        $this->arreglo['fechaucoffin'] = null;
        $this->arreglo['numlinea'] = null;
        $this->arreglo['barra'] = null;        
        $this->arreglo['nomproveedor'] = null;
        $this->arreglo['rutproveedor'] = null;
        $this->arreglo[ 'limite' ] = null;       
        $this->arreglo['total_coti'] = null;
        $this->arreglo['prorrateoflete'] = null;        
        $this->arreglo['bloqueopormargen'] = null;        
        $this->arreglo['bloqueoporcarga'] = null;
        $this->arreglo['rete_iva'] = null;
        $this->arreglo['rete_ica'] = null;
        $this->arreglo['rete_renta'] = null;
        $this->arreglo['cot_iva'] = null;
        $this->arreglo['ciudad'] = null;
        $this->arreglo['contacto'] = null;
        $this->arreglo['comentariodir'] = null;
        $this->arreglo['id_dirdespacho'] = null;
        $this->arreglo['zona'] = null;
        $this->arreglo['actualizarinventario']   = false;
        $this->arreglo['nom_localventa']   = null;
        $this->arreglo['observaciones_pos']   = null;
	  //  $this->arreglo['margen']   = null;    

        if (is_array($arrelem))
        	foreach($arrelem as $key=>$value)
        		$this->$key = $value;
    }

    /*** Setter ***/
    public function __set($name, $value) {
        if (array_key_exists($name, $this->arreglo)) {
            $this->arreglo[$name] = $value;
        } else {
			throw new SYSException(__CLASS__ , __FUNCTION__ , "Error: No existe el atributo requerido en SET $name", __METHOD__, 3);
        }
    }

    /*** Getter ***/
    public function __get($name) {
        if (array_key_exists($name, $this->arreglo)) {
            return $this->arreglo[$name];
        } else {
			throw new SYSException(__CLASS__ , __FUNCTION__ , "Error: No existe el atributo requerido en GET $name", __METHOD__, 3);
        }
    }
}
?>
