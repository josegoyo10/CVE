/**
 * Functions for the ImageManager, used by manager.php only
 * Modifications for TinyMCE - Ryan Demmer
 *@author $Author: Wei Zhuo $
 * @version $Id: manager.js 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */


        function myRegexpReplace(in_str, reg_exp, replace_str, opts) {
        if (typeof opts == "undefined")
            opts = 'g';
        var re = new RegExp(reg_exp, opts);
        return in_str.replace(re, replace_str);
        }

        //set the alignment options
        function setAlign(align)
        {
                var selection = document.getElementById('f_align');
                for(var i = 0; i < selection.length; i++)
                {
                        if(selection.options[i].value == align)
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }
        }

        //initialise the form
        //Added modifications for TinyMCE - Ryan Demmer
        init = function ()
        {
                var arrOnOver = new Array(), arrOnOut  = new Array();
                var strOnOver = "", strOnOut  = "";
                var formObj = document.forms[0];
                var uploadForm = document.getElementById('uploadForm');
                if(uploadForm) uploadForm.target = 'imgManager';

                var selection = document.getElementById('f_align');
                for(var i = 0; i < selection.length; i++)
                {
                        if(selection.options[i].value == tinyMCE.getWindowArg('align'))
                        {
                                selection.selectedIndex = i;
                                break;
                        }
                }

                document.getElementById('f_url').value = tinyMCE.getWindowArg('src');
                document.getElementById('f_alt').value = tinyMCE.getWindowArg('alt');
                document.getElementById('f_width').value = tinyMCE.getWindowArg('width');
                document.getElementById('f_height').value = tinyMCE.getWindowArg('height');
                document.getElementById('f_border').value = tinyMCE.getWindowArg('border');
                document.getElementById('f_vert').value = tinyMCE.getWindowArg('vspace');
                document.getElementById('f_horiz').value = tinyMCE.getWindowArg('hspace');
                document.getElementById('original_width').value = tinyMCE.getWindowArg('width');
                document.getElementById('original_height').value = tinyMCE.getWindowArg('height');

                // supporting onmouse over / out for image swap ...Michael Keck (me@michaelkeck.de)
                arrOnOver            = tinyMCE.getWindowArg('onmouseover').split(';');
                arrOnOut             = tinyMCE.getWindowArg('onmouseout').split(';');
                for (var i=0; i<arrOnOver.length; i++) {
                if (arrOnOver[i].indexOf('this.src=\'')!=-1) {
                    strOnOver = arrOnOver[i];
                    break;
                    }
                }
                for (var i=0; i<arrOnOut.length; i++) {
                     if (arrOnOut[i].indexOf('this.src=\'')!=-1) {
                     strOnOut = arrOnOut[i];
                     break;
                     }
                }
                if (strOnOver!='') {
                    strOnOver = myRegexpReplace(strOnOver,"this.src='","","gi");
                    strOnOver = myRegexpReplace(strOnOver,"'","","gi");
                    strOnOver = myRegexpReplace(strOnOver,";","","gi");
                }
                if (strOnOut!='') {
                    strOnOut = myRegexpReplace(strOnOut,"this.src='","","gi");
                    strOnOut = myRegexpReplace(strOnOut,"'","","gi");
                    strOnOut = myRegexpReplace(strOnOut,";","","gi");
                }
                if (strOnOver!='' && strOnOut!='') {
                    setOnMouseInput('enabled');
                    formObj.onmousemove.checked = true;
                    formObj.onmouseover.value   = strOnOver;
                    formObj.onmouseout.value    = strOnOut;
                } else {
                setOnMouseInput('disabled');
                formObj.onmousemove.checked = false;
                formObj.onmouseover.value   = '';
                formObj.onmouseout.value    = '';
                }

                setPopupImage('disabled');
                formObj.popupenable.checked = false;
                formObj.popupthumb.value   = '';
                formObj.thumbcaption.checked = false;

                window.focus();
        }

        //Added modifications for TinyMCE - Ryan Demmer
        function onCancel()
        {
                top.close();
                //__dlg_close(null);
                return false;
        };

// supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
// this function is needed for visual show, if onmouse over/out available
    function setOnMouseInput(stat){
        var formObj = document.forms[0];
        if (stat=='enabled') {
            formObj.onmouseover.disabled = false;
            formObj.onmouseout.disabled  = false;
            formObj.popupenable.disabled = true;
            formObj.thumbcaption.disabled = true;

            if (document.getElementById) {
                document.getElementById('showInput1').style.color="#000000";
                document.getElementById('showInput2').style.color="#000000";
                document.getElementById('showInput5').style.color="#000000";
            }
            formObj.onmouseout.value     = document.getElementById('f_url').value;
        } else {
            formObj.onmouseover.disabled = true;
            formObj.onmouseout.disabled  =true;
            formObj.popupenable.disabled = false;
            formObj.thumbcaption.disabled = false;
            if (document.getElementById) {
                document.getElementById('showInput1').style.color="#666666";
                document.getElementById('showInput2').style.color="#666666";
                document.getElementById('showInput5').style.color="#666666";
            }
        }
    }


// supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
// this function is needed for visual show, if onmouse over/out available
    function setPopupImage(stat){
        var formObj = document.forms[0];
        if (stat=='enabled') {
            formObj.popupthumb.disabled = false;
            formObj.thumbcaption.disabled = false;
            formObj.onmousemove.disabled = true;
            formObj.onmouseheight.disabled = true;
            formObj.onmousewidth.disabled = true;
            if (document.getElementById) {
                document.getElementById('showInput3').style.color="#000000";
                document.getElementById('showInput4').style.color="#000000";
                document.getElementById('showInput6').style.color="#000000";
            }

        } else {
            formObj.popupthumb.disabled = true;
            formObj.onmousemove.disabled = false;
            formObj.onmouseheight.disabled = false;
            formObj.onmousewidth.disabled = false;
            if (document.getElementById) {
                document.getElementById('showInput3').style.color="#666666";
                document.getElementById('showInput4').style.color="#666666";
                document.getElementById('showInput6').style.color="#666666";
            }
        }
    }
        //Added modifications for TinyMCE - Ryan Demmer
        //Added Mouseover and Popup functionality - Ryan Demmer Feb 2005
        function onOK()
        {
        var required = {
                         "f_url": "Please enter a URL, choose an image or Cancel"
                         };
                        for (var i in required) {
                              var el = MM_findObj(i);
                              if (!el.value) {
                              alert(required[i]);
                              el.focus();
                              return false;
                        }
        }
                  if (window.opener) {
                      if (document.getElementById("popupthumb").disabled == false){

                        var thumbSrc    = document.getElementById("popupthumb").value;
                        var popupSrc = document.getElementById("f_url").value;
                        var popupWidth = document.getElementById("f_width").value;
                        var popupHeight = document.getElementById("f_height").value;
                        var popupName = document.getElementById("f_alt").value;
                        var popupAlign = document.getElementById('f_align').options[document.getElementById('f_align').selectedIndex].value;
                        var popupVspace = document.getElementById("f_vert").value;
                        var popupHspace = document.getElementById("f_horiz").value;
                        var popupBorder = document.getElementById("f_border").value;
						
						var popupClose =  document.getElementById("popupClose").value;
                        var thumbWidth = document.getElementById("thumbWidth").value;
                        var thumbHeight = document.getElementById("thumbHeight").value;

                        if (document.getElementById("thumbcaption").checked == true){
                            html = '<table border="0" align="'+popupAlign+'"><tr><td><div align="center">';
                            html += "<a href=javascript:void window.open(";
                            html += "'" + tinyMCE.settings['document_base_url'] + "/mambots/editors/tinymce_exp/preview.php?img=',";
                            html += "'" + popupSrc + "'";
                            html += "&imgwidth=";
                            html += "'" + popupWidth + "'";
                            html += "&imgheight=";
                            html += "'" + popupHeight + "'";
                            html += "&alt=";
                            html += "'" + popupName + "')>";
                            html += '<img src="'+src+'" border="'+popupBorder+'" align="'+popupAlign+'" vspace="'+popupVspace+'" hspace="'+popupHspace+'" alt="'+popupName+'" width="'+thumbWidth+'" height="'+thumbHeight+'" /></a></div>';
                            html += '</td></tr><tr><td><div align="center">'+popupName+'</div></td></tr></table>';
                       }else{
                            html = '<a href="javascript:void window.open(';
                            html += "'/mambots/editors/tinymce_exp/preview.php?img=";
                            html += "" + popupSrc + "";
                            html += '&imgwidth=';
                            html += "" + popupWidth + "";
                            html += '&imgheight=';
                            html += "" + popupHeight + "";
                            html += '&alt=';
                            html += "" + popupName + "',";
                            html += "'Image',";
                            html += "'menubar=no,toolbar=no,scrollbars=yes,resizable=yes, left='+(screen.availWidth/2-(" + popupWidth + "/2))+',top='+(screen.availHeight/2-(" + popupHeight + "/2))+',width=" + popupWidth + ",height='+(" + popupHeight + "+100)+'');";
                            html += '">';
                            html += '<img src="' +thumbSrc+ '" border="'+popupBorder+'" align="'+popupAlign+'" vspace="'+popupVspace+'" hspace="'+popupHspace+'" alt="'+popupName+'" width="'+thumbWidth+'" height="'+thumbHeight+'" /></a>';
                       }

                      }else{
                        var src    = document.getElementById("f_url").value;
                        var width = document.getElementById("f_width").value;
                        var height = document.getElementById("f_height").value;
                      }

                      var alt    = document.getElementById("f_alt").value;
                      var title  = document.getElementById("f_alt").value;
                      var border = document.getElementById("f_border").value;
                      var vspace = document.getElementById("f_vert").value;
                      var hspace = document.getElementById("f_horiz").value;
                      var align = document.getElementById('f_align').options[document.getElementById('f_align').selectedIndex].value;
                      var onmouseover = document.forms[0].onmouseover.value;
                      var onmouseout  = document.forms[0].onmouseout.value;

                      // supporting onmouse over / out for image swap ...by Michael Keck (me@michaelkeck.de)
                      // only support the onmouse over/out if both values are given
                      if (onmouseover!='' && onmouseout!='' && document.forms[0].onmousemove.checked==true) {
                      onmouseover="this.src='" + onmouseover + "';";
                      onmouseout ="this.src='" + onmouseout + "';";
                      if (document.forms[0].onmousewidth.checked==false){
                          width="";
                        }
                        if (document.forms[0].onmouseheight.checked==false){
                          height="";
                        }
                      } else {
                        onmouseover="";
                        onmouseout ="";
                      }

                      if (document.getElementById("popupenable").checked == true){
                          tinyMCE.execCommand("mceInsertContent",true,html);
                          top.close();
                      }else{
                            window.opener.tinyMCE.insertImage(src, alt, border, hspace, vspace, width, height, align, title, onmouseover, onmouseout);
                            top.close();
                      }

            }

        };

        function MM_findObj(n, d) { //v4.01
                  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                  if(!x && d.getElementById) x=d.getElementById(n); return x;
                }

        //similar to the Files::makeFile() in Files.php
        function makeURL(pathA, pathB)
        {
                if(pathA.substring(pathA.length-1) != '/')
                        pathA += '/';

                if(pathB.charAt(0) == '/');
                        pathB = pathB.substring(1);

                return pathA+pathB;
        }


        function updateDir(selection)
        {
                var newDir = selection.options[selection.selectedIndex].value;
                changeDir(newDir);
        }

        function goUpDir()
        {
                var selection = document.getElementById('dirPath');
                var currentDir = selection.options[selection.selectedIndex].text;
                if(currentDir.length < 2)
                        return false;
                var dirs = currentDir.split('/');

                var search = '';

                for(var i = 0; i < dirs.length - 2; i++)
                {
                        search += dirs[i]+'/';
                }

                for(var i = 0; i < selection.length; i++)
                {
                        var thisDir = selection.options[i].text;
                        if(thisDir == search)
                        {
                                selection.selectedIndex = i;
                                var newDir = selection.options[i].value;
                                changeDir(newDir);
                                break;
                        }
                }
        }

        function changeDir(newDir)
        {
                if(typeof imgManager != 'undefined')
                        imgManager.changeDir(newDir);
        }

        function toggleConstrains(constrains)
        {
                var lockImage = document.getElementById('imgLock');
                var constrains = document.getElementById('constrain_prop');

                if(constrains.checked)
                {
                        lockImage.src = "img/locked.gif";
                        checkConstrains('width')
                }
                else
                {
                        lockImage.src = "img/unlocked.gif";
                }
        }

        function checkConstrains(changed)
        {
                //alert(document.form1.constrain_prop);
                var constrains = document.getElementById('constrain_prop');

                if(constrains.checked)
                {
                        var obj = document.getElementById('original_width');
                        var original_width = parseInt(obj.value);
                        var obj = document.getElementById('original_height');
                        var original_height = parseInt(obj.value);

                        var widthObj = document.getElementById('f_width');
                        var heightObj = document.getElementById('f_height');

                        var width = parseInt(widthObj.value);
                        var height = parseInt(heightObj.value);

                        if(original_width > 0 && original_height > 0)
                        {
                                if(changed == 'width' && width > 0) {
                                        heightObj.value = parseInt((width/original_width)*original_height);
                                }

                                if(changed == 'height' && height > 0) {
                                        widthObj.value = parseInt((height/original_height)*original_width);
                                }
                        }
                }
        }

        function showMessage(newMessage)
        {
                var message = document.getElementById('message');
                var messages = document.getElementById('messages');
                if(message.firstChild)
                        message.removeChild(message.firstChild);

                message.appendChild(document.createTextNode(newMessage));

                messages.style.display = "block";
        }

        function addEvent(obj, evType, fn)
        {
                if (obj.addEventListener) { obj.addEventListener(evType, fn, true); return true; }
                else if (obj.attachEvent) {  var r = obj.attachEvent("on"+evType, fn);  return r;  }
                else {  return false; }
        }

        function doUpload()
        {

                var uploadForm = document.getElementById('uploadForm');
                if(uploadForm)
                        showMessage('Uploading');
        }

        function refresh()
        {
                var selection = document.getElementById('dirPath');
                updateDir(selection);
        }

        function newFolder()
        {
                var selection = document.getElementById('dirPath');
                var dir = selection.options[selection.selectedIndex].value;

                Dialog("newFolder.html", function(param)
                {
                        if (!param) // user must have pressed Cancel
                                return false;
                        else
                        {
                                var folder = param['f_foldername'];
                                if(folder == thumbdir)
                                {
                                        alert('Invalid folder name, please choose another folder name.');
                                        return false;
                                }

                                if (folder && folder != '' && typeof imgManager != 'undefined')
                                        imgManager.newFolder(dir, encodeURI(folder));
                        }
                }, null);
        }

        addEvent(window, 'load', init);
