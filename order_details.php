<?php

include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){

    $order_id=$_POST['order_id'];
    $order_status=$_POST['order_status'];
    $stmt=$conn->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt->bind_param('i',$order_id);
    $stmt->execute();
    $order_details=$stmt->get_result();

}
else{
    header('location: account.php');
}


?>




<?php include('layouts/header.php'); ?>

    <!--Order Details-->
    <section id="orders" class="orders container my-5 py-3">
            <div class="container mt-5">
                <h2 class="font-weight-bold text-center">Order Details</h2>
                <hr class="mx-auto">
            </div>

            <table class="mt-5 pt-5 mx-auto">
                <tr>
                    <th>Product: </th>
                    <th>Product Price: </th>
                    <th>Product Quantity: </th>
                </tr>

                <?php while($row=$order_details->fetch_assoc()){ ?>

                        <tr>
                            <td>
                                <div>
                                    <img src="assets/imgs/<?php echo $row['product_image'];  ?>"/>
                                    <div>
                                        <p class="mt-3"><?php echo $row['product_name'];?></p>
                                    </div>
                                </div>
                                
                            </td>
                            <td>
                              <span>Bdt.<?php echo $row['product_price'];?></span>
                            </td>
                            <td>
                              <span><?php echo $row['product_quantity'];?></span>
                            </td>
                            

                            
                            
                        </tr>
                    <?php } ?>

            </table>

                <?php if($order_status == "not paid") { ?>
                    <form style="float: right">
                        <input type="submit" class="btn btn-primary" value="Pay Now"/>
                    </form>
            
                <?php } ?>
            


        </section>



<?php include('layouts/footer.php'); ?>