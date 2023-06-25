@extends('admin/layouts/masteradmin')
@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thêm sản phẩm</h6>
                <form action="/admin/product/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="put">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{$sanpham->idsanpham}}" name="idsanpham" readonly>
                        <label for="floatingInput">Mã</label>
                        <span class="text-danger error-text idsanpham_err"></span>

                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='tensanpham' value="{{ old('tensanpham') ?? $sanpham->tensanpham }}" class='form-control mt-3'>
                        <label for="floatingInput">Tên Sản phẩm</label>
                        @error('tensanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='slug_sanpham' value="{{ old('slug_sanpham') ?? $sanpham->slug_sanpham}}" class='form-control mt-3'>
                        <label for="floatingInput">Slug</label>
                        @error('slug_sanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <select name='idthuonghieu' class='form-select mb-3' required>
                            @foreach($thuonghieu as $item)
                            <option value="{{$item->idthuonghieu}}" @if(old('idthuonghieu')==$item->idthuonghieu) selected @endif {{$sanpham->idthuonghieu == $item->idthuonghieu ? 'selected': '' }}>{{$item->tenthuonghieu}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Thương hiệu(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='idCPU' class='form-select mb-3'>

                            @foreach($cpu as $item)
                            <option value="{{$item->idCPU}}" @if(old('idCPU')==$item->idCPU) selected @endif {{$sanpham->idCPU == $item->idCPU ? 'selected': '' }}>{{$item->tenCPU}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">CPU(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='idram' class='form-select mb-3'>


                            @foreach($ram as $item)
                            <option value="{{$item->idram}}" @if(old('idram')==$item->idram) selected @endif {{$sanpham->idram == $item->idram ? 'selected': '' }}>{{$item->tenram}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Ram(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='iddohoa' class='form-select mb-3'>


                            @foreach($dohoa as $item)
                            <option value="{{$item->iddohoa}}" @if(old('iddohoa')==$item->iddohoa) selected @endif {{$sanpham->iddohoa == $item->iddohoa ? 'selected': '' }}>{{$item->tendohoa}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Card đồ họa(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='idluutru' class='form-select mb-3'>


                            @foreach($luutru as $item)
                            <option value="{{$item->idluutru}}" @if(old('idluutru')==$item->idluutru) selected @endif {{$sanpham->idluutru == $item->idluutru ? 'selected': '' }}> {{$item->tenluutru}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Ổ cứng(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='idmanhinh' class='form-select mb-3'>


                            @foreach($manhinh as $item)
                            <option value="{{$item->idmanhinh}}" @if(old('idmanhinh')==$item->idmanhinh) selected @endif {{$sanpham->idmanhinh == $item->idmanhinh ? 'selected': '' }}>{{$item->tenmanhinh}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Màn hình(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <select name='idloaisanpham' class='form-select mb-3'>


                            @foreach($loaisp as $item)
                            <option value="{{$item->idloaisanpham}}" @if(old('idloaisanpham')==$item->idloaisanpham) selected @endif {{$sanpham->idloaisanpham == $item->idloaisanpham ? 'selected': '' }}>{{$item->tenloai}}</option>
                            @endforeach
                        </select>
                        <label for="floatingInput">Nhu cầu(*)</label>

                    </div>
                    <div class="form-floating mb-3">

                        <input type="file" name='img' class='form-control mt-3'>
                        <img id="img1" style="width:200px;margin:10px" src="{{asset('storage/img/'.$sanpham->img)}}" alt="">
                        <label for="floatingInput">Hình ảnh</label>
                        @error('img')
                        <span style="color: red;">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-floating mb-3">

                        <textarea style="height: 150px;" name="motasanpham" class='form-control'>{{old('motasanpham') ?? $sanpham->motasanpham}}</textarea>
                        <label for="floatingInput">Mô tả</label>
                        @error('motasanpham')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea style="height: 150px;" name="noidung" id="noidung1" class='form-control'>{{old('noidung') ?? $sanpham->noidung}}</textarea>
                        <script>
                            CKEDITOR.replace('noidung1', {
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

                        <input type="number" min="1" step="1" name='gia' value="{{old('gia') ?? $sanpham->gia}}" class='form-control mt-3' required>
                        <label for="floatingInput">Giá</label>
                        @error('gia')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">

                        <input type="number" min="1" step="1" name='soluong' value="{{old('soluong') ??$sanpham->soluong}}" class='form-control mt-3' required>
                        <label for="floatingInput">Số lượng</label>
                        @error('soluong')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">HOT</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hot" id="hot" value="1" @if($sanpham->hot==1)
                                {{"checked"}}
                                @endif>

                                <label class="form-check-label" for="gridRadios1">

                                    Có
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hot" id="hot" value="0" @if($sanpham->hot==0)
                                {{"checked"}}
                                @endif>
                                <label class="form-check-label" for="gridRadios2">
                                    Không
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-floating mb-3">

                        <select type="number" name='trangthai' class='form-select mt-3'>
                            <option value="0" <?php echo $sanpham->trangthai == 0 ? 'selected' : ''; ?>>Ẩn
                            </option>
                            <option value="1" <?php echo $sanpham->trangthai == 1 ? 'selected' : ''; ?>>Hiện</option>
                        </select>
                        <label for="floatingInput">Trạng thái</label>

                    </div>




                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Sửa">

                        <a href="/admin/product" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop