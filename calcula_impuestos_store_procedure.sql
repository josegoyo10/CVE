DELIMITER $$

DROP PROCEDURE IF EXISTS `cvecoltest`.`calculo_impuestos` $$
CREATE PROCEDURE `cvecoltest`.`calculo_impuestos` (IN idoe INTEGER)
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

END $$

DELIMITER;