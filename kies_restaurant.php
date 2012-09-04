<?php
	session_start();

	require_once 'includes/objecten.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Take @way Pizza 24/7</title>
<link rel="stylesheet" href="css/deadCenter.css" type="text/css" media="screen" charset="utf-8" />
<?php
include 'includes/header.inc';
?>
<script type="text/javascript" language="javascript" src="scripts/dead_center.js"></script>
</head>
<body>
<div id="deadCenterBox">
<ul id="restaurants">
	<?php
	foreach($resto_lijst as $restaurant){
	?>	<li><?php echo $restaurant->naam;?></li>
	<?php
	}
	?></ul>
</div>

<?php

?>
</body>
</html>