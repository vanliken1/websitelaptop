@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thông tin người dùng</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên khách hàng</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                            </tr>
                        </thead>
                        @foreach($donhang as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->users->tennguoidung}}</td>
                                <td>{{$item->users->sdt}}</td>
                                <td>{{$item->users->email}}</td>
                                <td>{{$item->users->diachi}}</td>


                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thông tin đơn hàng</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã đơn hàng</th>
                                <th>Tên người nhận</th>
                                <th>SĐT người nhận</th>
                                <th>Địa chỉ người nhận</th>
                                <th>Hình thức thanh toán</th>
                                <th>Ngày đặt</th>
                                <th>Ghi chú</th>

                            </tr>
                        </thead>
                        @foreach($donhang as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->iddonhang}}</td>
                                <td>{{$item->tennguoinhan}}</td>
                                <td>{{$item->sdtnguoinhan}}</td>
                                <td>{{$item->diachinguoinhan}}</td>
                                <td>
                                    @if($item->hinhthuc==0)
                                    {{'Thanh toán tiền mặt'}}
                                    @elseif($item->hinhthuc==1)
                                    {{'Thanh toán chuyển khoản'}}
                                    @elseif($item->hinhthuc==2)
                                    {{'Thanh toán MoMo'}}
                                    @else
                                    {{'Thanh toán VNPAY'}}
                                    @endif
                                </td>
                                <td>{{$item->ngaydat}}</td>
                                <td>{{$item->note}}</td>


                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Chi tiết đơn hàng</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng kho</th>
                                <th>Giá </th>
                                <th>Giá khuyến mãi</th>
                                <th>Mã coupon</th>
                                <th>Mã khuyến mãi</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>


                            </tr>
                        </thead>

                        <tbody>
                            <?php $tong = 0; ?>
                            @foreach($chitietdonhang as $item)
                            <?php $tong += $item->soluong * $item->gia; ?>
                            <tr>
                                <td>{{$item->products->idsanpham}}</td>
                                <td>{{$item->products->tensanpham}}</td>
                                <td>{{$item->products->soluong}}</td>
                                <td>{{number_format($item->giagoc,0,',','.')}}</td>
                                <td>{{number_format($item->gia,0,',','.')}}</td>

                                <td>
                                    @if($item->codegiamgia != 'no')
                                    {{$item->codegiamgia}}
                                    @else
                                    Không mã
                                    @endif
                                </td>
                                <td>
                                    @if($item->makhuyenmai != null)
                                    {{$item->makhuyenmai}}
                                    @else
                                    {{'Không mã'}}
                                    @endif
                                </td>
                                <td>
                                    <!-- //soluong khach hang dat -->
                                    <input type="number" min="1" value="{{number_format($item->soluong,0, ',', '.')}}" data-product-id="{{$item->products->idsanpham}}" class="order_qty_{{$item->products->idsanpham}} soluongne" name="soluonghang" {{$item->orders->trangthai==2?'disabled':''}}{{$item->orders->trangthai==3?'disabled':''}} {{$item->orders->trangthai==4?'disabled':''}} {{$item->orders->trangthai==5?'disabled':''}}{{$item->orders->trangthai==6?'disabled':''}} />
                                    <!-- <input type="text" readonly  value="{{number_format($item->soluong,0, ',', '.')}}" class="order_qty_{{$item->products->idsanpham}}" name="soluonghang"> -->

                                    <!-- //so luong kho -->
                                    <input type="hidden" name="order_soluongton" class="order_soluongton_{{$item->products->idsanpham}}" value="{{$item->products->soluong}}">
                                    <!-- //ma don hang -->
                                    <input type="hidden" name="order_iddonhang" class="order_iddonhang" value="{{$item->iddonhang}}">
                                    <!-- //ma san pham  -->

                                    <input type="hidden" name="order_product_id" class="order_product_id" value="{{$item->products->idsanpham}}">

                                </td>
                                <td>{{number_format($item->soluong * $item->gia, 0, ',', '.')}}</td>


                            </tr>

                            @endforeach
                            <tr>
                                <td colspan="2">
                                    @foreach($donhang as $dh)
                                    @if($dh->trangthai==1)
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" selected value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" value="6">Hủy-trước xác nhận</option>

                                        </select>
                                    </form>
                                    @elseif($dh->trangthai==2)
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" selected value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="6">Hủy-trước xác nhận</option>

                                        </select>
                                    </form>
                                    @elseif($dh->trangthai==3)
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" selected value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="6">Hủy-trước xác nhận</option>
                                        </select>
                                    </form>
                                    @elseif($dh->trangthai==4)
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" selected value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="6">Hủy-trước xác nhận</option>

                                        </select>
                                    </form>
                                    @elseif($dh->trangthai==5)
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" selected value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="6">Hủy-trước xác nhận</option>

                                        </select>
                                    </form>
                                    @else
                                    <form method="post">
                                        @csrf
                                        <select class="form-control trangthaidh">
                                            <option value="">--Chọn phương thức xử lý--</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="1">Chưa xử lý</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="2">Đã xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="3">Hủy-sau xác nhận</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="4">Đang giao</option>
                                            <option id="{{$dh->iddonhang}}" disabled style="display: none;" value="5">Đã giao</option>
                                            <option id="{{$dh->iddonhang}}" selected value="6">Hủy-trước xác nhận</option>

                                        </select>
                                    </form>

                                    @endif
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>



                    </table>
                    <div>
                        Tổng thành tiền:{{number_format($tong,0,',','.')}} đ <br />
                        @php $tong_coupon=0 @endphp
                        @if($tinhnangma==0)
                        @php
                        $tongsaugiam = ($tong * $sotiengiam) / 100;
                        echo 'Tổng giảm :'.number_format($tongsaugiam,0,',','.') , 'đ' .'<br />';
                        $tong_coupon=$tong-$tongsaugiam;
                        @endphp
                        @else
                        @php
                        echo 'Tổng giảm :'.number_format($sotiengiam,0,',','.') , 'k' .'<br />';
                        $tong_coupon = $tong - $sotiengiam ;
                        @endphp
                        @endif
                        Thanh toán:{{number_format($tong_coupon,0,',','.')}} đ
                        <input type="hidden" class="tongthanhtoan" value="{{$tong_coupon}}">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Table End -->
