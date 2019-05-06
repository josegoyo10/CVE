//Based on mosThumb.js from mosThumb Mambot by Manfred Dennerlein
//Creates popup window for thumbnail

function thumbPopup(mypage, myname, w, h, popupClose) {

       	if (popupClose == 'true'){
			var closeWindow = 'onclick="window.close()"';
		}else{
			var closeWindow = '';
		}
		var props = '';
        var orig_w = w;
        var scroll = '';
        var winl = (screen.availWidth - w) / 2;
        var wint = (screen.availHeight - h) / 2;
        if (winl < 0) { winl = 0; w = screen.availWidth -6; scroll = 1;}
        if (wint < 0) { wint = 0; h = screen.availHeight - 32; scroll = 1;}
        winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable=no'
        win = window.open('', 'myThumb', winprops)
        win.document.open();
        win.document.write('<html><head>');
        win.document.write('<scr' + 'ipt type="text/javascr' + 'ipt" language="JavaScr' + 'ipt">');
        win.document.write('</scr' + 'ipt>');
        win.document.write('<title>'+myname+'</title></head>');
        win.document.write('<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">');
        win.document.write('<img src="'+mypage+'" border="0" alt="'+myname+'" title="'+myname+'" '+closeWindow+'>');
        win.document.write('</body></html>');

        win.document.close();
        if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

}
