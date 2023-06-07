@extends('admin/layouts/masteradmin')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <form action="/admin/khuyenmai/them" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input for="exampleInputEmail1" class="form-label" name="idkhuyenmai" value="{{$id}}"></input>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div id="dssp" class="row"></div>



                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div>
                    <div class="mb-2">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" class="locten" name="keyword" id="keyword-input">
                        <input type="hidden" class="form-control" name="idkhuyenmai" value="{{ $id }}">


                    </div>

                </div>

                <!-- @foreach($sp as $item)
                            @if(!in_array($item->idsanpham, $existingValues))

                            <div class="form-check col-md-3">
                                <input class="form-check-input" type="checkbox" name="sanpham[]" value="{{$item->idsanpham}}" >
                                <label class="form-check-label" >
                                    {{$item->tensanpham}}
                                </label>
                            </div>

                            @endif
                            <option value="{{$item->idsanpham}}">{{$item->idsanpham}}</option>
                            @endforeach -->
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

                            // <div class="form-check col-md-3">
                            //     <input class="form-check-input" type="checkbox" name="sanpham[]" value="{{$item->idsanpham}}" >
                            //     <label class="form-check-label" >
                            //         {{$item->tensanpham}}
                            //     </label>
                            // </div>
                            t += `  <div class="form-check col-md-3">
                                <input class="form-check-input" type="checkbox" name="sanpham[]" value="${item.idsanpham}" >
                                <label class="form-check-label" >
                                    ${item.idsanpham}
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