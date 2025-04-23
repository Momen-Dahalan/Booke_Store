@extends('theams.default')

@section('heading')
    عرض تفاصيل الكتاب
@endsection

@section('head')
    <style>
        table{
        table-layout :fixed ;
        }

        table tr th {
            width: 30%;
        }


    </style>
@endsection


@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <!-- صورة الكتاب -->
                    <div class="text-center mb-4">
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }} Cover Image" class="img-fluid rounded shadow-sm" style="max-height: 500px;">
                    </div>

                    <!-- المعلومات -->
                    <ul class="list-group list-group-flush">

                        
                        <li class="list-group-item">
                            <strong>عنوان الكتاب:</strong>
                            <span class="text-primary">{{ $book->title }}</span>
                        </li>

                        @if ($book->isbn)
                        <li class="list-group-item">
                            <strong>ISBN:</strong>
                            <span class="text-muted">{{ $book->isbn }}</span>
                        </li>
                        @endif

                        @if ($book->authors()->count() > 0)
                        <li class="list-group-item">
                            <strong>المؤلفون:</strong>
                            <span class="text-muted">
                                @foreach ($book->authors as $author)
                                    {{ $loop->first ? '' : ' - ' }}{{ $author->name }}
                                @endforeach
                            </span>
                        </li>
                        @endif

                        @if ($book->publisher)
                        <li class="list-group-item">
                            <strong>الناشر:</strong>
                            <span class="text-muted">{{ $book->publisher->name }}</span>
                        </li>
                        @endif

                        @if ($book->description)
                        <li class="list-group-item">
                            <strong>وصف الكتاب:</strong>
                            <span class="text-muted">{{ $book->description }}</span>
                        </li>
                        @endif

                        <li class="list-group-item">
                            <strong>التصنيف:</strong>
                            <span class="text-muted">{{ $book->category->name }}</span>
                        </li>

                        <li class="list-group-item">
                            <strong>سنة النشر:</strong>
                            <span class="text-muted">{{ $book->publisher_year }}</span>
                        </li>

                        <li class="list-group-item">
                            <strong>عدد الصفحات:</strong>
                            <span class="text-muted">{{ $book->number_of_pages }}</span>
                        </li>

                        <li class="list-group-item">
                            <strong>السعر:</strong>
                            <span class="text-success">{{ $book->price }} $</span>
                        </li>

                        <li class="list-group-item">
                        
                                <a href="{{route('books.edit' , $book)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>تعديل</a>
                                <form action="{{route('books.destroy' , $book)}}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل انت متاكد ؟')"><i class="fa fa-trash"></i>حذف</button>
                                </form>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
