
// JavaScript Document
function KeyIsPOS(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 46 || /*punto*/
			 evt.which == 95 || /*underscore*/
			 evt.which == 32 || /*esopacio*/
			(evt.which >= 48 && evt.which <=  57) || /*[0-9]*/
			(evt.which >= 97 && evt.which <= 122) || /*[a-z]*/
			(evt.which >= 65 && evt.which <=  90)    /*[A-Z]*/ )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 46 || /*punto*/
			 evt.keyCode == 95 || /*underscore*/
			 evt.keyCode == 32 || /*esopacio*/
			(evt.keyCode >= 48 && evt.keyCode <=  57) || /*[0-9]*/
			(evt.keyCode >= 97 && evt.keyCode <= 122) || /*[a-z]*/
			(evt.keyCode >= 65 && evt.keyCode <=  90)    /*[A-Z]*/ )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsNumber(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 13 || evt.which == 44 || evt.which == 8 || (evt.which >= 48 &&  evt.which <=57) )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 13 || evt.keyCode == 44 || evt.keyCode == 8 || (evt.keyCode >= 48 && evt.keyCode <= 57) )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////////////
function KeyIsNumberInt(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if (evt.which >= 48 &&  evt.which <=57)
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if (evt.keyCode >= 48 && evt.keyCode <= 57)
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsNumberDecimal(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 13 || evt.which == 8 || evt.which == 46 || (evt.which >= 48 &&  evt.which <=57) )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 13 || evt.keyCode == 8 || evt.keyCode == 46 || (evt.keyCode >= 48 && evt.keyCode <= 57) )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsLetraSinEspacio(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 209 || evt.which == 241 || evt.which == 13 || evt.which == 8 || (evt.which >= 65 &&  evt.which <=90) || (evt.which >= 97 &&  evt.which <=122))
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 209 || evt.keyCode == 241 || evt.keyCode == 13 || evt.keyCode == 8 || (evt.keyCode >= 65 && evt.keyCode <= 90) || (evt.keyCode >= 97 && evt.keyCode <= 122))
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsLetra(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 209 || evt.which == 241 || evt.which == 13 || evt.which == 8 || (evt.which >= 65 &&  evt.which <=90) || (evt.which >= 97 &&  evt.which <=122) || evt.which == 32)
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		//if ( evt.keyCode == 13 || evt.keyCode == 8 || (evt.keyCode >= 65 && evt.keyCode <= 90) || (evt.keyCode >= 97 && evt.keyCode <= 122) || evt.keyCode == 225 || evt.keyCode == 233 || evt.keyCode == 237 || evt.keyCode == 243 || evt.keyCode == 250 || evt.keyCode == 193 || evt.keyCode == 201 || evt.keyCode == 205 || evt.keyCode == 211 || evt.keyCode == 218 )
		if ( evt.keyCode == 209 || evt.keyCode == 241 || evt.keyCode == 13 || evt.keyCode == 8 || (evt.keyCode >= 65 && evt.keyCode <= 90) || (evt.keyCode >= 97 && evt.keyCode <= 122) || evt.keyCode == 32 )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}

/////////////////////////////////////////////////
selectfp1=0;	selectfp2=0; 	selectfp3=0;
function bloqueabeneficio(elemento) {
	formulario = document.nueva_promo_03;
	
	if ((formulario.selectfp1.selectedIndex==formulario.selectfp2.selectedIndex && formulario.selectfp1.selectedIndex != 0 ) || 
		(formulario.selectfp2.selectedIndex==formulario.selectfp3.selectedIndex && formulario.selectfp2.selectedIndex != 0 ) ||
		(formulario.selectfp3.selectedIndex==formulario.selectfp1.selectedIndex && formulario.selectfp3.selectedIndex != 0 )) {

		elemento.selectedIndex = eval(elemento.name);
		alert('El tipo de pago ya fue seleccionado. Seleccione uno diferente');
		return;
	}

	if (formulario.selectfp1.selectedIndex==0) {
		formulario.selectfp2.selectedIndex=0;
		formulario.selectfp2.disabled = true;
		formulario.selectfp3.selectedIndex=0;
		formulario.selectfp3.disabled = true;
		formulario.textfieldfp2.value = 0;
		formulario.textfieldfp2.disabled = true;
		formulario.textfieldfp3.value = 0;
		formulario.textfieldfp3.disabled = true;
	}
	else {
		formulario.selectfp2.disabled = false;
		formulario.selectfp3.disabled = false;
		formulario.textfieldfp2.disabled = false;
		formulario.textfieldfp3.disabled = false;
	}

	if (formulario.selectfp2.selectedIndex==0) {
		formulario.selectfp3.selectedIndex=0;
		formulario.selectfp3.disabled = true;
		formulario.textfieldfp3.value = 0;
		formulario.textfieldfp3.disabled = true;
	}
	else {
		formulario.selectfp3.disabled = false;
		formulario.textfieldfp3.disabled = false;
	}

	selectfp1 = formulario.selectfp1.selectedIndex;
	selectfp2 = formulario.selectfp2.selectedIndex;
	selectfp3 = formulario.selectfp3.selectedIndex;
	return false;
}

