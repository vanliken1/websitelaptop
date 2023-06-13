@extends('admin/layouts/masteradmin')
@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thông tin admin</h6>
                @if(session()->has('mess'))
                <p class="alert alert-success sm-4">
                    {{session('mess')}}
                </p>
                @endif
                <form action="/admin/updateadmin" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="put">

                    <div class="form-floating mb-3">

                        <input type="text" name='tennguoidung' id="tennguoidung" value="{{$nguoidung->tennguoidung}}" class='form-control mt-3'>
                        <label for="floatingInput">Tên người dùng</label>
                        @error('tennguoidung')
                        <p class="alert alert-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='email' id="email" value="{{$nguoidung->email}}" class='form-control mt-3' readonly>
                        <label for="floatingInput">Email</label>
                        @error('tennguoidung')
                        <p class="alert alert-danger">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">

                        <input type="text" name='sdt' id="sdt" value="{{$nguoidung->sdt}}" class='form-control mt-3'>
                        <label for="floatingInput">SĐT</label>
                        @error('sdt')
                        <p class="alert alert-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='diachi' id="diachi" value="{{$nguoidung->diachi}}" class='form-control mt-3'>
                        <label for="floatingInput">Địa chỉ</label>
                        @error('diachi')
                        <p class="alert alert-danger">{{$message}}</p>
                        @enderror
                    </div>





                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Cập nhật">

                        <a href="/admin" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop