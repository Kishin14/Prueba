<?php

require_once("../framework/clases/SeguridadClass.php"); 

$Autenticar = new Seguridad(2);

$ModuloId      = $_REQUEST['ModuloId'];
$OficinaId     = $_REQUEST['OficinaId'];
$frame_destino = $_REQUEST['frame_destino'];
$url           = $_REQUEST['src'];
$url           = $url."&OFICINAID=$OficinaId";

?>

	<html>
	
	
	<frameset cols="250,*" frameborder="yes" framespacing=1>
	
	  <frame name="FrameMenu" id="FrameMenu" src="../framework/clases/MenuArbol/Menu.php?OficinaId=<?php print $OficinaId; ?>&ModuloId=<?php print $ModuloId ?>&rand=<?php print rand()?>" marginheight=0 marginwidth=0 scrolling=auto>
	  <frame name="<?php print $frame_destino; ?>" id="<?php print $frame_destino; ?>" src="<?php print $url; ?>&rand=<?php print rand()?>" marginheight=0 marginwidth=0 scrolling=auto>
	  
	</frameset>
	
	<noframes></noframes>
	  
	
	</html>