function bloqueabeneficio2(elemento) {
	formulario = document.nueva_promo_03;
	
	if ((formulario.selectfp1.selectedIndex==formulario.selectfp2.selectedIndex && formulario.selectfp1.selectedIndex != 0 ) || 
		(formulario.selectfp2.selectedIndex==formulario.selectfp3.selectedIndex && formulario.selectfp2.selectedIndex != 0 ) ||
		(formulario.selectfp3.selectedIndex==formulario.selectfp1.selectedIndex && formulario.selectfp3.selectedIndex != 0 )) {

		elemento.selectedIndex = eval(elemento.name);
		alert('El tipo de pago ya fue seleccionado. Seleccione uno diferente');
		return;
	}

	if (formulario.selectfp1.selectedIndex==0) {
		formulario.selectfp2.selectedIndex=0;
		formulario.selectfp2.disabled = true;
		formulario.selectfp3.selectedIndex=0;
		formulario.selectfp3.disabled = true;
		formulario.select1fp2.selectedIndex=0;
		formulario.select1fp2.disabled = true;
		formulario.select2fp2.selectedIndex=0;
		formulario.select2fp2.disabled = true;
		formulario.select1fp3.selectedIndex=0;
		formulario.select1fp3.disabled = true;
		formulario.select2fp3.selectedIndex=0;
		formulario.select2fp3.disabled = true;
	}
	else {
		formulario.selectfp2.disabled = false;
		formulario.selectfp3.disabled = false;
		formulario.select1fp2.disabled = false;
		formulario.select2fp2.disabled = false;
		formulario.select1fp3.disabled = false;
		formulario.select2fp3.disabled = false;
	}

	if (formulario.selectfp2.selectedIndex==0) {
		formulario.selectfp3.selectedIndex=0;
		formulario.selectfp3.disabled = true;
		formulario.select1fp3.selectedIndex=0;
		formulario.select1fp3.disabled = true;
		formulario.select2fp3.selectedIndex=0;
		formulario.select2fp3.disabled = true;
	}
	else {
		formulario.selectfp3.disabled = false;
		formulario.select1fp3.disabled = false;
		formulario.select2fp3.disabled = false;
	}

	selectfp1 = formulario.selectfp1.selectedIndex;
	selectfp2 = formulario.selectfp2.selectedIndex;
	selectfp3 = formulario.selectfp3.selectedIndex;
	return false;
}
//////////////////////////////////////////
function KeyIsRut(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if  ( evt.which == 13 || evt.which == 46 || /*punto*/ evt.which == 45 ||
			(evt.which >= 48 && evt.which <=  57)/*[0-9]*/)
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 13 || evt.keyCode == 46 || /*punto*/ evt.keyCode == 45 ||
			(evt.keyCode >= 48 && evt.keyCode <=  57)/*[0-9]*/)
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsTexto(evt)/* NO permite ' " $ / \ &  */
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 34 ||  evt.which == 36 || evt.which == 38 || evt.which == 39 || evt.which == 60 || evt.keyCode == 62 || evt.which == 47 || evt.which == 92 )
		return false;
	return true;
	}
	else if (isIE)
		{evt = window.event;
		if (evt.keyCode == 34 || evt.keyCode == 36 || evt.keyCode == 38 || evt.keyCode == 39 || evt.keyCode == 60 || evt.keyCode == 62 || evt.keyCode == 47 || evt.keyCode == 92)
		return false;
	return true;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////////////
function IpIsKey(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 46 || evt.which == 13 || evt.which == 44 || evt.which == 8 || (evt.which >= 48 &&  evt.which <=57) )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if (evt.keyCode == 46 || evt.keyCode == 13 || evt.keyCode == 8 || (evt.keyCode >= 48 && evt.keyCode <= 57) )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function KeyIsTelefono(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if ( evt.which == 32 || evt.which == 40 || evt.which == 41 || evt.which == 45 || (evt.which >= 48 &&  evt.which <=57) || (evt.which <= 34 &&  evt.which >=39)  )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 32 || evt.keyCode == 40 || evt.keyCode == 41  || evt.keyCode == 45 || (evt.keyCode >= 48 && evt.keyCode <= 57)|| (evt.keyCode <= 34 && evt.keyCode >= 39) )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}

////////////////////////////////////////////////
function KeyIsRuta(evt)/*  acepta una ruta para impresora */
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if (evt.which==32 || evt.which==95 || evt.which==92 || evt.which==47 ||evt.which==46 || (evt.which >= 48 &&  evt.which <=57) || (evt.which >= 65 &&  evt.which <=90) || (evt.which >= 97 &&  evt.which <=122) )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if (evt.keyCode==32 || evt.keyCode==95 || evt.keyCode==92 || evt.keyCode==47 || evt.keyCode==46 || (evt.keyCode >= 48 && evt.keyCode <= 57) || (evt.keyCode >= 65 && evt.keyCode <= 90) || (evt.keyCode >= 97 && evt.keyCode <= 122))
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}

function IsNumeric(valor) 
{ 
	var log=valor.length; 
	var sw="S"; 
	
	for (x=0; x<log; x++){
		v1=valor.substr(x,1); 
		v2 = parseInt(v1); 
		//Compruebo si es un valor numérico 
		if (isNaN(v2)){ 
			sw= "N";
		} 
	} 
	if (sw=="S"){
		return true;
	}else{
		return false;
	} 


function checkNumber(val) {
  var strPass = val.value;
  var strLength = strPass.length;
  var lchar = val.value.charAt((strLength) - 1);
  var cCode = CalcKeyCode(lchar);

  /* Check if the keyed in character is a number
     do you want alphabetic UPPERCASE only ?
     or lower case only just check their respective
     codes and replace the 48 and 57 */

  if (cCode < 48 || cCode > 57 ) {
    var myNumber = val.value.substring(0, (strLength) - 1);
    val.value = myNumber;
  }
  return false;
}
} 


