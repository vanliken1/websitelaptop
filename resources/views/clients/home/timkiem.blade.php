@extends('clients/layouts/master')
@section('content')
<div id="all">
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li aria-current="page" class="breadcrumb-item active">Ladies</li>
                        </ol>
                    </nav>
                    <!-- <div class="box info-bar">
                        <div class="row">
                            <div class="col-md-12 col-lg-8 products-showing"><strong>Hiển thị tổng {{ $totalSanPham }} sản phẩm</strong></div>
                            <div class="col-md-12 col-lg-4 products-number-sort">
                                <form class="form-inline d-block d-lg-flex justify-content-between flex-column flex-md-row">
                                    <div class="products-number ml-auto"><span>Tìm kiếm theo</span> <strong>"{{$kw}}"</strong></div>

                                </form>
                            </div>

                        </div>
                    </div> -->
                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-md-12 col-lg-5 products-showing">Hiển thị tổng <strong>{{ $totalSanPham }} </strong>sản phẩm</div>


                            <div class="col-md-12 col-lg-3 products-number-sort">
                                <form class="form-inline d-block d-lg-flex justify-content-between flex-column flex-md-row">
                                    <div class="products-number"><span>Tìm kiếm theo</span> <strong>"{{$kw}}"</strong></div>
                              
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row products">
                        @foreach($sanphamtimkiem as $item)
                        <div class="col-lg-3 col-md-4">
                            <div class="product">
                                <div>
                                    <div>
                                        <div><img src="{{asset('storage/img/'.$item->img)}}" width="250px" height="350px" alt=""></div>

                                    </div>
                                </div>
                                <div class="text">

                                    <h3><a href="/chitiet/{{$item->slug_sanpham}}">{{$item->tensanpham}}</a></h3>
                                    <!-- <p class="price">
                                        @if ($item->trangthaictkm == 1)
                                        <del>{{ number_format($item->gia, 0, ',', '.') }} đ</del>
                                        <caption>-{{ $item->phantramkhuyenmai }}%</caption>
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ
                                    </div>
                                    @else
                                    <caption>{{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ</caption>
                                    <div style="text-align: center;">...</div>
                                    @endif
                                    </p> -->

                                    <?php $phantram = (($item->gia - $item->giakhuyenmai) / $item->gia) * 100 ?>
                                    @if($phantram!=0)
                                    <p class="price">

                                        <del>{{ number_format($item->gia, 0, ',', '.') }} đ</del>
                                        <caption>-{{ $phantram }}%</caption>
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ
                                    </div>

                                    </p>
                                    @else
                                    <p class="price">

                                        <caption>...</caption>

                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->gia, 0, ',', '.') }} đ
                                    </div>

                                    </p>
                                    @endif


                                    @if($item->soluong>0)
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        Còn hàng
                                    </div>
                                    @endif
                                    <p class="buttons">
                                        <a href="/chitiet/{{$item->slug_sanpham}}" class="btn btn-outline-secondary">View detail</a>
                                        <a class="btn btn-primary add-to-cart" data-id="{{$item->idsanpham}}"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </p>
                                </div>
                                <!-- /.text-->

                                <!-- /.ribbon-->
                                @if($item->hot == 1)
                                <div class="ribbon gift">
                                    <div class="theribbon">HOT</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                @endif

                                @if($item->gia > $item->giakhuyenmai)
                                <div class="ribbon sale">
                                    <div class="theribbon">SALES</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                @endif
                                <!-- /.ribbon-->
                            </div>
                            <!-- /.product            -->
                        </div>
                        @endforeach
                        <!-- /.products-->
                    </div>
                    <div class="pages">
                        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                            <ul class="pagination">
                                <li>{{$sanphamtimkiem->appends(Request::all())->links()}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /.col-lg-9-->
            </div>
        </div>
    </div>
</div>


@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).ready(function() {
        $('.add-to-cart').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            var url = "/cart/add/" + productId;
            // alert('hehe')
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thêm vào giỏ hàng thành công',
                            showConfirmButton: false,

                            timer: 4000,


                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sản phẩm đã tồn tại trong giỏ hàng',
                            showConfirmButton: false,

                            timer: 4000,


                        });

                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                },
                // error: function(xhr, status, error) {
                //     alert('An error occurred while adding the product to the cart.');
                // }
            });
        });
    });
</script>
@stop