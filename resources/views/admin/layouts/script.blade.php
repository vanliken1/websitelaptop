<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/asset/admin/lib/chart/chart.min.js"></script>
<script src="/asset/admin/lib/easing/easing.min.js"></script>
<script src="/asset/admin/lib/waypoints/waypoints.min.js"></script>
<script src="/asset/admin/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="/asset/admin/lib/tempusdominus/js/moment.min.js"></script>
<script src="/asset/admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="/asset/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/asset/admin/js/main.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>
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
</script>