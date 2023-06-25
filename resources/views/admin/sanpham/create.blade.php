@extends('admin/layouts/masteradmin')
@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thêm sản phẩm</h6>
                <form action="/admin/product/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control mt-3" id="idsanpham" name="idsanpham" value="{{old('idsanpham')}}">
                        <label for="floatingInput">Mã</label>
                        @error('idsanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='tensanpham' id="tensanpham" class='form-control mt-3' value="{{old('tensanpham')}}">
                        <label for="floatingInput">Tên Sản phẩm</label>
                        @error('tensanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='slug_sanpham' id="slug_sanpham" class='form-control mt-3' value="{{old('slug_sanpham')}}">
                        <label for="floatingInput">Slug</label>
                        @error('slug_sanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idthuonghieu' id="idthuonghieu" class='form-select mb-3'>
                            <option value="">--Chọn thương hiệu--</option>

                            @foreach($thuonghieu as $item)
                            <option value="{{$item->idthuonghieu}}" @if(old('idthuonghieu')==$item->idthuonghieu) selected @endif>{{$item->tenthuonghieu}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Thương hiệu(*)</label>
                        @error('idthuonghieu')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idCPU' id="idCPU" class='form-select mb-3'>
                            <option value="">--Chọn CPU--</option>
                            @foreach($cpu as $item)
                            <option value="{{$item->idCPU}}" @if(old('idCPU')==$item->idCPU) selected @endif>{{$item->tenCPU}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">CPU(*)</label>
                        @error('idCPU')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idram' id="idram" class='form-select mb-3'>
                            <option value="">--Chọn RAM--</option>

                            @foreach($ram as $item)
                            <option value="{{$item->idram}}" @if(old('idram')==$item->idram) selected @endif>{{$item->tenram}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Ram(*)</label>
                        @error('idram')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='iddohoa' id="iddohoa" class='form-select mb-3'>
                            <option value="">--Chọn Card Đồ Họa--</option>

                            @foreach($dohoa as $item)
                            <option value="{{$item->iddohoa}}" @if(old('iddohoa')==$item->iddohoa) selected @endif>{{$item->tendohoa}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Card đồ họa(*)</label>
                        @error('iddohoa')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idluutru' id="idluutru" class='form-select mb-3'>
                            <option value="">--Chọn Ổ cứng--</option>


                            @foreach($luutru as $item)
                            <option value="{{$item->idluutru}}" @if(old('idluutru')==$item->idluutru) selected @endif>{{$item->tenluutru}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Ổ cứng(*)</label>
                        @error('idluutru')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idmanhinh' id="idmanhinh" class='form-select mb-3'>

                            <option value="">--Chọn Kích thước màn hình--</option>
                            @foreach($manhinh as $item)
                            <option value="{{$item->idmanhinh}}" @if(old('idmanhinh')==$item->idmanhinh) selected @endif>{{$item->tenmanhinh}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Màn hình(*)</label>
                        @error('idmanhinh')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idloaisanpham' id="idloaisanpham" class='form-select mb-3'>

                            <option value="">--Chọn Nhu cầu sử dụng--</option>
                            @foreach($loaisp as $item)
                            <option value="{{$item->idloaisanpham}}" @if(old('idloaisanpham')==$item->idloaisanpham) selected @endif>{{$item->tenloai}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Nhu cầu(*)</label>
                        @error('idloaisanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <input type="file" name='img' class='form-control mt-3'>

                        <label for="floatingInput">Hình ảnh</label>
                        @error('img')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <textarea style="height: 150px;" name="motasanpham" id="motasanpham" class='form-control'> {{old('motasanpham')}}</textarea>
                        <label for="floatingInput">Mô tả</label>
                        @error('motasanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea style="height: 150px;" name="noidung" id="noidung" class='form-control'>{{old('noidung')}}</textarea>
                        <script>
                            CKEDITOR.replace('noidung', {
                                filebrowserBrowseUrl: '/asset/admin/ckfinder/ckfinder.html',
                                filebrowserUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageBrowseUrl: '/asset/admin/ckfinder/ckfinder.html?type=Images',
                                filebrowserFlashBrowseUrl: '/asset/admin/ckfinder/ckfinder.html?type=Flash',
                                filebrowserImageUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                filebrowserWindowWidth: '1000',
                                filebrowserWindowHeight: '700'
                            });
                        </script>
                        @error('noidung')
                        <span style="color: red;">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-floating mb-3">

                        <input type="number" min="1" step="1" value="{{old('gia')}}"  name='gia' class='form-control mt-3' required>
                        <label for="floatingInput">Giá</label>
                        @error('gia')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>


                    <div class="form-floating mb-3">

                        <input type="number" min="1" value="{{ old('soluong', 1) }}" name='soluong' id="soluong" class='form-control mt-3'>
                        <label for="floatingInput">Số lượng</label>
                        @error('soluong')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">HOT</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hot" id="gridRadios1" value="1">
                                <label class="form-check-label" for="gridRadios1">
                                    Có
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hot" id="gridRadios2" value="0" checked>
                                <label class="form-check-label" for="gridRadios2">
                                    Không
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-floating mb-3">

                        <select type="number" name='trangthai' class='form-select mt-3'>
                            <option value="0">Ẩn</option>
                            <option value="1" selected>Hiện</option>
                        </select>
                        <label for="floatingInput">Trạng thái</label>
                        <span class="text-danger error-text trangthai_err"></span>
                    </div>




                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Thêm">

                        <a href="/admin/product" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop