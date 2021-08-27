

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">


	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{$BASE_URL}}/checkout-assets/css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{$BASE_URL}}/checkout-assets/css/bootstrap.css">


	<!-- Date Picker -->
	<link rel="stylesheet" href="{{$BASE_URL}}/checkout-assets/css/bootstrap-datepicker.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="{{$BASE_URL}}/checkout-assets/fonts/flaticon/font/flaticon.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="{{$BASE_URL}}/checkout-assets/css/style.css">

	<!-- Modernizr JS -->
	<script src="{{$BASE_URL}}/checkout-assets/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->



	<div class="colorlib-loader"></div>
<input type="hidden" value="<?php echo $CART_TOTAL; ?>" id="sub-total-static"/>
	<div id="page">


		<div class="colorlib-shop" style="color:black">
			<div class="container">
				<div class="row row-pb-md">

				</div>
				<div class="row">
					<div class="col-md-7">
						<form method="post" class="colorlib-form">
							<h2>Detail Formulir</h2>
		              	<div class="row">

			               		 <div class="col-md-12">
									<div class="form-group">
										<label for="name">Nama Lengkapi</label>
			                    	<input type="text" id="name" class="form-control" placeholder="Tulis nama lengkap kamu">
			                  </div>
			               </div>

						    <div class="col-md-12">
									<div class="form-group">
										<label for="numberphone">Nomor Ponsel / Whatsapp</label>
			                    	<input type="text" id="telphone" class="form-control" placeholder="Contoh : 081385800400">
			                  </div>
			               </div>
			                   <div class="col-md-12">
									<div class="form-group">
										<label for="numberphone">Email </label>
			                    	<input type="text" id="email" class="form-control" placeholder="contoh : emailkamu@gmail.com">
			                  </div>
			               </div>






							   <div class="col-md-12">
			                  <div class="form-group" >





			                  	<label for="country">Provinsi</label>
			                     <div class="form-field">
			                     	<i class="icon icon-arrow-down3"></i>
			                        <select   id="select-province" class="form-control">


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
			                        <select name="people" id="select-city" class="form-control">

			                        </select>
			                     </div>
			                  </div>
			               </div>

			               <div class="col-md-12">
									<div class="form-group">
										<label for="fname">Alamat</label>
										<textarea  id="address" class="form-control" rows="5"></textarea>

			                  </div>

			               </div>




						<!-- 		<div class="form-group">
									<div class="col-md-12">
										<div class="radio">
										  <label><input type="radio" name="optradio">Create an Account? </label>
										  <label><input type="radio" name="optradio"> Ship to different address</label>
										</div>
									</div>
								</div> -->
		              </div>
		            </form>
					</div>
					<div class="col-md-5">
						<div class="cart-detail">
							<h2>Cart Total</h2>
							<ul>
								<li>

									<ul>

										 <?php
