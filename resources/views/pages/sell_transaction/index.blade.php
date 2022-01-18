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
            {data: 'invoice', name: 'invoice'},
            {data: 'customer', name: 'customer'},
            {data: 'total', name: 'total'},
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
                                    Transaksi Penjualan
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{route('sell.transaction.create')}}" class="btn btn-success" data-target="create" data-value="">
                                            Tambah Data
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Invoice</th>
                                                <th>Pembeli</th>
                                                <th>Total</th>
                                                <th>Tanggal Transaksi</th>
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
