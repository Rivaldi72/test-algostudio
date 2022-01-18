@extends('partials.master')
@section('title', 'PRODUK')

@section('custom_styles')
<style>
</style>
@endsection

@section('custom_scripts')
<script>
   
    const listData = $('#list-datatables').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        fixedColumns:   {
            heightMatch: 'none'
        },
        ajax: {
            url: '',
            data: (req) => {
               
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'suplier.name', name: 'suplier'},
            {data: 'total', name: 'total'},
            {data: 'status', name: 'status'},
            {data: 'updatedAt', name: 'updatedAt'},
            {data: 'action', name: 'action'},
        ]
    })   


    $('#product-select2').select2({
        tags: [],
        placeholder: "Pilih Kategori Produk",
        ajax: {
            url: "{{route('data.products')}}",
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
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            }
        }
    }); 
    
    $('#suplier-select2').select2({
    
        tags: [],
        placeholder: "Pilih Suplier Penyedia",
        ajax: {
            url: "{{route('data.supliers')}}",
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
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                };
            }
        }
    }); 
    const addData = () => {
        let product = $("#product-select2 option:selected").val()
        let suplier = $("#suplier-select2 option:selected").val()
        let unit    = $("#unit").val()
        let url     = '{{route("purchase.transaction.store")}}'
        ajaxRequest('POST', 
        url,
        {
            product: product,
            suplier: suplier,
            unit: unit
        }).then((res)=> {
            if(res.status) {
                toastr.success('Data Ditambahkan')
                listData.ajax.reload()
            } else {
                toastr.error('Data gagal Ditambahkan')
            }
        })
    }


    const getProduct = (e) => {
        let data    = $("#product-select2 option:selected").val()
        console.log(data)
        let url     = '{{route("data.product", "IDProduct")}}'.replace('IDProduct', data)
        ajaxRequest('GET', url).then((res) => {
            $('#unit-last').val(res.unit)
            $('#price-default').val(res.price)
        })
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
                                    Tambah Transaksi
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label for="">Suplier</label>
                                        <select name="" class="form-control" id="suplier-select2"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label for="">Produk</label>
                                        <select name="" class="form-control" onchange="getProduct(this)" id="product-select2"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 form-group">
                                        <label for="">Jumlah Unit Tersisa</label>
                                        <input type="text" value="0" disabled id="unit-last" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="">Harga Produk</label>
                                        <input type="text" disabled id="price-default" class="form-control">
                                    </div>
                               
                                    <div class="col-lg-2 form-group">
                                        <label for="">Unit Yang Masuk</label>
                                        <input type="number" id="unit" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <button class="btn btn-block btn-success" onclick="addData()">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-uppercase">
                                    List Transaksi Pembelian Barang
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive pt-2">
                                    <table class="table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Suplier</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Diperbarui Pada</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                    </table>
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
