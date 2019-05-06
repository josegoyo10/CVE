<?

class dtoreporte{
    /*     * * variables de clase ** */

    private $arreglo = array();

    /*     * * Constructor ** */

    function __construct($arrelem = null){
        $this->arreglo['numdocumento']         = null;
        $this->arreglo['foliodesde']           = null;
        $this->arreglo['foliohasta']           = null;
        $this->arreglo['sigtipodoc']           = null;
        $this->arreglo['fechadocumento']       = null;
        $this->arreglo['fecinicio']            = null;
        $this->arreglo['id_estado']            = null;
        $this->arreglo['indmsgsap']            = null;
        $this->arreglo['fectermino']           = null;
        $this->arreglo['fecinicio2']           = null;
        $this->arreglo['fectermino2']          = null;
        $this->arreglo['bloqueo1']             = null;
        $this->arreglo['bloqueo2']             = null;
        $this->arreglo['bloqueo3']             = null;
        $this->arreglo['bloqueodisp']          = null;
        $this->arreglo['hora']                 = null;
        $this->arreglo['rubro']                = null;
        $this->arreglo['nomlocemi']            = null;
        $this->arreglo['nomloccsum']           = null;
        $this->arreglo['codlocalemi']          = null;
        $this->arreglo['codlocalcsum']         = null;
        $this->arreglo['rutcliente']           = null;
        $this->arreglo['razonsoc']             = null;
        $this->arreglo['codigovendedor']       = null;
        $this->arreglo['apellidoynombre']      = null;
        $this->arreglo['nommedpag']            = null;
        $this->arreglo['numdocpago']           = null;
        $this->arreglo['numdocref']            = null;
        $this->arreglo['totalnum']             = null;
        $this->arreglo['tipodocumento']        = null;
        $this->arreglo['totaliva']             = null;
        $this->arreglo['totalfacturas']        = null;
        $this->arreglo['totalnumiva']          = null;
        $this->arreglo['codvendedor']          = null;
        $this->arreglo['nomvendedor']          = null;
        $this->arreglo['codventa']             = null;
        $this->arreglo['venta']                = null;
        $this->arreglo['neto']                 = null;
        $this->arreglo['iva']                  = null;
        $this->arreglo['total_venta']          = null;
        $this->arreglo['total_ncr']            = null;
        $this->arreglo['neto_ncr']             = null;
        $this->arreglo['neto_fct']             = null;
        $this->arreglo['totalmargen']          = null;
        $this->arreglo['total_margen']         = null;
        $this->arreglo['margenpromedio']       = null;
        $this->arreglo['contribucion']         = null;
        $this->arreglo['total_neto']           = null;
        $this->arreglo['codsap']               = null;
        $this->arreglo['cotizacion']           = null;
        $this->arreglo['margen_limite']        = null;
        $this->arreglo['tipo_venta']           = null;
        $this->arreglo['tipo_entrega']         = null;
        $this->arreglo['lockprint']            = null;
        $this->arreglo['descripcion']          = null;
        $this->arreglo['cantidad']             = null;
        $this->arreglo['costo_unitario']       = null;
        $this->arreglo['precioventa_unitario'] = null;
        $this->arreglo['entidad']              = null;
        $this->arreglo['numero_entidad']       = null;
        $this->arreglo['referencia']           = null;
        $this->arreglo['datos']                = null;
        $this->arreglo['resultado']            = null;
        $this->arreglo['fecha_desbloqueo']     = null;
        $this->arreglo['comentario']           = null;
        $this->arreglo['fct']                  = null;
        $this->arreglo['gde']                  = null;
        $this->arreglo['oe']                   = null;
        $this->arreglo['numinterno']           = null;
        $this->arreglo['tipo_fct']             = null;
        $this->arreglo['tipo_gde']             = null;
        $this->arreglo['destino']              = null;
        $this->arreglo['estado']               = null;
        $this->arreglo['tipo_factura']         = null;
        $this->arreglo['tipo_cliente']         = null;
        $this->arreglo['nombrecliente']        = null;
        $this->arreglo['idcliente']            = null;
        $this->arreglo['disponible']           = null;
        $this->arreglo['condicion_pago']       = null;
        $this->arreglo['tipopago']             = null;
        $this->arreglo['numdoccve']            = null;
        $this->arreglo['usuario']              = null;
        $this->arreglo['total_linea']          = null;
        $this->arreglo['id_contribuyente']     = null;
        $this->arreglo['rete_ica']             = null;
        $this->arreglo['rete_iva']             = null;
        $this->arreglo['rete_renta']           = null;
        $this->arreglo['limite']               = null;
        $this->arreglo['fechadesbloqueo']      = null;
        $this->arreglo['fechadesbloqueo1']     = null;
        $this->arreglo['fechadesbloqueo2']     = null;
        $this->arreglo['motivodesbloqueo']     = null;
        $this->arreglo['comentariodesbloqueo'] = null;
        $this->arreglo['tipofolio']            = null;
        $this->arreglo['MOD_ID']               = null;
        $this->arreglo['MOD_PADRE_ID']         = null;
        $this->arreglo['MOD_ESTADO']           = null;
        $this->arreglo['MOD_NOMBRE']           = null;
        $this->arreglo['MOD_DESCRIPCION']      = null;
        $this->arreglo['MOD_URL']              = null;
        $this->arreglo['MOD_ORDEN']            = null;
        $this->arreglo['MOD_USR_CREA']         = null;
        $this->arreglo['MOD_FEC_CREA']         = null;
        $this->arreglo['MOD_USR_MOD']          = null;
        $this->arreglo['MOD_FEC_MOD']          = null;
        $this->arreglo['Usuario']              = null;//Mantis 27363
        $this->arreglo['Guia']                 = null;//Mantis 27362
        $this->arreglo['Nro_OP']               = null;//Mantis 27362
        if(is_array($arrelem)){
            foreach($arrelem as $key => $value){
                $this->$key = $value;
            }
        }
    }

    /*     * * Setter ** */

    public function __set($name, $value){
        if(array_key_exists($name, $this->arreglo)){
            $this->arreglo[$name] = $value;
        }else{
            throw new SYSException(__CLASS__, __FUNCTION__, "Error: No existe el atributo requerido en SET $name", __METHOD__, 3);
        }
    }

    /*     * * Getter ** */

    public function __get($name){
        if(array_key_exists($name, $this->arreglo)){
            return $this->arreglo[$name];
        }else{
            throw new SYSException(__CLASS__, __FUNCTION__, "Error: No existe el atributo requerido en GET $name", __METHOD__, 3);
        }
    }

}
