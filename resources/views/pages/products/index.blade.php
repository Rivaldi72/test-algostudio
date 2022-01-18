@extends('partials.master')
@section('title', 'PRODUK')

@section('custom_styles')
<style>
</style>
@endsection

@section('custom_scripts')
<script>
    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
    }
        toastr.success("{{ session('message') }}");
    @endif

    const modal_content = document.getElementById('modal-content')
    
   

    const closeModal = () => {
        $('#modal-box').modal('toggle')
        
    }

    const confirmDelete = (e) => {
        let {value} = $(e).data()
        Swal.fire({
            title: 'Apakah anda yakin akan menghapus data ini?',
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Hapus Data!'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{route('product.destroy', 'IDProduct')}}".replace('IDProduct', value)
                ajaxRequest('DELETE', url).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Menghapus Data')
                        listData.ajax.reload()
                    } else {
                        toastr.error('Gagal Menghapus Data')
                    }
                }).catch((err) => {
                    toastr.error(`Error ${err.responseJSON.message}`)
                })
            }
        })
    }

  
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
            {data: 'name', name: 'name'},
            {data: 'unit', name: 'unit'},
            {data: 'price', name: 'price'},
            {data: 'category.name', name: 'category'},
            {data: 'createdAt', name: 'createdAt'},
            {data: 'updatedAt', name: 'updatedAt'},
            {data: 'action', name: 'action'},
           
        ]
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
                                    Produk
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{route('product.create')}}" class="btn btn-success" data-target="create" data-value="">
                                            Tambah Data
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Sisa Unit</th>
                                                <th>Harga</th>
                                                <th>Kategori</th>
                                                <th>Dibuat Pada</th>
                                                <th>Diperbarui Pada</th>
                                                <th>Aksi</th>
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
