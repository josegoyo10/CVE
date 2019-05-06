/*
	cloneFieldset.js
	by Nathan Smith, sonspring.com

	Additional credits:
	> Ara Pehlivanian, arapehlivanian.com
	> Jeremy Keith, adactio.com
	> Jonathan Snook, snook.ca
	> Peter-Paul Koch, quirksmode.org
*/


// insertAfter function, by Jeremy Keith
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


// Delete nearest parent fieldset
function deleteMe(a)
{
	var duplicate = a.parentNode;
	while (duplicate.nodeName.toLowerCase() != 'fieldset')
	{
		duplicate = duplicate.parentNode;
	}
	duplicate.parentNode.removeChild(duplicate);
}