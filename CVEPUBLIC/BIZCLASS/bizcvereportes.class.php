<?php
class bizcvereportes{
	
	public  static  function getReporteTransferenciaMercancia($List){
		try {
        	    $obj = new ctrlreporte;
            	return $obj->getReporteTransferenciaMercancia($List);
			}
		
    	catch (BUSException $e){general::dspmsgerr($e->getMessage());return false;}
		catch (SYSException $e){general::dspsyserr($e->getMessage());return false;}
		catch (Exception 	$e){general::dspsyserr($e->getMessage());return false;}
	}

}
?>