@extends('partials.master')
@section('title', 'TAMBAH PRODUCT')

@section('custom_styles')
<style>
    .ck-editor__editable {
        min-height: 300px;
    }

    
  
</style>
@endsection

@section('custom_scripts')
<script>
    var myEditor;
    var dataTable = []
    var productID = ''
    $(document).ready(function () {

        $('.select2').select2({
            minimumInputLength: 1,
            tags: [],
            placeholder: "Pilih Produk",
            ajax: {
                url: "{{route('product.index')}}",
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                }
            }
        });
    });

    const submitData = (e) => {
        let name = $('input[name=name]').val()
        let price = $('input[name=price]').val()
        let unit = $('input[name=unit]').val()
        let category = $("#category option:selected").val()
        let image = $('input[name=image]').val()
        let description = myEditor.getData()
        let err = false;

        if(name === '') {
            err = true;
            toastr.error('<div>Nama Produk Tidak Boleh Kosong!</div>')
        } 

        if(price === '') {
            err = true;
            toastr.error('<div>Harga Produk Tidak Boleh Kosong!</div>')
        }

        if(unit === '') {
            err = true;
            toastr.error('<div>Stock Produk Tidak Boleh Kosong!</div>')
        }

        if(typeof category === 'undefined') {
            err = true;
            toastr.error('<div>Kategori Produk Tidak Boleh Kosong!</div>')
        }

        if(image === ''){
            err = true;
            toastr.error('<div>Gambar Produk Tidak Boleh Kosong!</div>')
        }

        if(description === ''){
            err = true;
            toastr.error('<div>Keterangan Produk Tidak Boleh Kosong!</div>')
        }

        if(!err) {
            image = $('input[name=image]').prop('files')[0];
            var form_data = new FormData();                  
            form_data.append('image', image);
            form_data.append('name', name);
            form_data.append('price', price.replace(/[^\d.-]/g, ''));
            form_data.append('unit', unit.replace(/[^\d.-]/g, ''));
            form_data.append('category_id', category);
            form_data.append('description', description);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('.progress-bar').text('0%');
            $('.progress-bar').width('0%');
            $.ajax({
                url: '{{route("product.store")}}', // <-- point to server-side PHP script 
                dataType: 'JSON',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'POST',
                beforeSend: () => {
                    var percentage = '0';
                },
                xhr: () => {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(e) {
						if (e.lengthComputable) {
							var uploadpercent = e.loaded / e.total; 
							uploadpercent = (uploadpercent * 100); //optional Math.round(uploadpercent * 100)
							$('.progress-bar').text(uploadpercent + '%');
							$('.progress-bar').width(uploadpercent + '%');
							if (uploadpercent == 100) {
								$('.progress-bar').text('Completed');
							}
						}
					}, false);
					
					return xhr;
				},
                success: (res) => {
                    console.log(res)
                    if(res.status){
                        toastr.success("Berhasil Menambahkan Data")
                        setTimeout(() => { 
                            window.location.href = "{{route('product.index')}}"
                         }, 1000);
                        
                    }else {
                        toastr.error("Gagal Menambahkan Data")
                    }
                },
                error: (xhr, status, error) => {
                    toastr.error(`Gagal: ${xhr.responseText}`)
                    
                }
            });
        }
    }

    const addProduct = () => {
        $.ajax({
            type: "GET",
            url: "{{route('product.show', 'dataID')}}".replace('dataID', productID),
            dataType: "JSON",
            success: function (response) {
                dataTable.push(response)
            }
        });
    }

    $('.select2').on('change', function() {
      productID = $(".select2 option:selected").val();
    })

</script>
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-uppercase">
                                    Transaksi Penjualan
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Nama Customer</div>
                                        <input type="text" class="form-control" name="customer">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 form-group">
                                        <div class="label">Alamat</div>
                                        <textarea name="address" class="form-control" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Produk</div>
                                        <select name="category" id="category" class="form-control select2" ></select>
                                    </div>
                                    <div class="col-3 form-group">
                                        <div class="label">Jumlah Dibeli</div>
                                        <div class="input-group">
                                            <input type="numeric" class="form-control" name="quantity">
                                            <div class="input-group-append">
                                                <button class="input-group-text" onclick="addProduct()" id="basic-addon2">
                                                    Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <label for="">Detail Pemebelian</label>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Code</th>
                                                <th>Harga Perproduk</th>
                                                <th>Jumlah Pembelian</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" onclick="submitData(this)">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('modal')
@endsection
