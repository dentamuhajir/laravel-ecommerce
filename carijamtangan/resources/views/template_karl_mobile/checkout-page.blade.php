<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Checkout</title>

    <!-- Favicon  -->
    <link rel="icon" href="/mobile-assets/img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="/mobile-assets/css/core-style.css">
    <link rel="stylesheet" href="/mobile-assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/smokejs/3.1.1/css/smoke.css" integrity="sha256-+UsYt6eijIVe/AArxUHcmuvVkV5mqOo+2ZF1piTHwKc=" crossorigin="anonymous" />


    <!-- Responsive CSS -->
    <link href="/mobile-assets/css/responsive.css" rel="stylesheet">


</head>

<body>

     @include('template_karl_mobile.blocks.menubar')

    <div id="wrapper">

         @include('template_karl_mobile.blocks.header2')
    
         @include('template_karl_mobile.snippets.breadcrumb')

         @include('template_karl_mobile.snippets.checkout-form')

         @include('template_karl_mobile.blocks.footer')

	</div>


   <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ $BASE_URL }}/mobile-assets/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="{{ $BASE_URL }}/mobile-assets/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ $BASE_URL }}/mobile-assets/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="{{ $BASE_URL }}/mobile-assets/js/plugins.js"></script>
    <!-- Active js -->
    <script src="{{ $BASE_URL }}/mobile-assets/js/active.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/smokejs/3.1.1/js/smoke.js" integrity="sha256-ZrussbbOxbQ1lQrwtTyBFvYuJa8b/MyT3VNOtElRhyQ=" crossorigin="anonymous"></script>

        <script>
            $("#telphone").keyup(function() {
                $("#telphone").val(this.value.match(/[0-9]*/));
            });
        </script>

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


           if (nama  === '' || email === '' || telphone === '' || subTotal === '' || ongkir === '' || address === '') {
               alert('Pastikan Isi Semua Data Dengan benar.');
               return false;
            }



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

          	alert(hash);



            window.location.href = "{{$BASE_URL}}/terima-kasih/"+hash;
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
                    $('#sub-total').html('Rp '+convertToRupiah(totalPlusOngkir,' '));
                    $("#ongkir-display").html('Rp '+convertToRupiah(cost,'&nbsp;'));
                    $("#ongkir-display-static").val(cost);
                }
            });
        });
        </script>
 
</body>
</html>


