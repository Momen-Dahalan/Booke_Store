<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>لوحة الإدارة - مكتبة حسوب</title>

  <!-- Custom fonts for this template-->
  <link href="{!! asset('theams/vendor/fontawesome-free/css/all.min.css') !!}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- Custom styles for this template-->
  <link href="{!! asset('theams/css/sb-admin-2.min.css') !!}" rel="stylesheet">

  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

  <style>
      body {
        font-family: 'Cairo', sans-serif;
        background-color: #f0f0f0;
      }

      .sidebar.toggled .nav-item .nav-link {
          text-align: center !important;
      }
      .sidebar #sidebarToggle::after {
          content: '\f105';
      }
      .sidebar.toggled #sidebarToggle::after {
          content: '\f104';

      }
  </style>
  @yield('head')
</head>

<body id="page-top" dir="rtl" style="text-align: right">

  <!-- Page Wrapper -->
  <div id="wrapper">
    @include('theams.sidebar')


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        @include('theams.header')

        <!-- Begin Page Content -->
        <div class="container-fluid">
          @if(Session::has('flash_message'))
              <div class="p-3 mb-2 bg-success text-white rounded text-center">
                  {{ session('flash_message') }}
              </div>  
          @endif
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
          </div>

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
        @include('theams.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">هل أنت جاهز للمغادرة؟</h5>
        </div>
        <div class="modal-body">إذا كنت متأكد أنك تريد إنهاء الجلسة اضغط على زر خروج</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
          <a class="btn btn-primary" 
             href="{{ route('logout') }}"
             onclick="event.preventDefault();
             document.getElementById('logout-form').submit();"
          >خروج</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{!! asset('theams/vendor/jquery/jquery.min.js') !!}"></script>
  <script src="{!! asset('theams/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{!! asset('theams/vendor/jquery-easing/jquery.easing.min.js') !!}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{!! asset('theams/js/sb-admin-2.min.js') !!}"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  @yield('script')
</body>

</html>