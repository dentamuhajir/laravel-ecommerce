

<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
use \App\Http\Controllers\FunctionController;
?>
<!DOCTYPE html>
<html>
<head>
<title>Cari Jam Tangan</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Women's Fashion Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="{{$BASE_URL}}/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="{{$BASE_URL}}/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="{{$BASE_URL}}/css/fasthover.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="{{$BASE_URL}}/js/jquery.min.js"></script>
<!-- //js -->
<!-- cart -->
<script src="{{$BASE_URL}}/js/simpleCart.min.js"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="{{$BASE_URL}}/js/bootstrap-3.1.1.min.js"></script>
<!-- //for bootstrap working -->
<link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smooth-scrolling -->
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".scroll").click(function(event){
      event.preventDefault();
      $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });
  });
</script>
<!-- //end-smooth-scrolling -->
</head>

<body>
<!-- header -->

<!--
 @include('template_womensfashion.snippets.modal-signin-register-blade'); -->



 @include('template_womensfashion.blocks.header-blade')


 @include('template_womensfashion.blocks.nav')

<!-- //header -->
<!-- banner -->
  <div class="banner10" id="home1">
    <div class="container">
      <h2 style="text-shadow: 1px 1px white;"><b>Cart</b></h2>
    </div>
  </div>
<!-- //banner -->

<!-- breadcrumbs -->
  <div class="breadcrumb_dress">
    <div class="container">
      <ul>
        <li><a href="{{$BASE_URL}}"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Home</a> <i>/</i></li>
        <li>Cart</li>
      </ul>
    </div>
  </div>
<!-- //breadcrumbs -->
@if(Cart::count()==0)
<div class="checkout">
    <div class="container">
      <center><b><h2><img src="{{$BASE_URL}}/images/logo/oops.jpg" width="50px" heighr="50p"> Wadauwww!!! kamu belum belanja sama sekalih</h2></b></center>
    </div>
</div>


@else
<!-- checkout -->
  <div class="checkout">
    <div class="container">
      <h3>Barang belanjaan kamu sebanyak : <span> {{ Cart::count() }} Produk</span></h3>

      <div class="checkout-right">
        <table class="timetable_sub">
          <thead>
            <tr>
              <th>No.</th>
              <th>Pic</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Remove</th>
            </tr>
          </thead>


  <?php static $num = 1;
$productOrder = '';
foreach (Cart::content() as $row):

	$productOrder .= '{';
	$productOrder .= '"id" :' . $row->id . ',';
	$productOrder .= '"name" :' . '"' . $row->name . '"' . ',';
	$productOrder .= '"price" :' . $row->price . '},';

	?>

																																																			<tr class="rem1">
																																																				<td class="invert"><?php echo $num++; // echo $row->id;                                                  ?></td>
																																																			        <td class="invert-image"><a href="single.html"><img src="{{$BASE_URL}}/photo/<?=$row->options->pic;?>_220X290.jpg" alt=" " class="img-responsive" /></a></td>
																																																					<td class="invert"><b><?php echo $row->name; ?></b></td>
																																																					<td class="invert"><b><?php echo FunctionController::toRupiah($row->price); ?></b></td>
																																																					<td class="invert">
																																																					<div class="rem" >
																																																					<div class="close1" onClick="removeCart('{{$row->rowId}}')"> </div>
																																																						<input type="hidden" class="base_url" value="{{$BASE_URL}}" />
																																																					</div>
																																																			<script>
																																																			function removeCart(id){
																																																				if (confirm('Are you sure you want to remove product from the cart?')) {
																																																				}
																																																				else {
																																																					return;
																																																				}
																																																				var baseUrl = $('.base_url').val() ;
																																																				$.ajax({
																																																			 		type: "GET",
																																																			    	url: baseUrl + '/cart/remove/'+id,
																																																					success: function( msg ) {
																																																			 		//	location.reload();
																																																            $(".checkout").load(" .checkout");

																																																					}
																																																				});
																																																		     }
																																																			</script>
																																																			</td>
																																																			</tr>
																																																		<?php endforeach;?>



        </table>
      </div>

       <div class="checkout-right-basket" style="float:left;">

      <a href="{{$BASE_URL}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Lanjutkan belanja</a>

     </div>


      <div class="checkout-right-basket">

      <a href="{{$BASE_URL}}/keranjang-belanja/checkout"> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Checkout ke pembayaran </a>

     </div>


      @endif

          <!-- <a href="products.html"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a> -->
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  </div>

   @include('template_womensfashion.snippets.cart-related-product-blade');


<!-- //checkout -->


<!-- footer -->

 @include('template_womensfashion.blocks.footer')

<!-- //footer -->
</body>
</html>