$productOrder = "";
foreach (Cart::content() as $row):

	$productOrder .= '{';
	$productOrder .= '"id" :' . '"' . $row->id . '"' . ',';
	$productOrder .= '"name" :' . '"' . $row->name . '"' . ',';
	$productOrder .= '"picture" :' . '"' . $row->options->pic . '_220X290.jpg"' . ',';
	$productOrder .= '"price" :' . $row->price . '},';

	?>
																																																																                            <li><span>

																																																																                            <?php
	$str = $row->name;
	if (strlen($str) > 40) {
		$str = substr($str, 0, 40) . '...';
	}

	echo ucwords(strtolower($str));

	?>


																																																																                            </span> <span>  {{ number_format($row->price, 0, '', '.')}}</span></li>
																																																																                            <?php endforeach;?>

									</ul>
								</li>
								<li><span>Ongkir JNE Regular</span> <span id="ongkir-display">-</span></li>
								<!-- <li><span><i>Unique Code *</i></span> <span >13</span></li> -->
								<li><span><b>Order Total</b></span> <strong><span id="sub-total">   {{ number_format($CART_TOTAL, 0, '', '.')}}   </span></strong></li>



							</ul>
						</div>



						<div class="cart-detail">


							<h2>Payment Method</h2>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									   <label><input type="radio" name="optradio" checked >Direct Bank Tranfer</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									  &nbsp;&nbsp;<img src="images/logo/bankindonesia.png" width="50%"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="checkbox">
									   <label><input type="checkbox" value="">Saya menyetujui ketentuan dan syarat yang berlaku</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p><a href="#" id="submit-form" class="btn btn-primary btn-block btn-lg"><strong>C H E K O U T &nbsp; S E K A R A N G</strong></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



	</div>

	 <input type="hidden" id="product-cart" value="{{'['.rtrim($productOrder,", ").']' }}" />
	  <input type="hidden" id="ongkir-display-static" />



	<!-- jQuery -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="{{$BASE_URL}}/checkout-assets/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.waypoints.min.js"></script>
	<!-- Flexslider -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.flexslider-min.js"></script>
	<!-- Owl carousel -->
	<script src="{{$BASE_URL}}/checkout-assets/js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.magnific-popup.min.js"></script>
	<script src="{{$BASE_URL}}/checkout-assets/js/magnific-popup-options.js"></script>
	<!-- Date Picker -->
	<script src="{{$BASE_URL}}/checkout-assets/js/bootstrap-datepicker.js"></script>
	<!-- Stellar Parallax -->
	<script src="{{$BASE_URL}}/checkout-assets/js/jquery.stellar.min.js"></script>
	<!-- Main -->
	<script src="{{$BASE_URL}}/checkout-assets/js/main.js"></script>



	   <script>
	   	$(document).ready(function() {
	   		if($('#sub-total-static').val()==0)
	   		{
	   			 window.top.location.href = "{{$BASE_URL}}/keranjang-belanja"
	   		}
	   	});


	   </script>
       <script>
        $("#submit-form").click(function(){



          var nama= $('#name').val();
          var email= $('#email').val();
          var telphone= $('#telphone').val();
          var subTotal = $('#sub-total-static').val();
          var ongkir = $('#ongkir-display-static').val();
          var address =  $('#address').val();
          var productCart = $('#product-cart').val();
          var city = $('#select-city option:selected').text();



         $.ajax({
              type : 'POST',
              url : '{{$BASE_URL}}/api/save/order-form',
              data :  {
                'getNama' : nama,
                'getEmail' : email,
                'getTelphone' : telphone,
                'getSubTotal' : subTotal,
                'getOngkir' : ongkir,
                'getAddress' : address,
                'getProductCart' : productCart,
                'getCity' : city
            },
          success: function (hash) {
           alert("ewew"+hash);

            window.top.location.href = "{{$BASE_URL}}/terima-kasih/"+hash;
            //$("#select-city").html(data);
          }
          });

        });


        $("#select-province").change(function(){

            var getIdProvince = $('#select-province').val();
            $.ajax({
                type : 'POST',
                url : '{{$BASE_URL}}/api/v1.0/grab-rajaongkir-city',
                data :  {'province_id' : getIdProvince},
                success: function (data) {
                    $("#select-city").html(data);
                }
            });

        });

        function convertToRupiah(angka,rp)
        {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rp+' '+rupiah.split('',rupiah.length-1).reverse().join('');
        }

        $("#select-city").change(function(){
            var getIdCity  =$('#select-city').val();
            $.ajax({
                type : 'POST',
                url : '{{$BASE_URL}}/api/v1.0/grab-rajaongkir-cost',
                data :  {'city_id' : getIdCity },
                success: function (cost) {
                    var totalPlusOngkir = 0;
                    var subTotal =$('#sub-total-static').val();
                    var totalPlusOngkir = parseInt(subTotal)+parseInt(cost);
                    $('#sub-total').html(convertToRupiah(totalPlusOngkir,' '));
                    $("#ongkir-display").html(convertToRupiah(cost,'&nbsp;'));
                    $("#ongkir-display-static").val(cost);
                }
            });
        });
        </script>



	</body>
</html>

