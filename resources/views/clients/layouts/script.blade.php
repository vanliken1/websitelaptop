<script src="/asset/client/vendor/jquery/jquery.min.js"></script>
<script src="/asset/client/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/asset/client/vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="/asset/client/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/asset/client/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.js"></script>
<script src="/asset/client/js/front.js"></script>
<script>
  $.ajaxSetup({

    headers: {

      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

  });
  $(function() {
    var fiveSecond = 30000;
    var oneMinute = 1000 * 60;
    setInterval(function() {
      // var date = new Date();
      // var current_date = date.getHours()+"-"+date.getMinutes();
      // if(current_date == "0-0"){
      //     $.ajax({
      //         url: "/auto",
      //         type: "GET",
      //         success: function (data) {
      //             console.log(data)
      //         },
      //     });
      // }
      $.ajax({
        url: "/admin/khuyenmai/capnhatajax",
        type: "POST",
        success: function(data) {
          console.log('da chay');
        },
      });
    }, fiveSecond);
  })
</script>