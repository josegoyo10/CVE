function ir_pagina( pagina ) {
	location.href = pagina;
}

function validar_eliminar( mensaje, pagina ) {
    if ( confirm( mensaje ) ) {
        location.href = pagina;
    }
}

function validar_obligatorio( objeto, mensaje ) {
	if( objeto.value == '' ) {
		alert( mensaje );
		objeto.focus();
		return true;
	}
}
function validar_obligatorio_sin_focus( objeto, mensaje ) {
	if( objeto.value == '' ) {
		alert( mensaje );
		return true;
	}
}
function validar_numero( objeto, mensaje ) {
	if( isNaN(objeto.value) ) {
		alert( mensaje );
		objeto.focus();
		objeto.select();
		return true;
	}
}

function cambiar_color_on( id ){
	id.style.background = '#FFCC33';
}
function cambiar_color_off( id ){
	id.style.background = '#FFFFFF';
}

function makeOptionList(objeto, name,value, sel) {
	var o=new Option( name,value);
	objeto.options[objeto.length]=o;
	if( sel == 1 )
		objeto.selectedIndex = objeto.length-1;
}

function cerrar_caja( obj ) {
	obj.style.visibility = "hidden";
}

function generar_caja( x, y, contenido, obj ) {
	obj.style.left = x;
	obj.style.top = y;
	obj.style.visibility = "visible";

	aux_contenido = "<A HREF='#' onclick=\"cerrar_caja(document.all['PopUpCalendar']);\">cerrar</A><br>" + contenido;

	document.all["PopUpCalendar"].innerHTML = aux_contenido;
}
// JavaScript Document
function RutIsKey(evt)
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if  ( evt.which == 46 || /*punto*/ evt.which == 45 ||
			(evt.which >= 48 && evt.which <=  57) || /*[0-9]*/
			(evt.which == 75 || evt.which ==  107)    /*[kK]*/ )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if ( evt.keyCode == 46 || /*punto*/ evt.keyCode == 45 ||
			(evt.keyCode >= 48 && evt.keyCode <=  57) || /*[0-9]*/
			(evt.keyCode == 75 || evt.keyCode ==  107)    /*[kK]*/ )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function NumberIsKey(evt)
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
		if ( evt.keyCode == 13 || evt.keyCode == 8 || (evt.keyCode >= 48 && evt.keyCode <= 57) )
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}
////////////////////////////////////////////////
function LetraIsKey(evt)
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
/////////////////////////////////////////////////////
/*Funcion que convierte UPPER CASE el valor de un campo de texto*/
function Upper(campo) {
	campo.value = campo.value.toUpperCase();
}

////////////////////////////////////////////////
function KeyIsRuta(evt)/*  acepta una ruta para impresora */
{
var isNav = (navigator.appName.indexOf("Netscape") != -1)
var isIE = (navigator.appName.indexOf("Microsoft") != -1)

	if (isNav) {
		if (evt.which==32 || evt.which==95 || evt.which==92 || evt.which==47 || (evt.which >= 48 &&  evt.which <=57) || (evt.which >= 65 &&  evt.which <=90) || (evt.which >= 97 &&  evt.which <=122) )
		return true;
	return false;
	}
	else if (isIE)
		{evt = window.event;
		if (evt.keyCode==32 || evt.keyCode==95 || evt.keyCode==92 || evt.keyCode==47 || (evt.keyCode >= 48 && evt.keyCode <= 57) || (evt.keyCode >= 65 && evt.keyCode <= 90) || (evt.keyCode >= 97 && evt.keyCode <= 122))
			return true;
		return false;
		}
	else {
		alert("Su browser no es soportado por esta aplicación")
	}
	return false
}

////////////////////////////////////////////////
function insertAfter(newElement, targetElement)
{
	var parent = targetElement.parentNode;
	if (parent.lastChild == targetElement)
	{
		parent.appendChild(newElement);
	}
	else
	{
		parent.insertBefore(newElement, targetElement.nextSibling);
	}
}


// Suffix + Counter
var suffix = ':';
var counter = 1;


// Clone nearest parent fieldset
function cloneMe(a)
{
	// Increment counter
	counter++;

	// Find nearest parent fieldset
	var original = a.parentNode;
	while (original.nodeName.toLowerCase() != 'fieldset')
	{
		original = original.parentNode;
	}
	var duplicate = original.cloneNode(true);

	// Label - For and ID
	var newLabel = duplicate.getElementsByTagName('label');
	for (var i = 0; i < newLabel.length; i++)
	{
		var labelFor = newLabel[i].htmlFor
		if (labelFor)
		{
			oldFor = labelFor.indexOf(suffix) == -1 ? labelFor : labelFor.substring(0, labelFor.indexOf(suffix));
			newLabel[i].htmlFor = oldFor + suffix + counter;
		}
		var labelId = newLabel[i].id
		if (labelId)
		{
			oldId = labelId.indexOf(suffix) == -1 ? labelId : labelId.substring(0, labelId.indexOf(suffix));
			newLabel[i].id = oldId + suffix + counter;
		}
	}

	// Input - Name + ID
	var newInput = duplicate.getElementsByTagName('input');
	for (var i = 0; i < newInput.length; i++)
	{
		var inputName = newInput[i].name
		if (inputName)
		{
			oldName = inputName.indexOf(suffix) == -1 ? inputName : inputName.substring(0, inputName.indexOf(suffix));
			newInput[i].name = oldName + suffix + counter;
		}
		var inputId = newInput[i].id
		if (inputId)
		{
			oldId = inputId.indexOf(suffix) == -1 ? inputId : inputId.substring(0, inputId.indexOf(suffix));
			newInput[i].id = oldId + suffix + counter;
		}
	}
	
	// Select - Name + ID
	var newSelect = duplicate.getElementsByTagName('select');
	for (var i = 0; i < newSelect.length; i++)
	{
		var selectName = newSelect[i].name
		if (selectName)
		{
			oldName = selectName.indexOf(suffix) == -1 ? selectName : selectName.substring(0, selectName.indexOf(suffix));
			newSelect[i].name = oldName + suffix + counter;
		}
		var selectId = newSelect[i].id
		if (selectId)
		{
			oldId = selectId.indexOf(suffix) == -1 ? selectId : selectId.substring(0, selectId.indexOf(suffix));
			newSelect[i].id = oldId + suffix + counter;
		}
	}

	// Textarea - Name + ID
	var newTextarea = duplicate.getElementsByTagName('textarea');
	for (var i = 0; i < newTextarea.length; i++)
	{
		var textareaName = newTextarea[i].name
		if (textareaName)
		{
			oldName = textareaName.indexOf(suffix) == -1 ? textareaName : textareaName.substring(0, textareaName.indexOf(suffix));
			newTextarea[i].name = oldName + suffix + counter;
		}
		var textareaId = newTextarea[i].id
		if (textareaId)
		{
			oldId = textareaId.indexOf(suffix) == -1 ? textareaId : textareaId.substring(0, textareaId.indexOf(suffix));
			newTextarea[i].id = oldId + suffix + counter;
		}
	}

	duplicate.className = 'duplicate';
	insertAfter(duplicate, original);
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
 
function trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}
 
////////////////////////////////////////////////