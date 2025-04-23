<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مكتبة سما</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('head')

    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #f0f0f0;
            overflow-x: hidden; /* منع الscroll الأفقي */
        }
        .navbar {
            height: 80px; /* تعيين ارتفاع الناف بار */
        }
        .navbar-nav .nav-item .dropdown-menu {
            right: 0;
            left: auto;
        }
        .profile-dropdown {
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .profile-dropdown img {
            border-radius: 50%;
            width: 25px; /* تقليل حجم الصورة */
            height: 25px;
            margin-right: 10px;
        }
        .profile-dropdown .profile-name {
            font-weight: bold;
        }
        .dropdown-menu {
            padding: 10px;
            width: 200px;
            white-space: nowrap;
        }
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
        /* تعديل حجم الخط */
        .navbar-nav .nav-link {
            font-size: 1.2rem; /* تعيين حجم خط أكبر */
        }


        .score{
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .score-wrap{
            display: inline-block;
            position: relative;
            height: 19px;
            
        }

        .score .stars-active{
            color: #FFCA00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;

        }

        .score .star-inactive{
            color: lightgray;
            position: absolute;
            top: 0;
            left: 0;
        }

        .rating{
            overflow: hidden;
            display: inline-block;
            position: relative;
            font-size: 20px;
        }

        .rating-star{
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }

        .rating-star:after{
            position: relative;
            font-family: "Font Awesome 5 Free";
            content: '\f005';
            color: lightgray;
        }

        .rating-star.checked ~ .rating-star:after,
        .rating-star.checked:after {
            content: '\f005';
            color: #FFCA00;
        }
        .rating:hover .rating-star:after {
            content: '\f005';
            color: lightgrey;
        }
        .rating-star:hover ~ .rating-star:after,
        .rating .rating-star:hover:after {
            content: '\f005';
            color: #FFCA00;
        }

        .btn-cart{
            background-color: #ffc107;
            color: #fff;
        }



    </style>
</head>
<body dir="rtl" style="text-align: right">

    <div class=""> <!-- وضع المحتوى داخل Container -->


      

        <nav class="navbar navbar-expand-lg bg-body-tertiary" style=" z-index: 12345;  >
            <div class="container-fluid">
              <a class="navbar-brand" href="{{route('gallery.index')}}" style="font-weight: bold">مكتبة سما</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent" style="background-color:white" >
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0" >

                    @auth
                    <li class="nav-item">
                        <a href="{{route('cart.view')}}" class="nav-link" style="font-weight: bold">
                            @if (Auth::user()->booksInCart()->count()>0)
                                <span class="badge bg-secondary">{{Auth::user()->booksInCart()->count()}}</span>    
                            @else
                                <span class="badge bg-secondary">0</span>    
                            @endif
                            العربة
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        
                    </li> 
                @endauth

                <li class="nav-item">
                    <a href="{{route('view_categories')}}" class="nav-link" style="font-weight: bold">التصنيفات
                        <i class="fas fa-list"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('view_publishers')}}" class="nav-link" style="font-weight: bold">الناشرون
                        <i class="fas fa-table"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('view_author')}}" class="nav-link" style="font-weight: bold">المؤلفون
                        <i class="fas fa-pen"></i>
                    </a>
                </li>

               @auth
                    <li class="nav-item">
                        <a href="{{route('myBooks')}}" class="nav-link" style="font-weight: bold">مشترياتي
                            <i class="fas fa-basket_shopping"></i>
                        </a>
                    </li>
               @endauth
               </ul>
            <!-- صورة الملف الشخصي والقائمة المنسدلة داخل النافبار -->
            <ul class="navbar-nav ms-auto" >
              @guest
                  <li class="nav-item">
                      <a href="{{ route('login') }}" class="nav-link">{{ __('تسجيل الدخول') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a href="{{ route('register') }}" class="nav-link">{{ __('إنشاء حساب') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown position-relative">
                      <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold">
                          {{ auth()->user()->name }}
                      </a>
                      <!-- إزالة mt-2 وتعيين top: 100% -->
                      <ul class="dropdown-menu dropdown-menu-end text-right" aria-labelledby="navbarDropdown" data-bs-popper="static" style="top: 100%;">
                          <li class="profile-dropdown d-flex align-items-center p-2">
                              <div>
                                  <div class="profile-name" style="font-weight: bold;">{{ auth()->user()->name }}</div>
                              </div>
                          </li>
                          <li><hr class="dropdown-divider"></li>
                          @can('isAdmin')
                              <li><a class="dropdown-item" href="{{ route('admin.index') }}">لوحة التحكم</a></li>
                          @endcan
                          <li><a class="dropdown-item" href="{{ route('profile.show') }}">الحساب الشخصي</a></li>
                          <li>
                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                              </form>
                          </li>
                      </ul>
                  </li>
              @endguest
            </ul>

          </div>

            </div>
          </nav>
    
        
          <main class="py-4">
            @yield('content')
          </main>

        </div>


    <script src="https://kit.fontawesome.com/1e00477b53.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
</body>
</html>
