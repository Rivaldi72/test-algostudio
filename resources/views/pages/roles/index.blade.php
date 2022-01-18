@extends('partials.master')

@section('title', 'USER ROLE')

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
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1 text-uppercase">Brand Data</h2>
                        </div>
                    </div>
                    
                    <div class="col-md-12 m-t-20">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title text-uppercase">List Data Brands</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 m-b-20">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <button class="btn btn-primary" onclick="createData()">
                                                    Create Data 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive  m-b-20">
                                            <table class="table table-bordered table-striped table-active" id="list-datatables">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Roles</th>
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
                    <div class="col-md-12 m-t-20">
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
                   <div class="col-12">
                        <label for="">Nama Brand</label>
                        <input type="text" class="form-control" name="brand" id="brand">
                        <input type="hidden" readonly id="brandId">
                   </div>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <button type="button" class="btn btn-primary" id="submitData" data-action="add" onclick="submitData(this)">Confirm</button>
           </div>
       </div>
   </div>
</div>
<!-- end modal static -->
@endsection

@section('javascript')
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
        ]
    })

</script>
@endsection