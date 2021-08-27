
<input type="hidden" value="<?php echo $CART_TOTAL; ?>" id="sub-total-static"/>
      <div class="checkout_area section_padding_100" style="padding-top: 10px">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="checkout_details_area mt-50 clearfix" style="margin-top:0px">

                            <div class="cart-page-heading">
                                <h5>Formulir Order</h5>
                                <p>Masukan data sebenar-benarnya</p>
                            </div>

                            <form action="#" method="post">
                                <div class="row">



                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                    <input style="border-radius: 8px;border: 1px solid silver" type="text" id="name" class="form-control" >
                              </div>
                           </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="numberphone">Nomer Ponsel / Whatsapp</label>
                                    <input style="border-radius: 8px;border: 1px solid silver" type="number" maxlength="13" pattern="([0-9]|[0-9]|[0-9])" id="telphone" class="form-control" >
                              </div>
                           </div>
                               <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="numberphone">Email </label>
                                    <input type="email" style="border-radius: 8px;border: 1px solid silver" id="email" class="form-control">
                              </div>
                           </div>

                               <div class="col-md-12">
                              <div class="form-group" >

                                <label for="country">Provinsi</label>
                                 <div class="form-field">
                                    <i class="icon icon-arrow-down3"></i>
                                    <select  style="border-radius: 8px;border: 1px solid silver" id="select-province" class="form-control">


<option value="#">Pilih provinsi</option>

                                          <?php
$num = 0;
foreach ($GET_PROVINCE as $row) {
	?>
                                                <option value="<?=$row['province_id'];?>">  <?=$row['province'];?> </option>
                                            <?php
}
?>


                                    </select>
                                 </div>
                              </div>
                           </div>

                              <div class="col-md-12">
                              <div class="form-group" >
                                <label for="country">Kota</label>
                                 <div class="form-field">
                                    <i class="icon icon-arrow-down3"></i>
                                    <select name="people" id="select-city" style="border-radius: 8px;border: 1px solid silver" class="form-control">

                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fname">Alamat</label>
                                        <textarea style="border-radius: 8px;border: 1px solid silver" id="address" class="form-control" cols="4" rows="5"></textarea>

                              </div>

                           </div>

                                    <!--<div class="col-12">
                                        <div class="custom-control custom-checkbox d-block mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Terms and conitions</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-block mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">Create an accout</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-block">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                            <label class="custom-control-label" for="customCheck3">Subscribe to our newsletter</label>
                                        </div>
                                    </div>-->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-5 ml-lg-auto" >
                        <div class="order-details-confirmation" style="border-radius:8px;">

                            <div class="cart-page-heading">
                                <h5>Your Order</h5>
                                <p>Details</p>
                            </div>
							
							

                            <ul class="order-details-form mb-4">
							
							
							

								
							 <?php
$productOrder = "";
foreach (Cart::content() as $row):

	$productOrder .= '{';
	$productOrder .= '"id" :' . '"' . $row->id . '"' . ',';
	$productOrder .= '"name" :' . '"' . $row->name . '"' . ',';
	$productOrder .= '"picture" :' . '"' . $row->options->pic . '_220X290.jpg"' . ',';
	$productOrder .= '"price" :' . $row->price . '},';

	?>
	
		<li><span><?php
	$str = $row->name;
	if (strlen($str) > 30) {
		$str = substr($str, 0, 30) . '...';
	}

	echo $str;

	?>

								</span> <span>  Rp {{ number_format($row->price, 0, '', '.')}}</span></li>
							
							
							<?php endforeach;
							?>
							
							<li><span>Ongkir JNE Regular</span> <span id="ongkir-display">-</span></li>
                     
						  
						  <li><span><b>Order Total</b></span> <strong><span id="sub-total">  Rp {{ number_format($CART_TOTAL, 0, '', '.')}}   </span></strong></li>
                            </ul>

 <input type="hidden" id="product-cart" value="{{'['.rtrim($productOrder,", ").']' }}" />
	  <input type="hidden" id="ongkir-display-static" />

                            <div id="accordion" role="tablist" class="mb-4">
                                
                                 
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingFour">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"><i class="fa fa-circle-o mr-3"></i>direct bank transfer</a>
                                        </h6>
                                    </div>                                   
                                </div>
                            </div>

                             <a href="#" class="btn karl-checkout-btn" id="submit-form" style="background-color:#FF9B05;">Checkout NOW</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
