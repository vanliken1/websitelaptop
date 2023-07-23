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
              <li aria-current="page" class="breadcrumb-item active">Lịch sử đơn hàng</li>
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
                <a href="/history" class="nav-link active"><i class="fa fa-list"></i>Lịch sử đơn hàng</a>
                <a href="/info" class="nav-link"><i class="fa fa-user"></i> Chi tiết tài khoản</a>
                <form action="/dangxuat" method="post">
                  @csrf
                  <button type="submit" class="btn btn-link" class="nav-link"><i class="fa fa-sign-out"></i>Đăng xuất</a>
                </form>
              </ul>
            </div>
          </div>
          <!-- /.col-lg-3-->
          <!-- *** CUSTOMER MENU END ***-->
        </div>
        <div id="customer-orders" class="col-lg-9">
          <div class="box">
            <h1>Lịch sử đơn hàng</h1>
            <p class="lead">Xin chào, {{auth()->user()->tennguoidung}}</p>
            <p class="text-muted">Ở đây bạn có thể xem đơn hàng , tình trạng đơn</p>
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
                      <span style="color: blue;">Đã xác nhận</span>
                      @elseif($item->trangthai==3)
                      <span style="color: red;">Hủy-sau xác nhận</span>
                      @elseif($item->trangthai==4)
                      <span style="color: SkyBlue;">Đang giao</span>
                      @elseif($item->trangthai==5)
                      <span style="color: cyan;">Đã giao</span>
                      @else
                      <span style="color: red;">Hủy-trước xác nhận</span>
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