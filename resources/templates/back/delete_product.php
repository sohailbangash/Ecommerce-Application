<?php require_once("../../config.php");?>
<?php

   if(isset($_GET['delete'])){

     $query=query("DELETE FROM products WHERE product_id=".escape_string($_GET['delete'])." ");
     confirm($query);

     set_message("Product Deteted");
     redirect("../../../public/admin/index.php?view_products");

   }else{
    redirect("../../../public/admin/index.php?view_products");

   }


?>