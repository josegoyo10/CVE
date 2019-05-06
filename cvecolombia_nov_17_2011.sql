-- MySQL dump 10.10
--
-- Host: localhost    Database: cvecolprod
-- ------------------------------------------------------
-- Server version	5.0.22-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `arreglos_florales`
--

DROP TABLE IF EXISTS `arreglos_florales`;
CREATE TABLE `arreglos_florales` (
  `id_arr_flo` int(11) NOT NULL auto_increment,
  `id_os` bigint(20) NOT NULL,
  `arr_flo_nombre` varchar(255) default NULL,
  `arr_flo_direccion` varchar(255) NOT NULL,
  `arr_flo_localizacion` bigint(20) NOT NULL,
  `arr_flo_mensajededicatoria` varchar(5000) default NULL,
  `arr_flo_observaciones` varchar(2000) default NULL,
  `arr_flo_fechaentrega` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id_arr_flo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `cambiosestado`
--

DROP TABLE IF EXISTS `cambiosestado`;
CREATE TABLE `cambiosestado` (
  `id_estado_origen` char(2) NOT NULL default '',
  `id_estado_destino` char(2) NOT NULL default '',
  `tipo` char(2) NOT NULL default '',
  `descripcion` varchar(45) NOT NULL default '',
  `color` varchar(45) default NULL,
  PRIMARY KEY  (`id_estado_origen`,`id_estado_destino`,`tipo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL auto_increment,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_ciudad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='listado de ciudades.';

--
-- Table structure for table `clasificacion_cliente`
--

DROP TABLE IF EXISTS `clasificacion_cliente`;
CREATE TABLE `clasificacion_cliente` (
  `id_clasificacion_cli` int(10) unsigned NOT NULL auto_increment,
  `descripcion_clasificacion` varchar(70) NOT NULL,
  PRIMARY KEY  (`id_clasificacion_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `rut` decimal(13,0) NOT NULL default '0',
  `id_comuna` bigint(20) unsigned default NULL,
  `id_rubro` int(11) default NULL,
  `id_tipocliente` smallint(6) default NULL,
  `id_tipodocpago` smallint(5) unsigned NOT NULL,
  `id_giro` varchar(10) default 'C001',
  `codigovendedor` varchar(20) default NULL,
  `razonsoc` varchar(255) default NULL,
  `giro` varchar(255) default NULL,
  `contacto` varchar(255) default NULL,
  `fonocontacto` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `direccion` varchar(255) default NULL,
  `bloqueo1` tinyint(1) default NULL,
  `bloqueo2` tinyint(1) default NULL,
  `bloqueo3` tinyint(1) default NULL,
  `valdisp` date default NULL,
  `diascondicion` smallint(6) unsigned default NULL,
  `codclisap` varchar(10) default NULL,
  `comentario` varchar(255) default NULL,
  `codlocaluco` varchar(50) default NULL,
  `fechauco` date default NULL,
  `usrcrea` varchar(12) default NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) default NULL,
  `fecmod` datetime NOT NULL,
  `id_clientepref` int(11) NOT NULL default '0',
  `rete_ica` tinyint(1) NOT NULL default '0',
  `rete_iva` tinyint(1) NOT NULL default '0',
  `rete_renta` tinyint(1) NOT NULL default '0',
  `id_contribuyente` int(10) unsigned NOT NULL default '0',
  `id_documento_identidad` int(10) unsigned NOT NULL default '0',
  `id_clasificacion_cli` int(10) unsigned NOT NULL default '0',
  `apellido` varchar(255) default NULL,
  `apellido1` varchar(255) default NULL,
  `celcontactoe` varchar(45) default '0',
  `fax` varchar(45) default '0',
  `id_regimencontri` int(10) unsigned NOT NULL default '0',
  `genero` varchar(2) default 'NA',
  `cobroiva` int(1) unsigned NOT NULL default '1',
  `id_profesion` varchar(2) NOT NULL default '1',
  PRIMARY KEY  (`rut`),
  KEY `fk_reference_27` (`id_rubro`),
  KEY `fk_reference_28` (`id_tipocliente`),
  KEY `fk_reference_32` (`id_comuna`),
  KEY `INDEX_REF_5` (`codigovendedor`),
  KEY `INDEX_REF_6` (`codlocaluco`),
  KEY `INDEX_REF_32` (`fechauco`),
  KEY `fk_reference_37` (`id_giro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='listado de clientes. aquí se combinan los clientes contado ';

--
-- Table structure for table `cliente_preferente`
--

DROP TABLE IF EXISTS `cliente_preferente`;
CREATE TABLE `cliente_preferente` (
  `id_clientepref` int(10) unsigned NOT NULL auto_increment,
  `nombre_pref` varchar(45) NOT NULL default '',
  `id_tipocliente` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_clientepref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `comuna`
--

DROP TABLE IF EXISTS `comuna`;
CREATE TABLE `comuna` (
  `id_comuna` int(11) NOT NULL auto_increment,
  `id_ciudad` int(11) default NULL,
  `id_region` int(10) unsigned default NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_comuna`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `comunad`
--

DROP TABLE IF EXISTS `comunad`;
CREATE TABLE `comunad` (
  `id_comuna` int(11) NOT NULL auto_increment,
  `id_ciudad` int(11) default NULL,
  `id_region` int(10) unsigned default NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_comuna`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `cotizacion_d`
--

DROP TABLE IF EXISTS `cotizacion_d`;
CREATE TABLE `cotizacion_d` (
  `id_linea` int(11) NOT NULL auto_increment,
  `id_cotizacion` int(11) NOT NULL,
  `id_tiporetiro` smallint(6) default NULL,
  `id_tipoentrega` smallint(6) default NULL,
  `numlinea` smallint(6) NOT NULL,
  `descripcion` varchar(50) collate latin1_spanish_ci NOT NULL,
  `codprod` decimal(12,0) NOT NULL,
  `barra` decimal(14,0) NOT NULL default '0',
  `pcosto` decimal(12,2) NOT NULL,
  `pventaneto` decimal(12,2) NOT NULL,
  `cargoflete` decimal(12,2) NOT NULL,
  `valorfleteh` decimal(12,2) default NULL,
  `pventaiva` decimal(12,2) default NULL,
  `totallinea` bigint(20) NOT NULL default '0',
  `cantidad` int(10) unsigned NOT NULL,
  `cantidade` decimal(10,2) default NULL,
  `margenlinea` decimal(6,2) NOT NULL,
  `usrcrea` varchar(12) character set latin1 NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) character set latin1 NOT NULL,
  `fecmod` datetime NOT NULL,
  `incluirentotal` tinyint(1) default NULL,
  `unimed` char(3) character set latin1 NOT NULL,
  `codtipo` char(2) character set latin1 default NULL,
  `codsubtipo` char(2) character set latin1 default NULL,
  `rutproveedor` int(8) NOT NULL default '0',
  `nomproveedor` varchar(20) character set latin1 default NULL,
  `marcaflete` tinyint(1) unsigned default NULL,
  `instalacion` varchar(2) character set latin1 NOT NULL default 'NO',
  `descuento` decimal(10,0) NOT NULL default '0',
  `peso` decimal(10,2) NOT NULL default '0.00',
  `rete_ica` decimal(5,4) NOT NULL default '0.0000',
  `rete_renta` decimal(5,4) NOT NULL default '0.0000',
  `cot_iva` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id_linea`),
  KEY `fk_reference_1` (`id_cotizacion`),
  KEY `fk_reference_25` (`id_tiporetiro`),
  KEY `INDEX_REF_22` (`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='detalle de una cotización';

--
-- Table structure for table `cotizacion_e`
--

DROP TABLE IF EXISTS `cotizacion_e`;
CREATE TABLE `cotizacion_e` (
  `id_cotizacion` int(11) NOT NULL auto_increment,
  `id_estado` char(2) NOT NULL,
  `id_tipoventa` smallint(6) default NULL,
  `codigovendedor` varchar(20) NOT NULL,
  `rutcliente` decimal(13,0) default '0',
  `codlocalventa` varchar(50) NOT NULL,
  `codlocalcsum` varchar(50) NOT NULL,
  `razonsoc` varchar(255) NOT NULL,
  `id_giro` varchar(10) default NULL,
  `giro` varchar(255) default NULL,
  `direccion` varchar(255) default NULL,
  `comuna` varchar(50) default NULL,
  `iva` decimal(4,2) NOT NULL,
  `validdesde` date NOT NULL,
  `validhasta` date NOT NULL,
  `validdias` smallint(6) NOT NULL,
  `nvevaliddesde` date default NULL,
  `nvevalidhasta` date default NULL,
  `nvevaliddias` smallint(6) default NULL,
  `condicion` varchar(50) NOT NULL,
  `diascondicion` smallint(6) NOT NULL,
  `fonocontacto` varchar(30) default NULL,
  `observaciones` varchar(255) default NULL,
  `nota` varchar(255) default NULL,
  `id_usuario` int(11) NOT NULL,
  `usuariocrea` varchar(50) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `margentotal` decimal(6,2) NOT NULL,
  `obsdesb` varchar(255) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  `rete_iva` decimal(10,0) NOT NULL default '0',
  `rete_ica` decimal(10,0) NOT NULL default '0',
  `rete_renta` decimal(10,0) NOT NULL default '0',
  `cot_iva` decimal(10,0) NOT NULL default '0',
  `id_dirdespacho` int(11) NOT NULL default '0',
  `zona` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`id_cotizacion`),
  KEY `fk_reference_13` (`id_estado`),
  KEY `fk_reference_35` (`id_tipoventa`),
  KEY `fk_reference_43` (`rutcliente`),
  KEY `INDEX_REF_1` (`codlocalventa`),
  KEY `INDEX_REF_2` (`codlocalcsum`),
  KEY `INDEX_REF_3` (`codigovendedor`),
  KEY `INDEX_REF_21` (`razonsoc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='encabezado de una cotización o nve';

--
-- Table structure for table `cu_city`
--

DROP TABLE IF EXISTS `cu_city`;
CREATE TABLE `cu_city` (
  `ID` decimal(10,0) NOT NULL default '0',
  `ID_PROVINCE` decimal(10,0) NOT NULL default '0',
  `ID_DEPARTMENT` decimal(10,0) NOT NULL default '0',
  `DESCRIPTION` varchar(100) NOT NULL,
  PRIMARY KEY  (`ID`,`ID_PROVINCE`,`ID_DEPARTMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_department`
--

DROP TABLE IF EXISTS `cu_department`;
CREATE TABLE `cu_department` (
  `ID` decimal(10,0) NOT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_group`
--

DROP TABLE IF EXISTS `cu_group`;
CREATE TABLE `cu_group` (
  `id_group` int(10) unsigned NOT NULL,
  `group_desc` varchar(30) default NULL,
  PRIMARY KEY  (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_locality`
--

DROP TABLE IF EXISTS `cu_locality`;
CREATE TABLE `cu_locality` (
  `ID` decimal(10,0) NOT NULL,
  `ID_DEPARTMENT` decimal(10,0) NOT NULL,
  `ID_PROVINCE` decimal(10,0) NOT NULL,
  `ID_CITY` decimal(10,0) NOT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  PRIMARY KEY  (`ID`,`ID_DEPARTMENT`,`ID_PROVINCE`,`ID_CITY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_neighborhood`
--

DROP TABLE IF EXISTS `cu_neighborhood`;
CREATE TABLE `cu_neighborhood` (
  `ID` decimal(10,0) NOT NULL,
  `ID_DEPARTMENT` decimal(10,0) NOT NULL,
  `ID_PROVINCE` decimal(10,0) NOT NULL,
  `ID_CITY` decimal(10,0) NOT NULL,
  `ID_LOCALITY` decimal(10,0) NOT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  `SOCIAL_LEVEL` varchar(1) NOT NULL,
  `LOCATION` decimal(20,0) NOT NULL,
  PRIMARY KEY  (`ID`,`ID_DEPARTMENT`,`ID_PROVINCE`,`ID_CITY`,`ID_LOCALITY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_profesion`
--

DROP TABLE IF EXISTS `cu_profesion`;
CREATE TABLE `cu_profesion` (
  `id` varchar(2) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `cu_province`
--

DROP TABLE IF EXISTS `cu_province`;
CREATE TABLE `cu_province` (
  `ID` decimal(10,0) NOT NULL,
  `ID_DEPARTMENT` decimal(10,0) NOT NULL,
  `DESCRIPTION` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`,`ID_DEPARTMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL auto_increment,
  `id_comuna` bigint(20) unsigned default '0',
  `rut` decimal(13,0) NOT NULL default '0',
  `descripcion` varchar(50) default NULL,
  `direccion` varchar(255) default NULL,
  `contacto` varchar(255) default NULL,
  `fonocontacto` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `comentario` varchar(255) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  `tipo_dir` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id_direccion`),
  KEY `fk_reference_50` (`rut`),
  KEY `fk_reference_6` (`id_comuna`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='listado de direcciones de despacho de un cliente. cada clien';

--
-- Table structure for table `disponible`
--

DROP TABLE IF EXISTS `disponible`;
CREATE TABLE `disponible` (
  `id_linea` int(11) NOT NULL auto_increment,
  `id_tipomovimiento` smallint(6) default NULL,
  `rut` decimal(13,0) default '0',
  `monto` int(11) default NULL,
  `id_ordenent` int(10) unsigned default NULL,
  `id_documento` int(10) unsigned default NULL,
  `indmsgsap` tinyint(1) default NULL,
  `usrcrea` varchar(12) default NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) default NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_linea`),
  KEY `fk_reference_21` (`rut`),
  KEY `fk_reference_24` (`id_tipomovimiento`),
  KEY `INDEX_REF_7` (`id_ordenent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='movimientos de disponible del cliente durante un día';

--
-- Table structure for table `documento_d`
--

DROP TABLE IF EXISTS `documento_d`;
CREATE TABLE `documento_d` (
  `id_linea` int(11) NOT NULL auto_increment,
  `id_documento` int(11) NOT NULL,
  `numlinea` smallint(6) NOT NULL,
  `descripcion` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `codprod` decimal(12,0) NOT NULL default '0',
  `barra` decimal(14,0) NOT NULL default '0',
  `pventaneto` decimal(12,2) NOT NULL,
  `pventaiva` decimal(12,2) default NULL,
  `cantidad` decimal(10,2) NOT NULL default '0.00',
  `pcosto` decimal(12,2) default NULL,
  `totallinea` bigint(20) NOT NULL default '0',
  `impuesto1` decimal(12,2) default NULL,
  `impuesto2` decimal(12,2) default NULL,
  `codtipo` char(2) default NULL,
  `codsubtipo` char(2) default NULL,
  `id_linearef` int(10) unsigned default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime default NULL,
  `unimed` varchar(3) NOT NULL default 'UN',
  `rutproveedor` int(8) NOT NULL default '0',
  `nomproveedor` varchar(20) default NULL,
  `marcaflete` tinyint(1) unsigned default NULL,
  `iva` float(10,4) default NULL,
  PRIMARY KEY  (`id_linea`),
  KEY `fk_reference_7` (`id_documento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='detalle de documento.';

--
-- Table structure for table `documento_e`
--

DROP TABLE IF EXISTS `documento_e`;
CREATE TABLE `documento_e` (
  `id_documento` int(11) NOT NULL auto_increment,
  `id_tipodocumento` smallint(6) default NULL,
  `id_tipoorigen` smallint(5) unsigned default NULL,
  `estado` varchar(4) default NULL,
  `sigtipodoc` char(3) NOT NULL,
  `pagina` smallint(6) NOT NULL,
  `tipoorigen` char(3) NOT NULL,
  `numorigen` int(11) NOT NULL,
  `numdocumento` varchar(50) default NULL,
  `fechadocumento` date default NULL,
  `numdocref` decimal(12,0) default NULL,
  `numdocrefop` decimal(12,0) default NULL,
  `codigovendedor` varchar(20) default NULL,
  `rutcliente` decimal(13,0) NOT NULL,
  `razonsoc` varchar(255) NOT NULL,
  `id_giro` varchar(10) default NULL,
  `giro` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `comuna` varchar(50) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `totaltexto` varchar(255) NOT NULL,
  `totalnum` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) default NULL,
  `totalnumiva` decimal(12,2) default NULL,
  `condicion` varchar(50) NOT NULL,
  `diascondicion` smallint(6) NOT NULL,
  `fonocontacto` varchar(30) NOT NULL,
  `observaciones` varchar(255) default NULL,
  `nota` varchar(255) default NULL,
  `codlocalventa` varchar(50) NOT NULL,
  `codlocalcsum` varchar(50) NOT NULL,
  `lockprintgde` tinyint(1) default NULL,
  `lockprintfct` tinyint(1) default NULL,
  `indmsgsap` tinyint(1) default NULL,
  `indodeasap` tinyint(1) default '0',
  `indnullsap` tinyint(1) unsigned default '0',
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  `mediopago` smallint(6) unsigned NOT NULL,
  `nreimpresion` int(10) unsigned default '0',
  PRIMARY KEY  (`id_documento`),
  KEY `fk_reference_23` (`id_tipodocumento`),
  KEY `INDEX_REF_4` (`id_tipoorigen`),
  KEY `INDEX_REF_23` (`sigtipodoc`),
  KEY `INDEX_REF_24` (`numdocumento`),
  KEY `INDEX_REF_25` (`numorigen`),
  KEY `INDEX_REF_26` (`numdocrefop`),
  KEY `INDEX_REF_27` (`indmsgsap`),
  KEY `INDEX_REF_28` (`tipoorigen`),
  KEY `INDEX_REF_29` (`pagina`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='encabezado de documento genérico. puede ser gde, fct, ncr, ';

--
-- Table structure for table `documento_identidad`
--

DROP TABLE IF EXISTS `documento_identidad`;
CREATE TABLE `documento_identidad` (
  `id_documento_identidad` int(10) unsigned NOT NULL auto_increment,
  `siglas_documento` varchar(8) default NULL,
  `descripcion_documento` varchar(80) NOT NULL,
  PRIMARY KEY  (`id_documento_identidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `id_documento` int(10) unsigned NOT NULL auto_increment,
  `folio` int(30) unsigned NOT NULL,
  `tipo_documento` varchar(30) NOT NULL,
  `id_ordenent` int(30) unsigned NOT NULL,
  `fechadocumento` datetime NOT NULL,
  `codlocalventa` varchar(10) NOT NULL,
  `feccrea` datetime NOT NULL,
  `fecmod` datetime NOT NULL,
  `usrcrea` varchar(45) NOT NULL,
  `usrmod` varchar(45) NOT NULL,
  PRIMARY KEY  (`id_documento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena documentos nulos.';

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `id_estado` char(2) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `tipo` char(2) NOT NULL,
  `estadoterminal` int(11) NOT NULL default '0',
  `usrcrea` varchar(12) default NULL,
  `feccrea` datetime NOT NULL default '0000-00-00 00:00:00',
  `usrmod` varchar(12) default NULL,
  `fecmod` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_estado`),
  KEY `INDEX_REF_30` (`tipo`),
  KEY `INDEX_REF_31` (`descripcion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='tabla de estados para todas las entidades';

--
-- Table structure for table `facturacion_suministro`
--

DROP TABLE IF EXISTS `facturacion_suministro`;
CREATE TABLE `facturacion_suministro` (
  `cod_local_fac` varchar(5) NOT NULL,
  `cod_local_sum` varchar(5) NOT NULL,
  PRIMARY KEY  USING BTREE (`cod_local_fac`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `glo_grupos`
--

DROP TABLE IF EXISTS `glo_grupos`;
CREATE TABLE `glo_grupos` (
  `GLO_ID` int(8) NOT NULL auto_increment,
  `GLO_TITULO` varchar(255) default NULL,
  `GLO_DESCRIPCION` text,
  `GLO_ORDEN` int(3) default NULL,
  `GLO_USR_CREA` varchar(255) default NULL,
  `GLO_FEC_CREA` datetime default NULL,
  `GLO_USR_MOD` varchar(255) default NULL,
  `GLO_FEC_MOD` datetime default NULL,
  PRIMARY KEY  (`GLO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `glo_variables`
--

DROP TABLE IF EXISTS `glo_variables`;
CREATE TABLE `glo_variables` (
  `VAR_ID` int(8) NOT NULL auto_increment,
  `VAR_GLO_ID` int(8) NOT NULL default '0',
  `VAR_TITULO` varchar(255) default NULL,
  `VAR_LLAVE` varchar(255) default NULL,
  `VAR_VALOR` varchar(255) default NULL,
  `VAR_DESCRIPCION` text,
  `VAR_ORDEN` int(3) default NULL,
  `VAR_USR_CREA` varchar(255) default NULL,
  `VAR_FEC_CREA` datetime default NULL,
  `VAR_USR_MOD` varchar(255) default NULL,
  `VAR_FEC_MOD` datetime default NULL,
  PRIMARY KEY  (`VAR_ID`),
  KEY `GLO_VARIABLES_FKIndex1` (`VAR_GLO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `grupotcp`
--

DROP TABLE IF EXISTS `grupotcp`;
CREATE TABLE `grupotcp` (
  `id_grupo` int(10) unsigned NOT NULL auto_increment,
  `nomgrupo` varchar(45) NOT NULL,
  `usrcrea` varchar(45) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(45) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `h_impresiones_picking`
--

DROP TABLE IF EXISTS `h_impresiones_picking`;
CREATE TABLE `h_impresiones_picking` (
  `id_ordenpicking` int(10) unsigned NOT NULL default '0',
  `usuario_impresion` int(10) unsigned NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `n_impresiones` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `iplocal`
--

DROP TABLE IF EXISTS `iplocal`;
CREATE TABLE `iplocal` (
  `ip` varchar(50) NOT NULL,
  `cod_local` varchar(50) NOT NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  KEY `INDEX_REF_8` (`cod_local`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='tabla con ip de los pc que se utilizarán en cada local';

--
-- Table structure for table `locales`
--

DROP TABLE IF EXISTS `locales`;
CREATE TABLE `locales` (
  `cod_local` varchar(5) NOT NULL,
  `nom_local` varchar(50) NOT NULL,
  `dir_local` varchar(255) default NULL,
  `ip_local` varchar(50) default NULL,
  `cod_local_pos` smallint(6) default NULL,
  `plaza` varchar(50) default NULL,
  `ofventa` varchar(50) default NULL,
  `despdom` tinyint(3) unsigned default '0',
  `foliofct` int(20) default NULL,
  `foliogde` int(20) default NULL,
  `id_localizacion` varchar(18) default '0',
  `tienda_virtual` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cod_local`),
  KEY `INDEX_REF_35` (`nom_local`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL auto_increment,
  `id_tipomensaje` smallint(6) default NULL,
  `descripcion` varchar(255) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_mensaje`),
  KEY `fk_reference_33` (`id_tipomensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='tabla para mensajes desde y hacia sap';

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `MOD_ID` int(8) NOT NULL auto_increment,
  `MOD_PADRE_ID` int(8) default NULL,
  `MOD_ESTADO` int(2) default NULL,
  `MOD_NOMBRE` varchar(255) default NULL,
  `MOD_DESCRIPCION` text,
  `MOD_URL` text,
  `MOD_ORDEN` int(5) default NULL,
  `MOD_USR_CREA` varchar(255) default NULL,
  `MOD_FEC_CREA` datetime default NULL,
  `MOD_USR_MOD` varchar(255) default NULL,
  `MOD_FEC_MOD` datetime default NULL,
  PRIMARY KEY  (`MOD_ID`),
  KEY `modulos_FKIndex1` (`MOD_PADRE_ID`),
  KEY `INDEX_REF_38` (`MOD_ESTADO`),
  KEY `INDEX_REF_40` (`MOD_ORDEN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `operaciones`
--

DROP TABLE IF EXISTS `operaciones`;
CREATE TABLE `operaciones` (
  `area` smallint(5) unsigned NOT NULL,
  `evento` smallint(5) unsigned NOT NULL,
  `valor` float NOT NULL,
  `fecmon` date NOT NULL,
  `horamon` time NOT NULL,
  PRIMARY KEY  (`area`,`evento`,`fecmon`,`horamon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `ordenent_d`
--

DROP TABLE IF EXISTS `ordenent_d`;
CREATE TABLE `ordenent_d` (
  `id_linea` int(11) NOT NULL auto_increment,
  `id_ordenent` int(11) NOT NULL,
  `id_tiporetiro` smallint(6) default NULL,
  `numlinea` smallint(6) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `codprod` decimal(12,0) NOT NULL default '0',
  `barra` decimal(14,0) NOT NULL default '0',
  `pcosto` decimal(12,2) default '0.00',
  `pventaneto` decimal(12,2) NOT NULL default '0.00',
  `pventaiva` decimal(12,2) default '0.00',
  `totallinea` bigint(20) NOT NULL default '0',
  `cantidade` decimal(10,2) NOT NULL default '0.00',
  `cantidadp` decimal(10,2) default '0.00',
  `cantidadd` decimal(10,2) NOT NULL default '0.00',
  `id_lineadoc` int(11) default NULL,
  `id_documento` varchar(255) default NULL,
  `id_documentof` decimal(12,0) default NULL,
  `id_documentog` decimal(12,0) default NULL,
  `codtipo` char(2) default NULL,
  `codsubtipo` char(2) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL default 'ws',
  `fecmod` datetime default NULL,
  `unimed` varchar(3) default NULL,
  `rutproveedor` int(8) NOT NULL default '0',
  `nomproveedor` varchar(20) default NULL,
  `marcaflete` tinyint(3) unsigned default NULL,
  `instalacion` varchar(2) default NULL,
  `peso` decimal(10,2) default NULL,
  `descuento` decimal(10,0) default NULL,
  `iva` decimal(10,2) default NULL,
  `rete_ica` decimal(5,4) NOT NULL default '0.0000',
  `rete_renta` decimal(5,4) NOT NULL default '0.0000',
  `margenlinea` decimal(6,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id_linea`),
  KEY `fk_reference_26` (`id_tiporetiro`),
  KEY `fk_reference_4` (`id_ordenent`),
  KEY `INDEX_REF_11` (`id_documentof`),
  KEY `INDEX_REF_12` (`id_documentog`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='detalle de la orden de entrega ';

--
-- Table structure for table `ordenent_e`
--

DROP TABLE IF EXISTS `ordenent_e`;
CREATE TABLE `ordenent_e` (
  `id_ordenent` int(11) NOT NULL auto_increment,
  `id_cotizacion` int(11) NOT NULL,
  `id_estado` char(2) NOT NULL,
  `id_tipopago` smallint(6) default NULL,
  `id_tipoentrega` smallint(6) default NULL,
  `id_direccion` int(11) default NULL,
  `id_tipoflujo` smallint(6) default NULL,
  `id_tipodocpago` smallint(6) default NULL,
  `codigovendedor` varchar(20) NOT NULL,
  `rutcliente` decimal(13,0) NOT NULL,
  `rutvendedor` decimal(8,0) default NULL,
  `codlocalventa` varchar(50) NOT NULL,
  `codlocalcsum` varchar(50) NOT NULL,
  `razonsoc` varchar(255) NOT NULL,
  `id_giro` varchar(10) default NULL,
  `giro` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `comuna` varchar(50) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `condicion` varchar(50) NOT NULL,
  `diascondicion` smallint(6) default NULL,
  `fonocontacto` varchar(30) default NULL,
  `observaciones` varchar(255) default NULL,
  `nota` varchar(255) default NULL,
  `id_usuario` int(11) NOT NULL,
  `usuariocrea` varchar(50) NOT NULL,
  `numdocpago` varchar(50) default NULL,
  `obsdesb` varchar(255) default NULL,
  `fechacompra` date default NULL,
  `indmsgsap` tinyint(1) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL default 'ws',
  `fecmod` datetime NOT NULL,
  `fecha_retira_cliente` date NOT NULL,
  `fecha_retira_inmediato` date NOT NULL,
  `fecha_despacho_programado` date NOT NULL,
  `cod_ean` varchar(15) NOT NULL default '0',
  `totaliva` decimal(10,0) NOT NULL default '0',
  `zona` varchar(20) NOT NULL default '0',
  `totaloe` decimal(10,0) NOT NULL default '0',
  `rete_iva_oe` decimal(10,0) NOT NULL,
  PRIMARY KEY  (`id_ordenent`),
  KEY `fk_reference_11` (`id_estado`),
  KEY `fk_reference_19` (`id_direccion`),
  KEY `fk_reference_3` (`id_cotizacion`),
  KEY `fk_reference_31` (`id_tipoflujo`),
  KEY `fk_reference_34` (`id_tipoentrega`),
  KEY `fk_reference_39` (`id_tipopago`),
  KEY `fk_reference_133` (`id_tipodocpago`),
  KEY `INDEX_REF_9` (`codlocalventa`),
  KEY `INDEX_REF_10` (`rutcliente`),
  KEY `INDEX_REF_32` (`razonsoc`),
  KEY `INDEX_REF_33` (`codlocalcsum`),
  KEY `INDEX_REF_34` (`indmsgsap`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='encabezado de la orden de entrega';

--
-- Table structure for table `ordenescompra`
--

DROP TABLE IF EXISTS `ordenescompra`;
CREATE TABLE `ordenescompra` (
  `id_linea` int(10) unsigned NOT NULL,
  `id_ordenent` int(10) unsigned NOT NULL,
  `n_compra` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_linea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ordenpicking_d`
--

DROP TABLE IF EXISTS `ordenpicking_d`;
CREATE TABLE `ordenpicking_d` (
  `id_linea` int(11) NOT NULL auto_increment,
  `id_ordenpicking` int(11) NOT NULL,
  `numlinea` smallint(6) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `codprod` decimal(12,0) NOT NULL,
  `barra` decimal(13,0) default NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `totallinea` bigint(20) NOT NULL default '0',
  `cantidadp` decimal(10,2) default NULL,
  `id_lineadoc` int(10) unsigned default NULL,
  `codtipo` char(2) default NULL,
  `codsubtipo` char(2) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  `unimed` char(3) NOT NULL,
  PRIMARY KEY  (`id_linea`),
  KEY `fk_reference_38` (`id_ordenpicking`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='detalle de la orden de picking';

--
-- Table structure for table `ordenpicking_e`
--

DROP TABLE IF EXISTS `ordenpicking_e`;
CREATE TABLE `ordenpicking_e` (
  `id_ordenpicking` int(11) NOT NULL auto_increment,
  `id_ordenent` int(11) NOT NULL,
  `id_estado` char(2) NOT NULL,
  `id_direccion` int(11) default NULL,
  `rutcliente` decimal(13,0) NOT NULL default '0',
  `cod_local` varchar(50) NOT NULL,
  `razonsoc` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `comuna` varchar(50) NOT NULL,
  `fonocontacto` varchar(50) NOT NULL,
  `observaciones` varchar(255) default NULL,
  `nota` varchar(255) default NULL,
  `id_usuario` int(11) NOT NULL,
  `usuariocrea` varchar(50) NOT NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  `id_prioridad` int(11) NOT NULL default '1',
  `n_impresiones` int(10) unsigned NOT NULL default '0',
  `usuario_impresion` varchar(100) character set latin1 collate latin1_bin NOT NULL default 'NA',
  PRIMARY KEY  (`id_ordenpicking`),
  KEY `fk_reference_18` (`id_ordenent`),
  KEY `fk_reference_30` (`id_direccion`),
  KEY `fk_reference_36` (`id_estado`),
  KEY `INDEX_REF_13` (`rutcliente`),
  KEY `INDEX_REF_14` (`cod_local`),
  KEY `INDEX_REF_36` (`razonsoc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='encabezado de la orden de picking';

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles` (
  `PER_ID` int(8) NOT NULL auto_increment,
  `PER_NOMBRE` varchar(255) default NULL,
  `PER_DESCRIPCION` text,
  `PER_PADRE` int(8) default NULL,
  `PER_USR_CREA` varchar(255) default NULL,
  `PER_FEC_CREA` datetime default NULL,
  `PER_USR_MOD` varchar(255) default NULL,
  `PER_FEC_MOD` datetime default NULL,
  PRIMARY KEY  (`PER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `perfilesxusuario`
--

DROP TABLE IF EXISTS `perfilesxusuario`;
CREATE TABLE `perfilesxusuario` (
  `PEUS_PER_ID` int(8) NOT NULL default '0',
  `PEUS_USR_ID` int(8) NOT NULL default '0',
  `PEUS_USR_CREA` varchar(255) default NULL,
  `PEUS_FEC_CREA` datetime default NULL,
  `PEUS_USR_MOD` varchar(255) default NULL,
  `PEUS_FEC_MOD` datetime default NULL,
  KEY `perfilesxusuario_FKIndex1` (`PEUS_USR_ID`),
  KEY `perfilesxusuario_FKIndex2` (`PEUS_PER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `permisosxmodulo`
--

DROP TABLE IF EXISTS `permisosxmodulo`;
CREATE TABLE `permisosxmodulo` (
  `PEMO_MOD_ID` int(8) NOT NULL default '0',
  `PEMO_TIPO` int(2) NOT NULL default '0',
  `PEMO_PER_ID` int(8) NOT NULL default '0',
  `PEMO_INSERT` int(1) default NULL,
  `PEMO_DELETE` int(1) default NULL,
  `PEMO_UPDATE` int(1) default NULL,
  `PEMO_SELECT` int(1) default NULL,
  `PEMO_USR_CREA` varchar(255) default NULL,
  `PEMO_FEC_CREA` datetime default NULL,
  `PEMO_USR_MOD` varchar(255) default NULL,
  `PEMO_FEC_MOD` datetime default NULL,
  KEY `permisosxmodulo_FKIndex1` (`PEMO_MOD_ID`),
  KEY `permisosxmodulo_FKIndex2` (`PEMO_PER_ID`),
  KEY `permisosxmodulo_FKIndex3` (`PEMO_PER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `prioridad`
--

DROP TABLE IF EXISTS `prioridad`;
CREATE TABLE `prioridad` (
  `id_prioridad` int(11) NOT NULL auto_increment,
  `descripcion` varchar(50) NOT NULL default '',
  `usrcrea` varchar(12) NOT NULL default '',
  `feccrea` datetime NOT NULL default '0000-00-00 00:00:00',
  `usrmod` varchar(12) NOT NULL default '',
  `fecmod` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_prioridad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `producto_tipo`
--

DROP TABLE IF EXISTS `producto_tipo`;
CREATE TABLE `producto_tipo` (
  `id_prod_tipo` varchar(6) NOT NULL,
  `tipificacion_tipo_producto` varchar(60) NOT NULL,
  PRIMARY KEY  (`id_prod_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='especificacion del tipo del producto';

--
-- Table structure for table `prodxSec`
--

DROP TABLE IF EXISTS `prodxSec`;
CREATE TABLE `prodxSec` (
  `cod_prod` varchar(255) default NULL,
  `seccion` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `promo_cve`
--

DROP TABLE IF EXISTS `promo_cve`;
CREATE TABLE `promo_cve` (
  `id_promo` int(10) unsigned NOT NULL auto_increment,
  `descripcion` varchar(30) character set latin1 NOT NULL,
  `subrubro` varchar(30) character set latin1 NOT NULL,
  `cod_local` varchar(10) character set latin1 NOT NULL,
  `rutcliente` varchar(30) character set latin1 default NULL,
  `tipo_valor` varchar(4) character set latin1 NOT NULL,
  `descuento` float NOT NULL,
  `fecini` datetime NOT NULL,
  `fecterm` datetime NOT NULL,
  `usrcrea` varchar(30) character set latin1 NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(30) character set latin1 NOT NULL,
  `fecmod` datetime NOT NULL,
  `tcp_grupo` varchar(45) character set latin1 NOT NULL,
  `estado` varchar(4) character set latin1 NOT NULL,
  PRIMARY KEY  (`id_promo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=DYNAMIC COMMENT='Tabla Promociones  para precios diferenciados';

--
-- Table structure for table `promo_cve2`
--

DROP TABLE IF EXISTS `promo_cve2`;
CREATE TABLE `promo_cve2` (
  `id_promo` int(10) unsigned NOT NULL auto_increment,
  `ean` varchar(30) NOT NULL,
  `subrubro` varchar(30) NOT NULL,
  `id_local` varchar(10) default NULL,
  `rutcliente` varchar(30) NOT NULL,
  `tipo_valor` varchar(4) default NULL,
  `descuento` float default NULL,
  PRIMARY KEY  (`id_promo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla Promociones para precios diferenciados';

--
-- Table structure for table `regimen_contribuyente`
--

DROP TABLE IF EXISTS `regimen_contribuyente`;
CREATE TABLE `regimen_contribuyente` (
  `id_regimencontri` int(10) unsigned NOT NULL auto_increment,
  `descripcionregimen` varchar(45) NOT NULL,
  PRIMARY KEY  (`id_regimencontri`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `id_region` int(11) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_region`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `rubro`
--

DROP TABLE IF EXISTS `rubro`;
CREATE TABLE `rubro` (
  `id_rubro` int(11) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_rubro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='listado de rubros de clientes';

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `codprod` decimal(12,0) NOT NULL,
  `cod_local` varchar(50) NOT NULL,
  `id_ordenent` int(11) default NULL,
  `secuencia` smallint(6) NOT NULL,
  `stock` decimal(10,2) default NULL,
  `consumo` decimal(10,2) NOT NULL,
  `mix` tinyint(1) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`codprod`,`cod_local`,`secuencia`),
  KEY `fk_reference_22` (`id_ordenent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='movimientos de stock de productos';

--
-- Table structure for table `subrubros`
--

DROP TABLE IF EXISTS `subrubros`;
CREATE TABLE `subrubros` (
  `id_catprod_4` int(60) default '0',
  `descat_4` varchar(60) default '0',
  `id_catprod_3` int(60) default NULL,
  `descat_3` varchar(60) default '0',
  `id_catprod_2` int(60) default NULL,
  `descat_2` varchar(60) default '0',
  `id_catprod_1` varchar(30) default '0',
  `descat_1` varchar(30) default '0',
  `feccrea` datetime default '0000-00-00 00:00:00',
  `fecmod` datetime default '0000-00-00 00:00:00',
  `id_catpadre_4` int(60) default NULL,
  `id_catpadre_3` int(60) default NULL,
  `id_catpadre_2` int(60) default NULL,
  `id_catpadre_1` int(255) unsigned default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  USING BTREE (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 12288 kB';

--
-- Table structure for table `tcp`
--

DROP TABLE IF EXISTS `tcp`;
CREATE TABLE `tcp` (
  `tcp_rut` varchar(15) NOT NULL,
  `tcp_grupo` int(10) unsigned NOT NULL,
  `usrcrea` varchar(30) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(30) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  USING BTREE (`tcp_rut`,`tcp_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Grupo de clientes para Promociones CVE';

--
-- Table structure for table `temp_productos`
--

DROP TABLE IF EXISTS `temp_productos`;
CREATE TABLE `temp_productos` (
  `id_producto` int(11) NOT NULL auto_increment,
  `codprod` int(11) NOT NULL,
  PRIMARY KEY  (`id_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='traspasos codigos';

--
-- Table structure for table `teradata`
--

DROP TABLE IF EXISTS `teradata`;
CREATE TABLE `teradata` (
  `idteradata` int(11) NOT NULL auto_increment,
  `id_cotizacion` int(20) NOT NULL,
  `detalle` int(1) NOT NULL,
  `encabezado` int(1) NOT NULL,
  `fecha_proceso` date NOT NULL,
  `fecha_paso_interfase` datetime NOT NULL,
  `secuencia` int(2) NOT NULL,
  `archivo` varchar(45) NOT NULL,
  `codprod` int(10) default NULL,
  PRIMARY KEY  (`idteradata`),
  KEY `Sec` (`fecha_proceso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Log de la tabla Teradata';

--
-- Table structure for table `tipocliente`
--

DROP TABLE IF EXISTS `tipocliente`;
CREATE TABLE `tipocliente` (
  `id_tipocliente` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipocliente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='cliente sap o no';

--
-- Table structure for table `tipocondicionpago`
--

DROP TABLE IF EXISTS `tipocondicionpago`;
CREATE TABLE `tipocondicionpago` (
  `id_tipoconpago` int(4) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipoconpago`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='contado, crédito';

--
-- Table structure for table `tipocontribuyente`
--

DROP TABLE IF EXISTS `tipocontribuyente`;
CREATE TABLE `tipocontribuyente` (
  `id_contribuyente` int(10) unsigned NOT NULL auto_increment,
  `descripcion` varchar(80) NOT NULL,
  `admitido` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_contribuyente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `tipodocpago`
--

DROP TABLE IF EXISTS `tipodocpago`;
CREATE TABLE `tipodocpago` (
  `id_tipodocpago` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `reqnumdoc` tinyint(1) default NULL,
  `id_tipopago` smallint(5) unsigned default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipodocpago`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='cheque, efectivo, valel vista, tarjeta crédito, etc.';

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE `tipodocumento` (
  `id_tipodocumento` smallint(6) NOT NULL,
  `sigtipodoc` char(3) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipodocumento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='factura, guía despacho, boleta, nota de crédito';

--
-- Table structure for table `tipoentrega`
--

DROP TABLE IF EXISTS `tipoentrega`;
CREATE TABLE `tipoentrega` (
  `id_tipoentrega` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipoentrega`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='retira cliente, despacho domicilio';

--
-- Table structure for table `tipoflujo`
--

DROP TABLE IF EXISTS `tipoflujo`;
CREATE TABLE `tipoflujo` (
  `id_tipoflujo` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `nomtflujo` varchar(50) default NULL,
  `tipoz` char(3) default NULL,
  `tipofacturacion` varchar(4) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipoflujo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='despacho/retiro desde proveedor facturación diferida\r\nretir';

--
-- Table structure for table `tipogiro`
--

DROP TABLE IF EXISTS `tipogiro`;
CREATE TABLE `tipogiro` (
  `id_giro` varchar(10) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) default NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) default NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_giro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='listado de giros del sii';

--
-- Table structure for table `tipomensaje`
--

DROP TABLE IF EXISTS `tipomensaje`;
CREATE TABLE `tipomensaje` (
  `id_tipomensaje` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipomensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='ndv, rebajas de stock, reversa stock, etc';

--
-- Table structure for table `tipomovimiento`
--

DROP TABLE IF EXISTS `tipomovimiento`;
CREATE TABLE `tipomovimiento` (
  `id_tipomovimiento` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipomovimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='cargo, abono, incremento, decremento';

--
-- Table structure for table `tipoorigen`
--

DROP TABLE IF EXISTS `tipoorigen`;
CREATE TABLE `tipoorigen` (
  `id_tipoorigen` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipoorigen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='cve, sap';

--
-- Table structure for table `tipopago`
--

DROP TABLE IF EXISTS `tipopago`;
CREATE TABLE `tipopago` (
  `id_tipopago` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipopago`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='contado, crédito';

--
-- Table structure for table `tiporetiro`
--

DROP TABLE IF EXISTS `tiporetiro`;
CREATE TABLE `tiporetiro` (
  `id_tiporetiro` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tiporetiro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='retira cliente posterior, retira cliente inmediato';

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE `tipousuario` (
  `id_tipousuario` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipousuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='usuario normal, usuario vendedor';

--
-- Table structure for table `tipoventa`
--

DROP TABLE IF EXISTS `tipoventa`;
CREATE TABLE `tipoventa` (
  `id_tipoventa` smallint(6) NOT NULL,
  `descripcion` varchar(50) default NULL,
  `usrcrea` varchar(12) NOT NULL,
  `feccrea` datetime NOT NULL,
  `usrmod` varchar(12) NOT NULL,
  `fecmod` datetime NOT NULL,
  PRIMARY KEY  (`id_tipoventa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='venta calzada, venta mayorista';

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE `tracking` (
  `id_tracking` int(10) unsigned NOT NULL auto_increment,
  `id_cotizacion` int(10) unsigned default NULL,
  `id_ordenent` int(10) unsigned default NULL,
  `id_ordenpicking` int(10) unsigned default NULL,
  `id_documento` int(10) unsigned default NULL,
  `tipo` varchar(10) NOT NULL default '',
  `descripcion` varchar(255) character set latin1 collate latin1_bin default NULL,
  `usrcrea` varchar(12) character set latin1 collate latin1_bin NOT NULL default '',
  `feccrea` datetime NOT NULL default '0000-00-00 00:00:00',
  `usrmod` varchar(12) character set latin1 collate latin1_bin default NULL,
  `fecmod` datetime default NULL,
  PRIMARY KEY  (`id_tracking`),
  KEY `INDEX_REF_16` (`id_cotizacion`),
  KEY `INDEX_REF_17` (`id_ordenent`),
  KEY `INDEX_REF_18` (`id_ordenpicking`),
  KEY `INDEX_REF_19` (`id_documento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL auto_increment,
  `id_tipousuario` smallint(6) default NULL,
  `cod_local` varchar(5) default NULL,
  `codigovendedor` varchar(20) NOT NULL,
  `rutvendedor` decimal(8,0) default NULL,
  `usr_nombres` varchar(255) default NULL,
  `usr_apellidos` varchar(255) default NULL,
  `usr_email` varchar(255) default NULL,
  `usr_login` varchar(255) default NULL,
  `usr_clave` varchar(255) default NULL,
  `usr_estado` int(2) default NULL,
  `usr_tipo` int(1) default NULL,
  `usr_ult_login` datetime default NULL,
  `usr_est_login` int(2) default NULL,
  `usr_puesto` varchar(255) default NULL,
  `usr_depto` varchar(255) default NULL,
  `usr_organizacion` varchar(255) default NULL,
  `usr_fono` varchar(255) default NULL,
  `usr_fax` varchar(255) default NULL,
  `usr_web` varchar(255) default NULL,
  `usr_calle` varchar(255) default NULL,
  `usr_ciudad` varchar(255) default NULL,
  `usr_provincia` varchar(255) default NULL,
  `usr_cod_pos` varchar(255) default NULL,
  `usr_pais` varchar(255) default NULL,
  `usr_dat_extras` text,
  `impresorag` varchar(45) default NULL,
  `usr_usr_crea` varchar(255) default NULL,
  `usr_fec_crea` datetime default NULL,
  `usr_usr_mod` varchar(255) default NULL,
  `usr_fec_mod` datetime default NULL,
  PRIMARY KEY  (`usr_id`),
  KEY `fk_reference_29` (`id_tipousuario`),
  KEY `fk_reference_80` (`cod_local`),
  KEY `INDEX_REF_20` (`codigovendedor`),
  KEY `INDEX_REF_39` (`usr_login`),
  KEY `INDEX_REF_41` (`usr_estado`),
  KEY `INDEX_REF_42` (`usr_clave`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping routines for database 'cvecolprod'
--
DELIMITER ;;
/*!50003 DROP PROCEDURE IF EXISTS `calculo_impuestos` */;;
/*!50003 SET SESSION SQL_MODE=""*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`10.128.2.114`*/ /*!50003 PROCEDURE `calculo_impuestos`(IN idoe INTEGER)
BEGIN

DECLARE ivacoti,reicacoti,reterentacoti,totalcoti,totreterenta,totreteica,total,totalciva,idcotizacion,activareteiva integer;
DECLARE datosencoe CURSOR FOR SELECT id_cotizacion,if(rete_iva_oe > 0,true,false) FROM ordenent_e WHERE id_ordenent = idoe;
DECLARE datosdetoe CURSOR FOR SELECT         sum(round((totallinea/((iva/100)+1))*(rete_renta/100))) as reterenta,
                                             sum(round((totallinea/((iva/100)+1))*(rete_ica/100))) as reteica,
                                             sum(round((totallinea/((iva/100)+1))*(iva/100))) as ivatotal,
                                             sum(round(totallinea)) as totalconiva
                    FROM 	ordenent_d cd
                    JOIN 	tiporetiro tr on (tr.id_tiporetiro=cd.id_tiporetiro)
                    WHERE
                    id_ordenent = idoe group by id_ordenent;
DECLARE datosenccot CURSOR FOR SELECT              sum(round((totallinea/((cot_iva/100)+1))*(cot_iva/100))) as cot_iva,
                                                   sum(round((totallinea/((cot_iva/100)+1))*(rete_ica/100))) as rete_ica,
                                                   sum(round((totallinea/((cot_iva/100)+1))*(rete_renta/100))) as rete_renta,
                                                   sum(round(totallinea)) as totallinea
                    FROM 	cotizacion_d
                    WHERE
                    id_cotizacion = idcotizacion group by id_cotizacion;

OPEN datosencoe;
FETCH datosencoe INTO idcotizacion,activareteiva;
CLOSE datosencoe;

OPEN datosdetoe;
FETCH datosdetoe INTO totreterenta,totreteica,total,totalciva;
CLOSE datosdetoe;


IF activareteiva is true THEN
update ordenent_e set totaloe=(totalciva-totreterenta-totreteica-round(total/2)),totaliva=total,rete_iva_oe=round(total/2) where id_ordenent=idoe;
ELSE
update ordenent_e set totaloe=(totalciva-totreterenta-totreteica),totaliva=total,rete_iva_oe=0 where id_ordenent=idoe;
END IF;

OPEN datosenccot;
FETCH datosenccot INTO ivacoti,reicacoti,reterentacoti,totalcoti;
CLOSE datosenccot;

IF activareteiva is true THEN
update cotizacion_e set rete_iva=round(ivacoti/2),rete_ica=reicacoti,rete_renta=reterentacoti,cot_iva=ivacoti,valortotal=(totalcoti-(round(ivacoti/2))-reicacoti-reterentacoti) where id_cotizacion=idcotizacion;
ELSE
update cotizacion_e set rete_ica=reicacoti,rete_renta=reterentacoti,cot_iva=ivacoti,valortotal=(totalcoti-reicacoti-reterentacoti) where id_cotizacion=idcotizacion;
END IF;

END */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
DELIMITER ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

