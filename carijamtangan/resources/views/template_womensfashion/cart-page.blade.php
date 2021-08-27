
<?php
use \App\Http\Controllers\FunctionController;
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Keranjang Belanja</title>
      <!-- for-mobile-apps -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="keywords" content="Jam Tangan, Cari Jam Tangan, Cari Jam Branded, Cari Jam Tangan Murah, Cari Jam Tangan Branded Murah" />
      <link rel="icon" type="image/png" href="/images/logo/favicon-16x16.png" sizes="16x16">
      <link rel="icon" type="image/png" href="/images/logo/favicon-32x32.png" sizes="32x32">

      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
         function hideURLbar(){ window.scrollTo(0,1); }
      </script>
      <!-- //for-mobile-apps -->
      <link href="{{ $BASE_URL }}/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
      <link href="{{ $BASE_URL }}/css/style.css" rel="stylesheet" type="text/css" media="all" />
      <link rel="stylesheet" href="{{ $BASE_URL }}/css/nprogress.css" media="none" onload="if(media!=='all')media='all'" >
      <link rel="stylesheet" href="{{ $BASE_URL }}/css/fasthover.css" media="none" onload="if(media!=='all')media='all'" >


      <!-- js -->
      <script src="{{$BASE_URL}}/js/jquery.min.js"></script>
      <!-- //js -->
      <!-- cart -->
      <script defer src="{{ $BASE_URL}}/js/simpleCart.min.js"></script>
      <script defer src="{{ $BASE_URL }}/js/nprogress.js"></script>
      <!-- cart -->
      <!-- for bootstrap working -->
      <script defer type="text/javascript" src="{{$BASE_URL}}/js/bootstrap-3.1.1.min.js"></script>
      <!-- //for bootstrap working -->

      <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Glegoo:400,700" media="none" onload="if(media!=='all')media='all'" >
      <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" media="none" onload="if(media!=='all')media='all'" >

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

      <!-- //end-smooth-scrolling -->
<script defer type="text/javascript"> //<![CDATA[
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
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
            <center>
               <b>
                  <h2><img src="{{$BASE_URL}}/images/logo/oops.jpg" width="50px" heighr="50p"> Wadauwww!!! kamu belum belanja sama sekalih</h2>
               </b>
            </center>
         </div>
      </div>
      @else
      <!-- checkout -->
      <div class="checkout">
         <div class="container">
            <h2 style="margin-bottom:30px">Barang belanjaan kamu sebanyak : <span> {{ Cart::count() }} Produk</span></h2>
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
foreach (Cart::content() as $row):

?>
                  <tr class="rem1">
                     <td class="invert"><?php echo $num++; // echo $row->id;                                                             ?></td>


                     <td class="invert-image"><a href="#"><img src="{{ $BASE_URL }}/timthumb.php?src={{ $BASE_URL }}/photo/<?=$row->options->pic;?>.jpg&h=200&w=200&zc=1" alt=" " class="img-responsive" /></a></td>
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
                           	NProgress.start();
                           	var baseUrl = $('.base_url').val() ;
                           	$.ajax({
                            		type: "GET",
                               	url: baseUrl + '/cart/remove/'+id,
                           		success: function( msg ) {
                            		//	location.reload();
                                    $(".checkout").load(" .checkout");
									$(".total").load(" .total");
									NProgress.done();

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

<script>
function init() {
   var imgDefer = document.getElementsByTagName('img');
   for (var i=0; i<imgDefer.length; i++) {
      if(imgDefer[i].getAttribute('data-src')) {
         imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
      }
   }
}
window.onload = init;
</script>
   </body>
</html>