<!-- Bootstrap bundle JS -->
<script src="{{asset('dashboard/assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{asset('dashboard/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pace.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/chartjs/js/Chart.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
<!-- Vector map JavaScript -->
<script src="{{asset('dashboard/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!--app-->
<script src="{{asset('dashboard/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dashboard/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{asset('dashboard/assets/js/app.js')}}"></script>
<script src="{{asset('dashboard/assets/js/index.js')}}"></script>
<script src="{{asset('dashboard/assets/js/script.js?v=1.0')}}"></script>

@stack('js')
<script>
    $(document).ready(function() {
        $('.mDatatable').DataTable();
    });
    new PerfectScrollbar(".review-list")
    new PerfectScrollbar(".chat-talk")
</script>
