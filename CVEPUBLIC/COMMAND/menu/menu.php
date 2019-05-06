<link rel="stylesheet" href="../../TEMPLATE/general/menu/menu.css">
<script language="JavaScript" src="../../TEMPLATE/general/menu/menu.js"></script>
<script language="JavaScript" src="../../TEMPLATE/general/menu/menu_tpl.js"></script>
<script>

<?
//print_r("Menu Superior:".$ses_usr_menu."<br>\n");

if (!$ses_usr_menu) {
	$List = new connlist;
	bizcve::getmenu($ses_usr_login, $List);


	$List->gofirst();
	if (!$List->isvoid()) {
		$menuout = "var MENU_ITEMS = [";
		do {
			$menuout .= "['&nbsp;".$List->getelem()->mod_nombre."', '".$List->getelem()->mod_url."', null , ";
			$listahijo = $List->getelem()->ListHijo;
			$listahijo->gofirst();
			if (!$listahijo->isvoid()) {
				do {
					$menuout .= "['&nbsp;".$listahijo->getelem()->mod_nombre."', '".$listahijo->getelem()->mod_url."'],";
				} while ($listahijo->gonext());
			}
			$menuout .="],";
		} while ($List->gonext());
		$menuout .= "];";
	}
	$ses_usr_menu = $menuout;
}


	echo $ses_usr_menu;
	echo "new menu (MENU_ITEMS, MENU_POS)";
?>

</script>
