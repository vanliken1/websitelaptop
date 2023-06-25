@extends('admin/layouts/masteradmin')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">

                <h6 class="mb-4">Thêm chi tiết khuyến mãi</h6>
                <div>
                    <div class="mb-2">
                        <label class="form-label">Tìm kiếm sản phẩm</label>
                        <input type="text" class="locten" name="keyword" id="keyword-input" required>
                        <input type="hidden" class="form-control" name="idkhuyenmai" value="{{ $id }}">



                    </div>

                </div>
                <form action="/admin/khuyenmai/them" method="POST" id="khuyenmai-form">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="idkhuyenmai" value="{{$id}}" readonly>
                        <label for="floatingInput">Mã</label>

                    </div>
                    <div class="form-floating mb-3">

                        <input type="number" min="1" step="1" name='phantramkhuyenmai' id="phantramkhuyenmai" class='form-control mt-3' required>
                        <label for="floatingInput">Phần trăm khuyến mãi</label>
                        @error('phantramkhuyenmai')
                        <span style="color: red;">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3">Sản phẩm</label>

                    </div>
                    <div id="dssp" class="row"></div>





                
                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Thêm">

                        <a href="/admin/khuyenmai" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>

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
        document.getElementById('khuyenmai-form').addEventListener('submit', function(event) {
            const dsspField = document.getElementById('dssp');
            if (dsspField.childElementCount === 0) {
                event.preventDefault();
                alert('Vui lòng chọn ít nhất một sản phẩm.');
            }
        });
        $('#keyword-input').on('input', function() {
            var locten = $(this).val();
            var idkhuyenmai = $('input[name="idkhuyenmai"]').val();
            // alert(locten);
            $.ajax({
                url: '/admin/product/lockm',
                type: 'GET',
                data: {
                    keyword: locten,
                    id: idkhuyenmai
                },
                dataType: 'json',
                success: function(response) {
                    // Xử lý dữ liệu trả về và hiển thị kết quả
                    var resultsContainer = $('#dssp');


                    var t = '';
                    if (locten === '') {
                        resultsContainer.empty(); // Xóa kết quả hiện tại
                        return; // Thoát khỏi hàm success
                    }

                    if (response.length > 0) {
                        $.each(response, function(index, item) {
                            // // Tạo các phần tử HTML để hiển thị kết quả tìm kiếm
                            // var checkbox = $('<input>').addClass('form-check-input').attr({
                            //     type: 'checkbox',
                            //     name: 'sanpham[]',
                            //     value: item.idsanpham
                            // });
                            // var label = $('<label>').addClass('form-check-label').text(item.tensanpham);
                            // var div = $('<div>').addClass('form-check col-md-3').append(checkbox, label);


                            // if ($.inArray(item.idsanpham, existingValues) === -1) {
                            //     resultsContainer.append(div);
                            // }


                            t += `  <div class="form-check col-md-4">
                                <input class="form-check-input" type="checkbox" name="sanpham[]" value="${item.idsanpham}" >
                                <label class="form-check-label" >
                                    ${item.tensanpham}
                                </label>
                            </div>`
                        });
                        $('#dssp').html(t);

                    } else {
                        resultsContainer.text('Không có kết quả tìm kiếm.');
                    }

                },
            });



        });
    });
</script>
@stop