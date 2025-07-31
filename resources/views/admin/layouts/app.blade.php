<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.css')

<style>
    html,
    body {
        height: 100%;
        overflow: hidden; /* Prevent main body scroll */
    }

    #wrapper {
        height: 100%;
    }

    #content-wrapper {
        height: 100%;
        overflow-y: auto; /* Enable scrolling for main content */
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @php
            $sidebar = match (auth()->user()->role) {
                'admin' => 'admin.sidebar.admin',
                'psm' => 'admin.sidebar.psm',
                'kasubag' => 'admin.sidebar.kasubag',
                'operator' => 'admin.sidebar.operator',
                default => 'admin.sidebar.admin',
            };
        @endphp

        @include($sidebar)

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="{{ url('dashboard') }}">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.js')

    @yield('script')

    {{-- SweetAlert Notification --}}
    @include('sweetalert::alert')

</body>

</html>
