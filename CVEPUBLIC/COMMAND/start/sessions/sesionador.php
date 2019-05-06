<? session_start();
$_SESSION['ses_usr_id'] = $ses_usr_id;
$_SESSION['ses_usr_login'] = $ses_usr_login;
$_SESSION['ses_usr_codlocal'] = $ses_usr_codlocal;
//$ses_usr_codlocal;
//header('Location: ../../start_01.php' );
header('Location: ../../monitororpick/monitor_orpick_00.php' );
?>
