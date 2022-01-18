
<!-- Jquery JS-->
<script src={{{ URL::asset("template/vendor/jquery-3.2.1.min.js")}}}></script>
<!-- Bootstrap JS-->
<script src={{{ URL::asset("template/vendor/bootstrap-4.1/popper.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/bootstrap-4.1/bootstrap.min.js")}}}></script>
<!-- Vendor JS       -->
<script src={{{ URL::asset("template/vendor/slick/slick.min.js")}}}>
</script>
<script src={{{ URL::asset("template/vendor/wow/wow.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/animsition/animsition.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js")}}}>
</script>
<script src={{{ URL::asset("template/vendor/counter-up/jquery.waypoints.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/counter-up/jquery.counterup.min.js")}}}>
</script>
<script src={{{ URL::asset("template/vendor/circle-progress/circle-progress.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/perfect-scrollbar/perfect-scrollbar.js")}}}></script>
<script src={{{ URL::asset("template/vendor/chartjs/Chart.bundle.min.js")}}}></script>
<script src={{{ URL::asset("template/vendor/select2/select2.min.js")}}}>
</script>

<!-- Main JS-->
<script src={{{ URL::asset("template/js/main.js")}}}></script>

{{-- JAVASCRIPT UPDATE --}}
<script src={{{ URL::asset("assets/sweetalert2/dist/sweetalert2.min.js")}}}></script>
<script src={{{ URL::asset("assets/datatables/datatables.min.js")}}}></script>

<script src="{{{ URL::asset("assets/ckeditor/ckeditor.js")}}}"></script>
<script src="{{{ URL::asset("assets/toastr/toastr.js")}}}"></script>
<script src="{{{ URL::asset("assets/currency/simple.money.format.js")}}}"></script>

<script>
const notification = (icon= 'success', title= null, text= null, footer= null) =>{
    return Swal.fire({
        icon: icon,
        title: title,
        text: text,
        footer: footer
    })
} 

const loading = (title, text) => {
    Swal.fire({
        title: title,
        html: text,
        didOpen: () => {
            Swal.showLoading()
        }
    })
}

const logout = () => {
    Swal.fire({
        title: 'Apakah anda yakin akan logout ?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batalkan',
        confirmButtonText: 'Lanjutkan !'
    }).then((result) => {
        if (result.isConfirmed) {
            loading('Sedang Diproses...', '')
            window.location.href = `{{route('logout')}}`
        }
    })
}
const ajaxRequest = (_method, _url, _data = {}) => {
    let _token = "{{ csrf_token() }}"
    return $.ajax({
        type: _method,
        url: _url,
        data: {..._data, _token},
        dataType: "JSON",
    });
}

</script>
@yield('custom_scripts')