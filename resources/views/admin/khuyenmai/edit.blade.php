@extends('admin/layouts/masteradmin')
@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Cập nhật loại tin</h6>
                <form action="/admin/khuyenmai/updateform" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="put">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">ID khuyến mãi </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" name="idkhuyenmai" value="{{$km->idkhuyenmai}}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Tên khuyến mãi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" name="tenkhuyenmai" value="{{old('tenkhuyenmai') ?? $km->tenkhuyenmai}}">
                            @error('tenkhuyenmai')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="inputPassword3" name="ngaybatdau" value="{{old('ngaybatdau') ??$km->ngaybatdau}}">
                            @error('ngaybatdau')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="inputPassword3" name="ngayketthuc" value="{{old('ngaykethuc') ??$km->ngayketthuc}}">
                            @error('ngayketthuc')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                    </div>


                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Sửa">

                        <a href="/admin/khuyenmai" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop