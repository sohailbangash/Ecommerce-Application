
<h1 class="page-header">
   All Products
<h3 class="bg-success"><?php display_message();?></h3>
</h1>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Title</th>
           <th>Category</th>
           <th>Price</th>
           <th>Quantity</th>
      </tr>
    </thead>
    <tbody>

       <?php get_product_in_admin();?>
  </tbody>
</table>


          