<!DOCTYPE html>
<html lang="en">

<!-- Header  -->
@include('partials.style')


<body class="animsition">
    <div class="page-wrapper">
        @include('partials.sidebar')

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            {{-- @include('partials.header') --}}

            @yield('content')
            <!-- END PAGE CONTAINER-->
        </div>
    </div>
    @yield('modal')
    <div class="modal fade" id="modal-box" role="dialog" aria-labelledby="staticModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>
    @include('partials.script')
</body>
@yield('javascript')
</html>
<!-- end document-->