@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).ready(function() {
        $('.soluongne').change(function() {
            var order_product_id = $(this).data('product-id');
            var order_qty = $('.order_qty_' + order_product_id).val();
            var order_donhang = $('.order_iddonhang').val();


            var _token = $('input[name="_token"]').val();
            // alert(order_product_id);
            // // alert(order_qty);
            // alert(order_donhang);
            if (order_qty <= 0) {
                alert('Số không được âm');
                location.reload();
            } else {
                $.ajax({
                    url: '/updateqty',
                    type: 'POST',
                    data: {
                        _token: _token,
                        order_qty: order_qty,
                        order_donhang: order_donhang,
                        order_product_id: order_product_id
                    },

                    success: function(data) {

                        Swal.fire({
                            title: "Thay đổi trạng thái thành công",
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            timerProgressBar: true,
                        }).then(function() {
                            location.reload();
                        });
                    },
                });
            }
        });

        $('.trangthaidh').change(function() {
            var trangthaidh = $(this).val();
            var iddonhang = $(this).children(":selected").attr('id');
            var _token = $('input[name="_token"]').val();
            // alert(trangthaidh);
            var tongthanhtoan = $('.tongthanhtoan').val();
            // alert(tongthanhtoan);
            var quantity = [];
            $("input[name='soluonghang']").each(function() {
                quantity.push($(this).val());
            });

            var order_product_id = [];
            $("input[name='order_product_id']").each(function() {
                order_product_id.push($(this).val());
            });

            dem = 0;
            for (i = 0; i < order_product_id.length; i++) {
                var soluongid = $('.order_qty_' + order_product_id[i]).val();
                var soluongkho = $('.order_soluongton_' + order_product_id[i]).val();

                if (parseInt(soluongid) > parseInt(soluongkho) && trangthaidh == 2) {
                    dem = dem + 1;
                    if (dem == 1) {
                        Swal.fire({
                            title: "Số lượng kho không đủ",
                            icon: "error",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            timerProgressBar: true,
                        }).then(function() {
                            location.reload();
                        });
                    }
                }
                if (parseInt(soluongid) > parseInt(soluongkho) && trangthaidh == 3) {
                    dem = 0;
                }


            }


            if (dem == 0) {

                $.ajax({
                    url: '/updatesoluong',
                    type: 'POST',
                    data: {
                        _token: _token,
                        trangthaidh: trangthaidh,
                        iddonhang: iddonhang,
                        quantity: quantity,
                        order_product_id: order_product_id,
                        tongthanhtoan: tongthanhtoan

                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Thay đổi trạng thái thành công",
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            timerProgressBar: true,
                        }).then(function() {
                            location.reload();
                        });
                    },
                });

            }
        });
    });
</script>
@stop