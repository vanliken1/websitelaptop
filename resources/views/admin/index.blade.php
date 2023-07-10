@extends('admin/layouts/masteradmin')
@section('content')
<!-- Sale & Revenue Start -->
@if(session()->has('status'))
<script>
    alert("{{ session('status') }}");
</script>
@endif
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-laptop fa-3x text-primary"></i>
                <div class="ms-3">

                    <p class="mb-2">Tổng sản phẩm</p>
                    <h6 class="mb-0">{{$sanpham_count}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Tổng khách hàng</p>
                    <h6 class="mb-0">{{$user_count}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-shopping-bag fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Tổng đơn hàng</p>
                    <h6 class="mb-0">{{$order_count}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Tổng doanh thu</p>
                    <h6 class="mb-0">{{number_format($totalRevenue,0,',','.')}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="row ">
            <p>Thống kê doanh thu đơn hàng</p>
            <form class="d-flex" >
                @csrf
                <div class="col-md-2 mx-2">
                    <p>Từ ngày:<input type="text" id="datepicker" class="form-control"></p>
                </div>
                <div class="col-md-2 mx-2">
                    <p>Đến ngày:<input type="text" id="datepicker2" class="form-control"></p>

                </div>
                
                <div class="col-md-1 mb-2">
                    
                    <input type="button" id="btn-date-filter" class="btn btn-primary mt-4"  value="Lọc">
                </div>

                
               


            </form>
            <div class="col-md-2 mx-2">
                <p>Lọc theo:
                    <select class="filter-date2 form-control">
                        <option>--Chọn--</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="1nam">1 Năm qua</option>
                    </select>
                </p>
            </div>
            <div class="col-md-12">
                <div id="firstchart" style="height: 250px;"></div>
            </div>
        </div>
    </div>
</div>



<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Đơn hàng gần đây</h6>

        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID đơn hàng</th>
                        <th>Ngày đặt</th>


                        <th>Trạng thái</th>
                        <th>📄</th>

                    </tr>
                </thead>
                @foreach($donhangganday as $item)
                <tbody>
                    <tr>
                        <td>{{$item->iddonhang}}</td>
                        <td>{{$item->ngaydat}}</td>
                        <td>
                            @if($item->trangthai==1)
                            <span style="color: green;">Đơn hàng mới</span>
                            @elseif($item->trangthai==2)
                            <span style="color: blue;">Đã xử lý</span>
                            @elseif($item->trangthai==3)
                            <span style="color: red;">Hủy-sau xử lý</span>
                            @elseif($item->trangthai==4)
                            <span style="color: SkyBlue;">Đang giao</span>
                            @elseif($item->trangthai==5)
                            <span style="color: cyan;">Đã giao</span>
                            @else
                            <span style="color: red;">Hủy-trước xử lý</span>
                            @endif

                        </td>
                        <td><a class="btn btn-sm btn-primary" href="/admin/donhang/chitiet/{{$item->iddonhang}}">Detail</a></td>
                    </tr>

                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->

@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).ready(function() {
        chart30ngayqua();
        $("#datepicker").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd ",
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"]
        });
        $("#datepicker2").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "yy-mm-dd ",
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"]
        });
        var chart = new Morris.Area({
            // ID of the element in which to draw the chart.
            element: 'firstchart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            lineColors: ['#819C79', '#fc8710', '#FF6541'],
            pointFillColors: ['#ffffff'],
            pointStrokeColors: ['black'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            parseTime: false,
            // The name of the data record attribute that contains x-values.
            xkey: 'khoangngay',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['doanhthu', 'soluongdaban', 'tongdonhang'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            behaveLikeLine: true,
            labels: ['Doanh thu', 'Số lượng đã bán', 'Tổng đơn hàng đã bán']

        });

        function chart30ngayqua() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/admin/rs30day',
                type: 'POST',

                data: {
                    _token: _token
                },
                dataType: 'json',

                // async: false,
                // cache: false,
                // enctype: 'multipart/form-data',
                success: function(s) {
                    console.log(s);
                    chart.setData(s);

                },
            });
        }
        $("#btn-date-filter").click(function() {
            var _token = $('input[name="_token"]').val();
            var tungay = $("#datepicker").val();
            var denngay = $("#datepicker2").val();
            // alert(_token);
            $.ajax({
                url: '/admin/filter-date',
                type: 'POST',

                data: {
                    tungay: tungay,
                    denngay: denngay,
                    _token: _token
                },
                dataType: 'json',

                // async: false,
                // cache: false,
                // enctype: 'multipart/form-data',
                success: function(s) {
                    console.log(s);
                    chart.setData(s);

                },
            });
        });
        $(".filter-date2").change(function() {
            var _token = $('input[name="_token"]').val();
            var value_select = $(this).val();

            // alert(value_select);
            $.ajax({
                url: '/admin/filter-date2',
                type: 'POST',

                data: {
                    _token: _token,
                    value_select: value_select
                },
                dataType: 'json',
                success: function(s) {
                    console.log(s);
                    chart.setData(s);

                },
            });
        });
    });
</script>
@stop