<?php
 
    // image varibale
 
    $upload_image='uploads';

  // helper function

  function last_id(){
   global $conn;
    return mysqli_insert_id($conn);
  }

  function set_message($msg){
    if(!empty($msg)){
    $_SESSION['message']=$msg;
    }else{
      $msg='';
    }
  }

   function display_message(){
     if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
     }

   }

 function redirect($location){

   return header("Location: $location");  
 }

function query($sql){
  global $conn;
 
   return mysqli_query($conn,$sql);
  
}

function confirm($result){
  global $conn;

   if(!$result){
       die("QUERY FAILED". mysqli_error($conn));
   }
}


function escape_string($string){
    global $conn;
  
   return mysqli_escape_string($conn,$string);
  }


  function  fetch_array($result){

   return mysqli_fetch_array($result);
  }

  /************************* FRONT END FUNCTION ***********************************/ 
  //  get_prodcut

  function get_products(){
   
    $query=query("SELECT * FROM products");
     confirm($query);

      while($row=fetch_array($query)){
    
       $product=<<<DELIMETER
                  <div class="col-sm-4 col-lg-4 col-md-4">
                  <div class="thumbnail">
                     <a href="item.php?id={$row['product_id']}"> <img src="image/{$row['product_image']}" alt=""></a>
                      <div class="caption">
                          <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                          <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                          </h4>
                          <p>See more snippets like this online store item at <a  href=''</a>.</p>
                          <a class="btn btn-primary"  href="../resources/cart.php?add={$row['product_id']}">Add Chart</a>
                      </div>
                      
                  </div>
              </div>
DELIMETER;

        echo $product;

      }
  }



  function get_categories(){

    $query=query("SELECT * FROM categories");
     confirm($query);


    while($row=fetch_array($query)){
 
      $category_link=<<<DELIMETER
      <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
echo $category_link;
}
  
}



function get_products_in_cat_page(){
   
  $query=query("SELECT * FROM products where product_cat_id=".escape_string($_GET['id'])." ");
   confirm($query);

    while($row=fetch_array($query)){
  
     $product=<<<DELIMETER
     <div class="col-md-3 col-sm-6 hero-feature">
     <div class="thumbnail">
         <img src="image/{$row['product_image']}" alt="">
         <div class="caption">
             <h3>{$row['product_title']}</h3>
             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
             <p>
                 <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
             </p>
         </div>
     </div>
 </div>
DELIMETER;

      echo $product;

    }
}


function get_products_in_shop_page(){
   
  $query=query("SELECT * FROM products");
   confirm($query);

    while($row=fetch_array($query)){
  
     $product=<<<DELIMETER
     <div class="col-md-3 col-sm-6 hero-feature">
     <div class="thumbnail">
         <img src="image/{$row['product_image']}" alt="">
         <div class="caption">
             <h3>{$row['product_title']}</h3>
             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
             <p>
                 <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
             </p>
         </div>
     </div>
 </div>
DELIMETER;

      echo $product;

    }
}

/************************* Login User FUNCTION ***********************************/ 

function login_user(){
  if(isset($_POST['submit'])){
      $username=escape_string($_POST['username']);
     $user_pass=escape_string($_POST['password']);

  $query=query("SELECT * FROM users where username='{$username}' AND  password='{$user_pass}' ");
  confirm($query);

  if(mysqli_num_rows($query)==0){
    set_message('Your Password and Username is Wrong');
    redirect("login.php");
  }else{
    $_SESSION['username']=$username;
    redirect("admin");
  }
   

  }
}

/************************* Email FUNCTION ***********************************/ 
function send_message(){
  if(isset($_POST['submit'])){
      $to     ="example@gmail.com";
      $name   =escape_string($_POST['name']);
      $email  =escape_string($_POST['email']);
      $subject=escape_string($_POST['subject']);
      $message=escape_string($_POST['message']);

      $header="From: {$name} {$email} ";

     $result=mail($to,$subject,$message,$header);

     if(!$result){
        set_message(" Sorry Your Email Could not be send");
        
     }else{
      set_message("Your Email has  be sent");
      
     }

  }
}


/************************* BACK END FUNCTION ***********************************/ 


/********  products in Admin page **********/ 

function display_image($picture){
   global $upload_image;
  return $upload_image . DS. $picture;

}


 function  get_product_in_admin(){

  $query=query("SELECT * FROM products");
  confirm($query);

   while($row=fetch_array($query)){
   $category=show_product_category_title($row['product_cat_id']);
   $product_image=display_image($row['product_image']);

    $product=<<<DELIMETER
    <tr>
        <td>{$row['product_id']}</td>
        <td>{$row['product_title']}<br>
          <a href="index.php?edit_product&id={$row['product_id']}"><img  class="img-responsive" width='100px' src="../../resources/$product_image" alt="image"></a>
        </td>
        <td>{$category}</td>
        <td>{$row['product_price']}</td>
        <td>{$row['product_quantity']}</td>
        <td> 
        <a  class='btn btn-danger' href="../../resources/templates/back/delete_product.php?delete=$row[product_id]"><span class='glyphicon glyphicon-remove'></span></a>
        </td>
  </tr>
DELIMETER;

     echo $product;

   }



 }

 function  show_product_category_title($product_cat_id){

  $pro_category=query("SELECT * FROM categories WHERE cat_id= '{$product_cat_id}' ");
  confirm($pro_category);

  while($cat_row=fetch_array($pro_category)){

   return $cat_row['cat_title'];
  }

}



/********  create new product in Admin **********/ 

  function create_new_product(){
   
    if(isset($_POST['publish'])){
      $pro_title=escape_string($_POST['product_title']);
      $pro_desc=escape_string($_POST['product_description']);
      $pro_price=escape_string($_POST['product_price']);
      $short_desc=escape_string($_POST['short_des']);
      $pro_category=escape_string($_POST['product_category_id']);
      $pro_quantity=escape_string($_POST['product_quantity']);

      $pro_image=$_FILES['img']['name'];
      $temp_image=$_FILES['img']['tmp_name'];


      move_uploaded_file($temp_image , UPLOAD_IMAGE . DS . $pro_image);



   $query=query("INSERT INTO products(product_title,product_cat_id,product_price,product_quantity,product_description,short_desc,product_image) 
                  VALUES ('{$pro_title}','{$pro_category}','{$pro_price}','{$pro_quantity}','{$pro_desc}','{$short_desc}','{$pro_image}')");
     confirm($query);
      //  $last_id=last_id();
      set_message('New Product Just Added');

      redirect('index.php?view_products');

  }

  }

/******** Products Category **********/ 


function product_categories(){

  $query=query("SELECT * FROM categories");
   confirm($query);


  while($row=fetch_array($query)){

    $category_link=<<<DELIMETER
    <option value={$row['cat_id']}>{$row['cat_title']}</option>
   
DELIMETER;
echo $category_link;
}

}




?>