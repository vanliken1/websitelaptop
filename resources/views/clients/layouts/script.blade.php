<script src="/asset/client/vendor/jquery/jquery.min.js"></script>
<script src="/asset/client/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/asset/client/vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="/asset/client/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/asset/client/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.js"></script>
<script src="/asset/client/js/front.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script>
  $.ajaxSetup({

    headers: {

      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

  });
  $(function() {
    var fiveSecond = 60000;
    var oneMinute = 1000 * 60;
    $.ajax({
      url: "/admin/khuyenmai/capnhatajax",
      type: "POST",
      success: function(data) {
        console.log('da chay');

      },
    });
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

  window.onload = function() {
    var alertMessage = "{{ session('alert') }}";
    if (alertMessage) {
      // alert(alertMessage);
      Swal.fire({
        title: "Thông báo",
        text: alertMessage,
        icon: "error",
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        toast: true,
        timerProgressBar: true
      })
    }
  }
</script>