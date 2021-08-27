  <header class="header_area bg-img background-overlay-white" style="background-image: url(img/bg-img/bg-1.jpg);">
            <!-- Top Header Area Start -->
            <div class="top_header_area" style="height: 50px;">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-end">

                     	<div class="col-12 col-lg-7">
                            <div class="top_single_area d-flex align-items-center" style="margin-top: 10px;">
                                <!-- Logo Area -->
                                <div class="top_logo">
                                     <a href="/"><img src="https://carijamtangan.com/images/logo/cjt-logo.png" class="logo-cjt"></a>
                                </div>
                                <!-- Cart & Menu Area -->
                                <div class="header-cart-menu d-flex align-items-center ml-auto">
                                    <!-- Cart Area -->
                                    <div id="animation-cart">
                                    <div class="cart">
                                        <a href="{{ $BASE_URL }}/keranjang-belanja" id="header-cart-btn"><span class="cart_quantity" style="background-color: #ff9b05;">{{ Cart::count()}}</span> <i class="ti-bag"></i> Rp  {{  substr(str_replace(',', '.', strToUpper(Cart::subtotal())), 0, -3) }}</a>
                                        <!-- Cart List Area Start -->
                                    </div>

                                </div>
                                    <div class="header-right-side-menu ml-15">
                                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Top Header Area End -->
            <div class="main_header_area">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-12 d-md-flex justify-content-between">
                         
                            <div class="help-line" style="">
                                <center><a href="tel:+346573556778" style="background-color: #FF9B05;border-radius: 15px;"><i class="ti-phone-alt"></i>WA : 081 385 800 400 | BBM : JMTG24</a></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>