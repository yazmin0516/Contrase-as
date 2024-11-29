<?php
session_start();
session_unset();
session_destroy();
header("Location: Iniciodesecion.php");
exit();
?>
