
<!DOCTYPE html>
<html>
<head>
<title>Order Form</title>
<!-- for-mobile-apps -->
  <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Jam Tangan, Cari Jam Tangan, Cari Jam Branded, Cari Jam Tangan Murah, Cari Jam Tangan Branded Murah" />
<link rel="icon" type="image/png" href="/images/logo/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/images/logo/favicon-32x32.png" sizes="32x32">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="{{ $BASE_URL }}/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="{{ $BASE_URL }}/css/style.css" rel="stylesheet" type="text/css" media="all" />
  
<!-- js -->
<script src="{{$BASE_URL}}/js/jquery.min.js"></script>
<!-- //js -->
<!-- cart -->
<script defer src="{{$BASE_URL}}/js/simpleCart.min.js"></script>
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
<script defer type="text/javascript"> //<![CDATA[ 
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
<!-- //end-smooth-scrolling -->
</head>

<body>
<!-- header -->

 @include('template_womensfashion.blocks.header-blade')
 @include('template_womensfashion.blocks.nav')

<!-- //header -->
<!-- banner -->
  <div class="banner11" id="home1">
    <div class="container">
      <h2 style="text-shadow: 1px 1px white;"><b>Checkout</b></h2>
    </div>
  </div>
<!-- //banner -->

<!-- breadcrumbs -->
  <div class="breadcrumb_dress">
    <div class="container">
      <ul>
        <li><a href="/"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Home</a> <i>/</i></li>
        <li>Cart<i>/</i></li>
        <li>Checkout</li>
      </ul>
    </div>
  </div>
<!-- //breadcrumbs -->


<iframe style="border:none;margin-top:20px;" src="{{$BASE_URL}}/widget-bill/" width="100%" height="1100px"></iframe>



<!-- footer -->

 @include('template_womensfashion.blocks.footer')

<!-- //footer -->
</body>
</html>





