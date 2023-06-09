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
              <li aria-current="page" class="breadcrumb-item active">My orders</li>
            </ol>
          </nav>
        </div>
        <div class="col-lg-3">
          <!--
              *** CUSTOMER MENU ***
              _________________________________________________________
              -->
          <div class="card sidebar-menu">
            <div class="card-header">
              <h3 class="h4 card-title">Thông tin khách hàng</h3>
            </div>
            <div class="card-body">
              <ul class="nav nav-pills flex-column">
                <a href="/history" class="nav-link active"><i class="fa fa-list"></i> My orders</a>
                <a href="customer-wishlist.html" class="nav-link"><i class="fa fa-heart"></i> My wishlist</a>
                <a href="/info" class="nav-link"><i class="fa fa-user"></i> My account</a>
                <a href="index.html" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a>
              </ul>
            </div>
          </div>
          <!-- /.col-lg-3-->
          <!-- *** CUSTOMER MENU END ***-->
        </div>
        <div id="customer-orders" class="col-lg-9">
          <div class="box">
            <h1>My orders</h1>
            <p class="lead">Your orders on one place.</p>
            <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
            <hr>
            <div class="table-responsive">
              <table class="table table-hover">

                <thead>
                  <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>👁️‍🗨️</th>
                  </tr>
                </thead>
                @foreach($donhang as $item)
                <tbody>

                  <tr>
                    <th>{{$item->iddonhang}}</th>
                    <td>{{$item->ngaydat}}</td>
                    <td> @if($item->trangthai==1)
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
                    <td><a href="/history-details/{{$item->iddonhang}}" class="btn btn-primary btn-sm">View</a></td>
                  </tr>
                </tbody>
                @endforeach
              </table>
              <div class="pages">
                        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                            <ul class="pagination">
                                <li>{{$donhang->links()}}</li>
                            </ul>
                        </nav>
                    </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop