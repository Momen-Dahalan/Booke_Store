@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center font-weight-bold">
                    تصنيفات الكتب
                </div>

                <div class="card-body">
                    <!-- فورم البحث -->

                    <form action="{{ route('search') }}" method="GET">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-sm-8 col-md-6 mb-2">
                                <input type="text" class="form-control" name="term" id="term" placeholder="ابحث هنا...">
                            </div>
                            <div class="col-12 col-sm-auto mb-2">
                                <button type="submit" class="btn btn-secondary w-100">ابحث</button>
                            </div>
                        </div>
                    </form>
                    <hr>



                    <!-- العنوان -->
                    <h3 class="mb-4 text-center text-primary">{{$title}}</h3>

                    <!-- عرض التصنيفات -->
                    @if ($categories->count())
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-md-6 mb-4">
                                    <a href="{{ route('gallery.categories.show', $category) }}" class="text-decoration-none">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-dark">{{ $category->name }}</h5>
                                                <p class="card-text text-muted">عدد الكتب: <strong>{{ $category->books->count() }}</strong></p>
                                            </div>
                                            <div class="card-footer bg-transparent text-center">
                                                <span class="badge badge-primary">عرض الكتب</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            لا توجد تصنيفات متاحة.
                        </div>    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
