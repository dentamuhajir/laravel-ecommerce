<?php
use \App\Http\Controllers\FunctionController;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Cart</title>

    <!-- Favicon  -->
    <link rel="icon" href="/mobile-assets/img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="/mobile-assets/css/core-style.css">
    <link rel="stylesheet" href="/mobile-assets/style.css">

    <!-- Responsive CSS -->
    <link href="/mobile-assets/css/responsive.css" rel="stylesheet">

</head>

<body>

     @include('template_karl_mobile.blocks.menubar')

    <div id="wrapper">

         @include('template_karl_mobile.blocks.header2')

         @include('template_karl_mobile.snippets.breadcrumb')

             <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix" style="padding-top: 10px">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Harga</th>
                                        <th>-</th>

                                    </tr>
                                </thead>
                                <tbody>

<?php static $num = 1;
foreach (Cart::content() as $row):
?>

                                    <tr>
                                        <td class="cart_product_img d-flex align-items-center">
                                            <!-- <a href="#"><img src="{{ $BASE_URL }}/timthumb.php?src={{ $BASE_URL }}/photo/<?=$row->options->pic;?>.jpg&h=200&w=200&zc=1" alt="Product"></a>
                                       -->      <h6><?php echo $row->name; ?></h6>
                                        </td>
                                        <td class="price"><span><?php echo FunctionController::toRupiah($row->price); ?></span></td>
                                        <td class="qty">
                                            <div class="quantity">
                                            	<span onClick="removeCart('{{$row->rowId}}')" class="ti-trash"></span>

                                            <input type="hidden" class="base_url" value="{{$BASE_URL}}" />

                                            </div>
                                        </td>
                                    </tr>
   <?php endforeach;?>

                                </tbody>
                            </table>
                        </div>
                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="/">Continue shooping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <a href="/keranjang-belanja/checkout">Check out</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- ****** Cart Area End ****** -->



         @include('template_karl_mobile.blocks.footer')
    </div>

                        <script>
                           function removeCart(id){
                            if (confirm('Are you sure you want to remove product from the cart?')) {
                            }
                            else {
                                return;
                            }
                            //NProgress.start();
                            var baseUrl = $('.base_url').val() ;
                           
                            $.ajax({
                                    type: "GET",
                                url: baseUrl + '/cart/remove/'+id,
                                success: function( msg ) {
                                    //  location.reload();
                                    $(".cart-table").load(" .cart-table");
                                    $(".cart").load(" .cart");
                                    //NProgress.done();

                                }
                            });
                               }
                        </script>



   <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="/mobile-assets/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="/mobile-assets/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="/mobile-assets/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="/mobile-assets/js/plugins.js"></script>
    <!-- Active js -->
    <script src="/mobile-assets/js/active.js"></script>
</body>
</html>


