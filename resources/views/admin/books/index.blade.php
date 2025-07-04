@extends('theams.default')

@section('head')
<link href="{{ asset('theams/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('heading')
    عرض الكتب
@endsection

@section('content')
    <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> أضف كتابًا جديدًا</a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive"> <!-- ✅ إضافة هذا العنصر -->
                <table id="books-table" class="table table-striped table-bordered text-right" width="100%">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>الرقم التسلسلي</th>
                            <th>التصنيف</th>
                            <th>المؤلفون</th>
                            <th>الناشر</th>
                            <th>السعر</th>
                            <th>تعديل</th>
                            <th>حذف</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->category ? $book->category->name : '' }}</td>
                                <td>
                                    @if ($book->authors->count() > 0)
                                        @foreach ($book->authors as $author)
                                            {{ $loop->first ? '' : ',' }} {{ $author->name }}
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $book->publisher ? $book->publisher->name : '' }}</td>
                                <td>{{ $book->price }}$</td>
                                <td>
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-edit"></i> تعديل
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('books.destroy', $book) }}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- ✅ إغلاق الـ div -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('theams/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theams/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#books-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json',
                },
            });
        });
    </script>
@endsection
