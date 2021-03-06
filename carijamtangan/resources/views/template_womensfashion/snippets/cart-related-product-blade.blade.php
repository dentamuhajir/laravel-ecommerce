   <?php
use \App\Http\Controllers\FunctionController;
?>
    <div class="w3l_related_products">
    <div class="container">
      <h3>Related Products</h3>

      <ul id="flexiselDemo2">
      @foreach ($RELATED_PRODUCT as $RELATED):
        <li>
          <div class="w3l_related_products_grid">
            <div class="agile_ecommerce_tab_left dresses_grid">
              <div class="hs-wrapper hs-wrapper3">
                <img src="{{$BASE_URL}}/images/logo/image-placeholder.gif"  style="height:340px;" data-src="{{ $BASE_URL }}/timthumb.php?src={{ $BASE_URL }}/photo/{{$RELATED->PRODUCT_MAIN_IMAGE}}.jpg&h=340&w=255&zc=1" alt=" " class="img-responsive">
                <div class="w3_hs_bottom">
                  <div class="flex_ecommerce">
                    <a href="{{$BASE_URL}}/detail/{{$RELATED->PRODUCT_ID}}-{{$RELATED->PRODUCT_NAME_SLUG}}.html"><strong>Detail Produk</strong></a>
                  </div>
                </div>
              </div>
              <h5><a href="{{$BASE_URL}}/detail/{{$RELATED->PRODUCT_ID}}-{{$RELATED->PRODUCT_NAME_SLUG}}.html">{{ $RELATED->PRODUCT_NAME   }}</a></h5>
              <div class="simpleCart_shelfItem">
                <p class="flexisel_ecommerce_cart"><span> <?=FunctionController::toRupiah($RELATED->PRODUCT_CJT_PRICE + $RELATED->PRODUCT_PROFIT);?></span> <i class="item_price"> <?=FunctionController::toRupiah($RELATED->PRODUCT_CJT_PRICE);?></i></p>
                <p><a class="item_add" href="#">Add to cart</a></p>
              </div>
            </div>
          </div>
        </li>
        @ENDFOREACH


      </ul>
        <script type="text/javascript">
          $(window).load(function() {
            $("#flexiselDemo2").flexisel({
              visibleItems:4,
              animationSpeed: 1000,
              autoPlay: true,
              autoPlaySpeed: 3000,
              pauseOnHover: true,
              enableResponsiveBreakpoints: true,
              responsiveBreakpoints: {
                portrait: {
                  changePoint:480,
                  visibleItems: 1
                },
                landscape: {
                  changePoint:640,
                  visibleItems:2
                },
                tablet: {
                  changePoint:768,
                  visibleItems: 3
                }
              }
            });

          });
        </script>
        <script type="text/javascript" src="{{$BASE_URL}}/js/jquery.flexisel.js"></script>
    </div>
  </div>