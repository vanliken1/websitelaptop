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
                </div>
                <div class="col-lg-3">
                    <!--
              *** MENUS AND FILTERS ***
              _________________________________________________________
              -->
                    <form action="/laptop" method="get">
                        <div class="card sidebar-menu mb-4">
                            <div class="card-header">
                                <h3 class="h4 card-title">Thương hiệu</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($thuonghieu as $item)
                                    <div class="checkbox">

                                        <label>
                                            <input type="checkbox" name="brand[]" value="{{$item->slug_thuonghieu}}"> {{$item->tenthuonghieu}}
                                        </label>

                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">CPU</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($cpu as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="cpu[]" value="{{$item->slug_CPU}}">{{$item->tenCPU}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>

                            </div>

                            <div class="card-header">
                                <h3 class="h4 card-title">Mức giá</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="gia[]" value="under_10"> Dưới 10 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="gia[]" value="10_to_15"> 10-15 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="gia[]" value="15_to_20"> 15-20 triệu
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="gia[]" value="20_to_25"> 20-25 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="gia[]" value="over_25"> Trên 25 triệu
                                        </label>
                                    </div>


                                </div>
                            </div>

                            <button type="submit" class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Lọc</button>

                        </div>

                    </form>
                    <!-- *** MENUS AND FILTERS END ***-->
                </div>
                <div class="col-lg-9">

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-md-12 col-lg-4 products-showing"><strong>Hiển thị tổng {{ $totalSanPham }} sản phẩm</strong></div>
                            <div class="col-md-12 col-lg-7 products-number-sort">
                                <form class="form-inline d-block d-lg-flex justify-content-between flex-column flex-md-row">
                                    <div class="products-number"><strong>Show</strong><a href="#" class="btn btn-sm btn-primary">12</a><a href="#" class="btn btn-outline-secondary btn-sm">24</a><a href="#" class="btn btn-outline-secondary btn-sm">All</a><span>products</span></div>
                                    <div class="products-sort-by mt-2 mt-lg-0"><strong>Sort by</strong>
                                        <select name="sort-by" class="form-control">
                                            <option>Price</option>
                                            <option>Name</option>
                                            <option>Sales first</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row products">
                        @foreach($sanpham as $item)
                        <div class="col-lg-4 col-md-6">
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
                                <div class="ribbon gift">
                                    <div class="theribbon">GIFT</div>
                                    <div class="ribbon-background"></div>
                                </div>

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
                                <li>{{$sanpham->appends(Request::all())->links()}}</li>
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