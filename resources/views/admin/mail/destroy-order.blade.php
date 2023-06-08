<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thông tin đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Thông tin đơn hàng</h1>
    <p>Đơn hàng của quý khách đã hủy. Đơn hàng {{$dataEmail2['madonhang']}} đã được hủy bởi vì chúng tôi không đủ số lượng trong kho để hoàn thành đơn hàng của quý khách hoặc những lý do phụ khác</p>

    <h2>Các sản phẩm hoàn lại</h2>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Thành tiền</th>
        </tr>
        <?php $tong = 0; ?>
        @foreach($dataEmail2['cart'] as $item)
        <?php $tong += $item->soluong * $item->gia; ?>
        <tr>
            <td>
                {{$item->products->tensanpham}} x {{$item->soluong}}</td>
            <td>{{number_format($item->soluong * $item->gia, 0, ',', '.')}}</td>
        </tr>

        @endforeach
    </table>

    <p class="total">Tổng giá trị: {{ number_format($tong, 0, ',', '.') }} đ</p>
    @php $tong_coupon = 0 @endphp
    @if($dataEmail2['tinhnangma'] == 0)
    @php
    $tongsaugiam = ($tong * $dataEmail2['sotiengiam']) / 100;
    @endphp
    <p class="total">Giảm giá: {{ number_format($tongsaugiam, 0, ',', '.') }} đ</p>
    @php
    $tong_coupon = $tong - $tongsaugiam;
    @endphp
    @else
    <p class="total"> Giảm giá: {{ number_format($dataEmail2['sotiengiam'], 0, ',', '.') }}k</p>
    @php
    $tong_coupon = $tong - $dataEmail2['sotiengiam'];
    @endphp
    @endif
    <p class="total">Tổng thanh toán: {{ number_format($tong_coupon, 0, ',', '.') }} đ</p>


    <p>Nếu quý khách có bất kỳ câu hỏi nào, đừng ngần ngại liên lạc với chúng tôi qua Tổng đài 0985142764. Đội ngũ VanHao sẽ luôn sẵn sàng để hỗ trợ quý khách.</p>
</body>

</html>