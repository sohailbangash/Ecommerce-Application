<?php
 
 ob_start();
 session_start();
//  session_destroy();

 defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

 defined("TEMPLATES_FRONT") ? null : define("TEMPLATES_FRONT",__DIR__. DS . "templates/front");
 defined("TEMPLATES_BACK") ? null : define("TEMPLATES_BACK",__DIR__. DS . "templates/back");
 defined("UPLOAD_IMAGE") ? null : define("UPLOAD_IMAGE",__DIR__. DS . "uploads");

 defined("DB_HOST") ? null : define("DB_HOST","localhost" );
 defined("DB_USER") ? null : define("DB_USER","root" );
 defined("DB_PASS") ? null : define("DB_PASS","" );
 defined("DB_NAME") ? null : define("DB_NAME","ecom_db" );

 $conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

 require_once("function.php");
 require_once("cart.php");

?>