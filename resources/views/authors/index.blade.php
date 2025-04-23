@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center font-weight-bold">
                    المؤلفين  
                </div>

                <div class="card-body">
                    <!-- فورم البحث -->

                    <form action="{{ route('search_author') }}" method="GET">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <input type="text" class="col-3 mx-sm-3 mb-2" name="term" id="term">
                            <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">ابحث</button>
                        </div>
                    </form>
                    <hr>



                    <!-- العنوان -->
                    <h3 class="mb-4 text-center text-primary">{{$title}}</h3>

                    @if ($authors->count())
                        <div class="row">
                            @foreach ($authors as $author)
                                <div class="col-md-6 mb-4">
                                    <a href="{{ route('show_authors', $author) }}" class="text-decoration-none">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-dark">{{ $author->name }}</h5>
                                                <p class="card-text text-muted">عدد الكتب: <strong>{{ $author->books->count() }}</strong></p>
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
                            لا توجد مؤلفين متاحين.
                        </div>    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
