@extends('partials.master')

@section('title', 'USER')

@section('custom_styles')

@endsection

@section('custom_scripts')
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
                                    User
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success" onclick="createData()">
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Dibuat Pada</th>
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
<!-- modal static -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title text-uppercase " id="modalDataLabel">Tambah Data</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="row">
                   <div class="form-group col-12">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <input type="hidden" readonly id="userId">
                   </div>
                   <div class="form-group col-12">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                   </div>
                   <div class="form-group col-6">
                       <button class="btn btn-success btn-sm btn-block" id="generateUsername" onclick="generateUsername()"><i class="fa fa-refresh"></i> Generate Username</button>
                   </div>
                   <div class="form-group col-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" id="email">
                   </div>
                   <div class="form-group col-6">
                        <label for="">Role</label>
                        <select class="form-control" name="role_id" id="role_id">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                   </div>
                   <div class="form-group col-12">
                       <div class="alert alert-info">
                           <p>
                               User yang baru dibuat akan memiliki password default sesuai <b>USERNAME</b>
                           </p>
                       </div>
                   </div>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-success" hidden id="resetPassword" onclick="resetPassword()" ><i class="fa fa-refresh"></i> Reset Password</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
               <button type="button" class="btn btn-primary" id="submitData" data-action="add" onclick="submitData(this)">Simpan</button>
           </div>
       </div>
   </div>
</div>
<!-- end modal static -->
@endsection

@section('javascript')
<script>
    const generateUsername = () => {
        document.getElementById("username").value = Math.random().toString(36).substring(7)
    }

    const createData = () => {
        $('#submitData').attr('data-action', 'add')
        $('#modalData').modal('toggle')
        $('#generateUsername').attr('hidden', false)
        $('#username').attr('readonly', false)

        $('#resetPassword').attr('hidden', true)

        $('#userId').val(null)
    }

    const updateData = (e) => {
        const data  = $(e).data()
        console.table(data)

        $('#submitData').attr('data-action', 'update')
        $('#modalData').modal('toggle')
        $('#generateUsername').attr('hidden', true)

        $('#userId').val(data.id)
        $('#username').attr('readonly', true).val(data.username)
        $('#email').val(data.email)
        $('#role_id').val(data.role).change()
        $('#name').val(data.name)

        $('#resetPassword').attr('hidden', false)
    }

    const deleteData = (e) => {
        const id = $(e).data('id')
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
                ajaxRequest(
                    'DELETE',
                    "{{route('user.destroy', 'userId')}}".replace("userId", id)
                ).then((result) => {
                    toastr.success('Berhasil Menghapus Data')
                    listData.ajax.reload()
                }).catch((err) => {
                    toastr.error('Gagal Menghapus Data')
                })
            }
        })
    }

    const submitData = (e) => {
        const action = $(e).attr('data-action')
        const name  = document.getElementById('name');
        const username  = document.getElementById('username');
        const email  = document.getElementById('email');
        const role_id  = document.getElementById('role_id');
        switch(action){
            case 'add':
                ajaxRequest(
                    'POST',
                    "{{route('user.store')}}",
                    {
                        name: name.value,
                        username: username.value,
                        email: email.value,
                        role_id: role_id.value,
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Menambahkan Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        name.value = ''
                        username.value = ''
                        email.value = ''
                    } else {
                        toastr.error('Gagal Menambahkan Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Menambahkan Data')
                })
            break;
            case 'update': 
                const userId = document.getElementById("userId").value
                ajaxRequest(
                    'PUT',
                    "{{route('user.update', 'userId')}}".replace("userId", userId),
                    {
                        name: name.value,
                        username: username.value,
                        email: email.value,
                        role_id: role_id.value,
                        reset_password: 0
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Memperbarui Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        name.value = ''
                        username.value = ''
                        email.value = ''
                    } else {
                        toastr.error('Gagal Memperbarui Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Memperbarui Data')
                })
            break;
        }
    }

    const resetPassword = () => {
        const id = $('#userId').val()
        const name  = document.getElementById('name');
        const username  = document.getElementById('username');
        const email  = document.getElementById('email');
        const role_id  = document.getElementById('role_id');
        Swal.fire({
            title: 'Apakah anda yakin akan reset password data ini?',
            text: "Password akan direset sesuai Username!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Lanjutkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                const userId = document.getElementById("userId").value
                ajaxRequest(
                    'PUT',
                    "{{route('user.update', 'userId')}}".replace("userId", userId),
                    {
                        name: name.value,
                        username: username.value,
                        email: email.value,
                        role_id: role_id.value,
                        reset_password: 1
                    }
                ).then((result) => {
                     if(result.status) {
                        toastr.success('Berhasil Memperbarui Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        name.value = ''
                        username.value = ''
                        email.value = ''
                    } else {
                        toastr.error('Gagal Memperbarui Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Memperbarui Data')
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
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'role.name', name: 'role_name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ]
    })
</script>
@endsection