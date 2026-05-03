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
<script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>

@stack('js')
<script>
    $(document).ready(function () {
        $('.mDatatable').DataTable();

        // Global SweetAlert Confirmation for Forms
        $(document).on('submit', 'form.confirm-submit', function(e) {
            e.preventDefault();
            let form = this;
            let message = $(this).data('message') || 'Are you sure you want to proceed?';
            let title = $(this).data('title') || 'Confirm Action';
            let type = $(this).data('type') || 'warning';
            let confirmText = $(this).data('confirm-text') || 'Yes, proceed!';

            Swal.fire({
                title: title,
                text: message,
                icon: type,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Global SweetAlert Confirmation for Links
        $(document).on('click', '.confirm-click', function(e) {
            e.preventDefault();
            let url = $(this).attr('href') || $(this).data('url');
            let message = $(this).data('message') || 'Are you sure you want to proceed?';
            let title = $(this).data('title') || 'Confirm Action';
            let type = $(this).data('type') || 'warning';
            let confirmText = $(this).data('confirm-text') || 'Yes, proceed!';

            Swal.fire({
                title: title,
                text: message,
                icon: type,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-4 me-2',
                    cancelButton: 'btn btn-danger px-4',
                    popup: 'rounded-4 border-0 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (url) {
                        window.location.href = url;
                    }
                }
            });
        });
    });

    new PerfectScrollbar(".review-list")
    new PerfectScrollbar(".chat-talk")
</script>