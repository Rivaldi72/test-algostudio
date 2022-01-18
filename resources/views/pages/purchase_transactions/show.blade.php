@extends('partials.master')

@section('title', 'DATA PELANGGAN')

@section('custom_styles')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('custom_scripts')

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



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
                                    Detail Transaksi
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-2">Invoice</div>
                                    <div class="col-4">{{$purchase->invoice}}</div>
                                    <div class="col-5 text-right">
                                        {{date('D, d M Y', strtotime($purchase->created_at))}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">Suplier</div>
                                    <div class="col-4">{{$purchase->suplier->name}}</div>
                                    <div class="col-5 text-right">
                                        @if ($purchase->status === 'success')
                                            <span class="text-success text-uppercase">berhasil</span>
                                        @elseif ($purchase->status === 'hold')
                                            <span class="text-primary text-uppercase">menunggu</span>
                                        @else
                                            <span class="text-danger text-uppercase">dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Unit diajukan</th>
                                                <th>Harga per unit</th>
                                            </tr>
                                            @php
                                                $no =1;
                                            @endphp
                                            @foreach ($purchase->products as $product)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->quantity}}</td>
                                                <td>IDR {{number_format($product->price, 0, "", ".")}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12 text-right">
                                        <h3>Total IDR. {{number_format($purchase->total, 0, "", ".")}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row mb-2">
                                    @if ($purchase->status !== 'success')
                                        <button class="btn mx-2 btn-success" onclick="approve()">
                                            Approve
                                        </button>
                                    @endif
                                    <button class="btn mx-2 btn-danger disabled" onclick="invoice()">
                                        Cetak Invoice
                                    </button>
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


@section('javascript')
<script>
    const approve = () => {
        let url = "{{route('purchase.transaction.update', 'IDPurchase')}}".replace('IDPurchase', "{{$purchase->id}}")
        let data = {
            'status' : "success",
            'action' : 'approve'
        }
        ajaxRequest('PUT', url, data)
        .then((res) => {
            if(res.status) {
                toastr.success("berhasil memperbarui data")
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            }
        })
    }
</script>
@endsection