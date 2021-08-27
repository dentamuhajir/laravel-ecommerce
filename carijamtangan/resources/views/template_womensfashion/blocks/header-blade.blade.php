 <div class="header">
    <div class="container">
      <div class="row">
          <div class="col-lg-12" >
          <div class="col-lg-4" style="">
            <div class="col-lg-4" style="height:60px;padding-top:9px;border-left:3px solid silver;">

              <h4><b>CUSTOMER</b></h4>
              <h4><b>SERVICES</b></h4>

            </div>
            <div class="col-lg-8" style="">
            <div class="col-lg-12">
              <div class="row">

              <img src="{{$BASE_URL}}/images/logo/whatsapp.png">
              <b>081 385 800 400</b>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">

              <img src="{{$BASE_URL}}/images/logo/blackberry-messenger.png"> <b>PIN : JMTG24</b>
              </div>

            </div>

            </div>


          </div>



          <div class="col-lg-4" style="    ">
              <div class="w3l_logo" ><a href="{{$BASE_URL}}">
                <center><img src="{{$BASE_URL}}/images/logo/carijamtangan.png" style="margin-top:-25px;"  ></center</a>

      </div>

          </div>
          <div class="col-lg-4">

               <div class="cart box_1">
        <a href="{{$BASE_URL}}/keranjang-belanja">
          <div class="total">
          <span class="simpleCart_totald"></span><b> Rp {{  substr(str_replace(',', '.', strToUpper(Cart::subtotal())), 0, -3) }} </b>({{ Cart::count()}} items)</div>
          <img src="{{$BASE_URL}}/images/bag.png" alt="" />
        </a>
        <p><a href="javascript:;" class="simpleCart_empty">Kosongkan Cart</a></p>
        <div class="clearfix"> </div>
      </div>



          </div>

        </div>
      </div>
  </div>
  </div>