@extends('theams.default')

@section('heading')
  تعديل بيانات الكتاب
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-8">
        <div class="card-header text-">
                عدل بيانات الكتاب
        </div>
        <div class="card-body">

            

            <form action="{{ route('books.update' ,$book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">عنوان الكتاب</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" autocomplete="title" value="{{$book->title}}">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        
                    </div>
                </div>

                <div class="form-group row">
                    <label for="isbn" class="col-md-4 col-form-label text-md-right">الرقم التسلسلي</label>

                    <div class="col-md-6">
                        <input id="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" name="isbn" autocomplete="isbn" value="{{$book->isbn}}">

                        @error('isbn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cover_image" class="col-md-4 col-form-label text-md-right">صورة الكتاب</label>

                    <div class="col-md-6">
                        <input id="cover_image" accept="image/*" type="file" onchange="readCoverImage(this);" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image"  autocomplete="cover_image" >

                        @error('cover_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <img id="cover-image-thumb" class="img-fluid img-thumbnail" src="{{asset($book->cover_image)}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="category" class="col-md-4 col-form-label text-md-right">التصنيف</label>
                
                    <div class="col-md-6">
                        <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                            <option disabled {{$book->category == null ? 'selected' : ''}}>اختر تصنيفًا</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{$book->category == $category ? 'selected' : ''}}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                
                        @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="authors" class="col-md-4 col-form-label text-md-right">المؤلفون</label>

                    <div class="col-md-6">
                        <select id="authors" multiple class="form-control" name="authors[]">
                            <option disabled {{$book->authors->count()==0 ? 'selected' : ''}}>اختر المؤلفين</option>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $book->authors->contains($author->id) ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('authors')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="publisher" class="col-md-4 col-form-label text-md-right">الناشر</label>

                    <div class="col-md-6">
                        <select id="publisher" class="form-control @error('publisher') is-invalid @enderror" name="publisher" >
                            <option disabled {{$book->publisher==null ? 'selected' : ''}}>اختر ناشرًا</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{$book->publisher==$publisher ? 'selected' : ''}}>{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                        @error('publisher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">الوصف</label>

                    <div class="col-md-6">
                        <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description">{{$book->description}}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="publish_year" class="col-md-4 col-form-label text-md-right">سنة النشر</label>

                    <div class="col-md-6">
                        <input id="publish_year" type="number" class="form-control @error('publish_year') is-invalid @enderror" name="publish_year" value="{{$book->publisher_year}}" autocomplete="publish_year">

                        @error('publish_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="number_of_pages" class="col-md-4 col-form-label text-md-right">عدد الصفحات</label>

                    <div class="col-md-6">
                        <input id="number_of_pages" type="number" class="form-control @error('number_of_pages') is-invalid @enderror" name="number_of_pages" value="{{$book->number_of_pages}}" autocomplete="number_of_pages">

                        @error('number_of_pages')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="number_of_copies" class="col-md-4 col-form-label text-md-right">عدد النسخ</label>

                    <div class="col-md-6">
                        <input id="number_of_copies" type="number" class="form-control @error('number_of_copies') is-invalid @enderror" name="number_of_copies" value="{{ $book->number_of_copies }}" autocomplete="number_of_copies">

                        @error('number_of_copies')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">السعر</label>

                    <div class="col-md-6">
                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $book->price }}" autocomplete="price">

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">أضف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function readCoverImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('#cover-image-thumb')
                .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection