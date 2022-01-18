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
    $(document).ready(function () {

        $('.select2').select2({
            tags: [],
            placeholder: "Pilih Kategori Produk",
            ajax: {
                url: "{{route('category.index')}}",
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

        ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
                console.log( editor );
                myEditor = editor
        } )
        .catch( error => {
                console.error( error );
        } );


        $("#upload").click(function(){
			ambilId("progressBar").style.display = "block";
			var file = ambilId("file").files[0];
 
			if (file!="") {
				var formdata = new FormData();
				formdata.append("file", file);
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "upload.php");
				ajax.send(formdata);
			}
		});
    });

    const submitData = (e) => {
        let name = $('input[name=name]').val()
        let price = $('input[name=price]').val()
        let category = $("#category option:selected").val()
        let image = $('input[name=image]').val()
        let unit = $('input[name=unit]').val()
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

        if(typeof category === 'undefined') {
            err = true;
            toastr.error('<div>Kategori Produk Tidak Boleh Kosong!</div>')
        }


        if(description === ''){
            err = true;
            toastr.error('<div>Keterangan Produk Tidak Boleh Kosong!</div>')
        }

        if(!err) {
            image = $('input[name=image]').prop('files')[0];
            var form_data = new FormData();  
            
            if(typeof image !== 'undefined') {
                form_data.append('image', image);
            }
            form_data.append('name', name);
            form_data.append('price', price.replace(/[^\d.-]/g, ''));
            form_data.append('category_id', category);
            form_data.append('description', description);
            form_data.append('unit', unit);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('.progress-bar').text('0%');
            $('.progress-bar').width('0%');
            $.ajax({
                url: '{{route("update.product", "IDProduct")}}'.replace('IDProduct', '{{$product->id}}'), // <-- point to server-side PHP script 
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
                        toastr.success("Berhasil Memberbarui Data")
                        setTimeout(() => { 
                            window.location.href = "{{route('product.index')}}"
                        }, 1000);
                        
                    }else {
                        toastr.error("Gagal Memperbarui Data")
                    }
                },
                error: (xhr, status, error) => {
                    toastr.error(`Gagal: ${xhr.responseText}`)
                    
                }
            });
        }
    }

    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            preview.src = URL.createObjectURL(file)
        }
    }

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
                                    Produk
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Kategori Produk</div>
                                        <select name="category" id="category" class="form-control select2" >
                                            <option value="{{$product->category->id}}" selected>
                                                    {{$product->category->name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Nama Produk</div>
                                        <input type="text" class="form-control" value="{{$product->name}}" name="name">
                                    </div>
                                    <div class="col-3 form-group">
                                        <div class="label">Harga Produk (IDR)</div>
                                        <input type="number" class="form-control" value="{{$product->price}}" name="price">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 form-group">
                                        <label for="">Jumlah Unit</label>
                                        <input type="number" id="unit" name="unit" class="form-control" value="{{$product->unit}}">
                                        {{-- <span class="text-danger text-small" style="font-style: italic;">Unit otomatis terdata dari transaksi pembelian</span> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">upload Gambar Produk</div>
                                        <input type="file" name="image" class="form-control" accept="image/*" id="imgInp">
                                        <span class="text-danger text-small" style="font-style: italic;">Harap dikosongkan apabila ingin menggunakan gambar produk default</span>
                                    </div>
                                </div>
                                <div class="row" id="preview-row">
                                    <div class="col-12 form-group">
                                        <img id="preview" src="{{asset('upload/products/'.$product->image)}}" alt="Preview image" style="max-height: 300px" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                       <div class="progress">
                                            <div class="progress-bar" role="progressbar" ></div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="">Deskripsi Produk</label>
                                        <textarea name="description" class="form-control" id="editor" cols="30" rows="50">{{$product->description}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
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
