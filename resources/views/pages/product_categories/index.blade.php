@extends('partials.master')
@section('title', 'KATEGORI PRODUK')

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
    
    const openModal = (e) => {
        let {value, target} = $(e).data()
        switch (target) {
            case 'update':
                updateModal(value)
            break;
            case 'create': 
                createModal()
            break;
        }
        $('#modal-box').modal('toggle')
    }
    

    const closeModal = () => {
        $('#modal-box').modal('toggle')
        
    }

    const updateModal = (value) => {
        let url = "{{route('category.show', 'IDCategory')}}".replace('IDCategory', value)

        ajaxRequest('GET', url).then((result) => {
            modal_content.innerHTML = `
            <div class="modal-header">
                <h5 class="modal-title"><span id="title">Update Kategori</span></h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Nama Kategori</label>
                            <input type="text" name="name" value="${result.data.name}" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" onclick="updateData(this)" data-value="${result.data.id}">Perbarui</button>
            </div>
            `
        }).catch((err) => {
            toastr.error(`Error ${err.responseJSON.message}`)
        })
    }

    const createModal = () => {
        modal_content.innerHTML = `
        <div class="modal-header">
            <h5 class="modal-title"><span id="title">Tambah Kategori</span></h5>
            <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Kembali</button>
            <button type="button" class="btn btn-primary" onclick="addData()">Simpan</button>
        </div>
        `
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
                let url = "{{route('category.destroy', 'IDCategory')}}".replace('IDCategory', value)
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

    const addData = () => {
        let name = $('input[name=name]').val()

        if(name === ''){
            return notification(
                'error',
                'Kategori Tidak Boleh Kosong'
            )
        }

        ajaxRequest( 'POST', '', { name: name } ).then((result) => {
            if(result.status) {
                toastr.success('Berhasil Menambahkan Data')
                listData.ajax.reload()
                closeModal()
            } else {
                toastr.error('Gagal Menambahkan Data')
            }
        }).catch((err) => {
            toastr.error(`Error ${err.responseJSON.message}`)
        });
    }

    const updateData = (e) => {
        let {value} = $(e).data()
        let name = $('input[name=name]').val()
        let url = "{{route('category.update', 'IDCategory')}}".replace('IDCategory', value)

        ajaxRequest('PUT', url, { name: name } ).then((result) => {
            if(result.status) {
                toastr.success('Berhasil Update Data')
                listData.ajax.reload()
                closeModal()
            } else {
                toastr.error('Gagal Update Data')
            }
        }).catch((err) => {
            toastr.error(`Error ${err.responseJSON.message}`)
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
                                    Kategori Produk
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success" onclick="openModal(this)" data-target="create" data-value="">
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
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
