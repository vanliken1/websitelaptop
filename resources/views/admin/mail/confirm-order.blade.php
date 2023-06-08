<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <style>




    </style>
</head>

<body>
    <div class="container" style="border-radius:12px;padding:15px;">
        <div class="col-md-12">
            <div class="row" style="background-color: #FFFAFA;padding:15px">
                <div class="col-md-6" style="text-align: center;color:blue;font-weight:bold;font-size:30px">
                    <h4 style="margin:0">CÔNG TY CÔNG NGHỆ BÁN LAPTOP HẠO VĂN</h4>
                    <h6 style="margin:0">DỊCH VỤ BÁN HÀNG-NHẬP KHẨU LAPTOP CHUYÊN NGHIỆP</h6>
                </div>
                <div class="col-md-6 logo" style="color:black">
                    <p>Chào bạn <strong style="color:black;text-decoration:underline;">{{ $dataEmail1['tennguoinhan'] }}</strong> </p>
                </div>
                <div class="col-md-12">
                    <p style="color:black;font-size:17px">Chúng tôi đã xác nhận đơn đặt hàng của bạn ở công ty chúng tôi với những thông tin sau:</p>
                    <h4 style="color: #000;text-transform:uppercase">Thông tin đơn hàng</h4>
                    <p>Mã đơn hàng:<strong style="text-transform:uppercase;color:black">{{$dataEmail1['madonhang']}}</strong></p>
                    <p>Mã giảm giá áp dụng:<strong style="text-transform:uppercase;color:black">@if($dataEmail1['magiamgia']!='no'){{$dataEmail1['magiamgia']}}@else{{'Không có'}}@endif</strong></p>
                    <h4 style="color:#000;text-transform:uppercase;">Thông tin người nhận</h4>
                    <p>
                        Họ tên người nhận:{{ $dataEmail1['tennguoigui'] }}
                    </p>
                    <p>
                        Địa chỉ nhận hàng:{{ $dataEmail1['diachinguoinhan'] }}
                    </p>
                    <p>
                        Số điện thoại:{{ $dataEmail1['sdtnguoinhan'] }}
                    </p>
                    <p>
                        Ghi chú:{{ $dataEmail1['ghichu'] }}
                    </p>
                    <p>
                        Hình thức thanh toán:
                        @if($dataEmail1['hinhthucthanhtoan']==0)
                        {{'Tiền mặt'}}
                        @else
                        {{'Chuyển khoản'}}
                        @endif
                    </p>
                    <p>Nếu thông tin người dùng không đúng có thể liên hệ với người đặt hàng để trao đổi thông tin về đơn hàng này</p>
                    <h4>Sản phẩm đã được chúng tôi xác nhận</h4>
                    <table class="table table-bordered mr-auto">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Số lượng đặt</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $tong = 0; ?>
                            @foreach($dataEmail1['cart'] as $item)
                            <?php $tong += $item->soluong * $item->gia; ?>
                            <tr>
                                <td>{{$item->products->tensanpham}}</td>
                                <td>{{number_format($item->gia,0,',','.')}}đ</td>
                                <td>{{$item->soluong}}</td>
                                <td>{{number_format($item->soluong * $item->gia, 0, ',', '.')}}</td>
                            </tr>
                            @endforeach



                        </tbody>

                    </table>
                    <div>
                        <h3>Tổng tiền thanh toán: {{number_format($tong, 0, ',', '.')}}đ </h3> <br />
                    </div>
                    <div>
                        Tổng thành tiền:{{number_format($tong,0,',','.')}} đ <br />
                        @php $tong_coupon=0 @endphp
                        @if($dataEmail1['tinhnangma']==0)
                        @php
                        $tongsaugiam = ($tong * $dataEmail1['sotiengiam']) / 100;
                        echo 'Tổng giảm giá :'.number_format($tongsaugiam,0,',','.') , 'đ' .'<br />';
                        $tong_coupon=$tong-$tongsaugiam;
                        @endphp
                        @else
                        @php
                        echo 'Tổng giảm giá :'.number_format($dataEmail1['sotiengiam'],0,',','.') , 'k' .'<br />';
                        $tong_coupon = $tong - $dataEmail1['sotiengiam'] ;
                        @endphp
                        @endif
                        Tổng cần thanh toán:{{number_format($tong_coupon,0,',','.')}} đ
                    </div>


                </div>
                <p>Mọi chi tiết liên hệ website tại:<a href="http://127.0.0.1:8000/">laptopvanhao.com</a>, hoặc liên hệ hotline 0985142764.Xin cảm ơn quý khách đã đặt hàng</p>

            </div>
        </div>
    </div>
</body>

</html>