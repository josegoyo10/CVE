<?php
define( '_VALID_MOS', 1 );
include ("../../../../../../../../configuration.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Preveiw Image</title>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site ?>/mambots/editors/tinymce_exp/jscripts/tiny_mce/themes/advanced/editor_popup.css" type="text/css" />
<script type="text/javascript" src="assets/popup.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
        window.focus;
/*]]>*/
</script>
</head>
<body>
<div align="center">
<img src="<?php if(isset($_GET['img'])) echo ($_GET['img']); ?>" border="0">
</div><br />
<div align="center"><?php if(isset($_GET['alt'])) echo ($_GET['alt']); ?></div>
<div align="center"><?php if(isset($_GET['imgwidth'])) echo ($_GET['imgwidth']); ?>px X <? if(isset($_GET['imgheight'])) echo ($_GET['imgheight']); ?>px</div>
<div align="center"><?php if(isset($_GET['imgsize'])) echo ($_GET['imgsize']); ?></div>
<br/ >
<div align="center"><input type="button" name="close" value="Close" onClick="window.close()"></div><br />
<div id="bottom"></div>
</body>
</html>
