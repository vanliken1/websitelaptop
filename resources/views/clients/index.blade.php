@extends('clients/layouts/master')
@section('content')
<!-- Sale & Revenue Start -->
<div id="all">
  <div id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="main-slider" class="owl-carousel owl-theme">
            @foreach($banner as $item)
            <div class="item"><img src="{{asset('storage/img/'.$item->img)}}" alt="" class="img-fluid"></div>
            @endforeach
          </div>
          <!-- /#main-slider-->
        </div>
      </div>
    </div>
    <!--
        *** ADVANTAGES HOMEPAGE ***
        _________________________________________________________
        -->
    <div id="advantages">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
              <div class="icon"><i class="fa fa-heart"></i></div>
              <h3><a href="#">We love our customers</a></h3>
              <p class="mb-0">We are known to provide best possible service ever</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
              <div class="icon"><i class="fa fa-tags"></i></div>
              <h3><a href="#">Best prices</a></h3>
              <p class="mb-0">You can check that the height of the boxes adjust when longer text like this one is used in one of them.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
              <div class="icon"><i class="fa fa-thumbs-up"></i></div>
              <h3><a href="#">100% satisfaction guaranteed</a></h3>
              <p class="mb-0">Free returns on everything for 3 months.</p>
            </div>
          </div>
        </div>
        <!-- /.row-->
      </div>
      <!-- /.container-->
    </div>
    <!-- /#advantages-->
    <!-- *** ADVANTAGES END ***-->
    <!--
        *** HOT PRODUCT SLIDESHOW ***
        _________________________________________________________
        -->
    <div id="hot">
      <div class="box py-4">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mb-0">Sản phẩm HOT 🔥</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="product-slider owl-carousel owl-theme">
          @foreach($sanphamhot as $item)
          <div class="item">

            <div class="product">
              <div class="flip-container">
                <div>
                  <div><img src="{{asset('storage/img/'.$item->img)}}" width="400px" height="200px" alt=""></div>
                </div>
              </div>
              <div class="text">
                <h3><a href="/chitiet/{{$item->slug_sanpham}}">{{$item->tensanpham}}</a></h3>
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
              <div class="ribbon gift">
                <div class="theribbon">HOT</div>
                <div class="ribbon-background"></div>
              </div>
            </div>

            <!-- /.product-->
          </div>
          @endforeach

          <!-- /.product-slider-->
        </div>
        <!-- /.container-->
      </div>
      <!-- /#hot-->
      <!-- *** HOT END ***-->
    </div>
    <div id="hot">
      <div class="box py-4">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mb-0">Sản phẩm khuyến mãi 🎟️</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="product-slider owl-carousel owl-theme">
          @foreach($sanphamkhuyenmai as $item)
          <div class="item">

            <div class="product">
              <div class="flip-container">
                <div>
                  <div><img src="{{asset('storage/img/'.$item->img)}}" width="400px" height="200px" alt=""></div>
                </div>
              </div>
              <div class="text">
                <h3><a href="/chitiet/{{$item->slug_sanpham}}">{{$item->tensanpham}}</a></h3>
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
              <div class="ribbon sale">
                <div class="theribbon">SALES</div>
                <div class="ribbon-background"></div>
              </div>
            </div>

            <!-- /.product-->
          </div>
          @endforeach

          <!-- /.product-slider-->
        </div>
        <!-- /.container-->
      </div>
      <!-- /#hot-->
      <!-- *** HOT END ***-->
    </div>
  </div>
</div>
<!-- Widgets End -->
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