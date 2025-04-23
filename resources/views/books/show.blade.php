@extends('layouts.main')

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

                        @auth
                            <div class="form texr-center mb-2">
                                <input type="hidden" id="bookId" value="{{$book->id}}">
                                <span class="text-muted mb-3"><input type="number" 
                                    id="quantity" name="quantity" 
                                    class="form-control d-inline mx-auto"
                                     value="1" min="1" max="{{$book->number_of_copies}}" style="width: 10%" required>
                                </span>
                                <button type="submit" class="btn btn-cart addCart me-2"><i class="fa fa-cart-pluse"></i>أضف للسلة</button>
                            </div>
                        @endauth
                        
                        <li class="list-group-item">
                            <strong>عنوان الكتاب:</strong>
                            <span class="text-primary">{{ $book->title }}</span>
                        </li>

                        <li class="list-group-item">
                            <strong> تقييم المستخدمين:</strong>
                                <span class="score">
                                    <div class="score-wrap">
                                        <span class="stars-active" style="width:{{$book->rate()*20}}% ">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>

                                        <span class="star-inactive">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </span>

                                <span>عدد المقيمين {{$book->ratings()->count()}} مستخدم</span>

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
                    </ul>

                    @auth
                        <h4 class="mb-3">قيم هذا الكتاب </h4>
                        @if ($findBook)
                            @if (auth()->user()->rated($book))
                            <div class="rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value >= $i ? 'checked' : '' }}" data-value="{{ $i }}"></span>
                                @endfor
                            </div>
                            @else

                            <div class="rating">
                                <span class="rating-star" data-value="5"></span>
                                <span class="rating-star" data-value="4"></span>
                                <span class="rating-star" data-value="3"></span>
                                <span class="rating-star" data-value="2"></span>
                                <span class="rating-star" data-value="1"></span>
                            </div>

                            @endif
                        @else 
                            <div class="alert alert-danger mt-4" role="alert">
                                يجب شراء هذا الكتاب حتى تسطيع تقييمه
                            </div>
                        @endif
                        
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('.rating-star').click(function() {
            
            var submitStars = $(this).attr('data-value');

            $.ajax({
                type: 'post',
                url: {{ $book->id }} + '/rate',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'value' : submitStars
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    toastr.error('حدث خطأ ما')
                },
            });
        });
    </script>


    <script>
    $(document).ready(function() {
        // الاستماع للنقر على زر الإضافة إلى السلة
        $('.addCart').on('click', function(event) {
            event.preventDefault();
            
            // الحصول على الـ CSRF token من الـ meta tag
            var token = $('meta[name="csrf-token"]').attr('content'); 
            var url = "{{ route('cart.add') }}";  // الرابط الصحيح لطلب Ajax
            var bookId = $('#bookId').val();  // الحصول على ID الكتاب
            var quantity = $('#quantity').val();  // الحصول على الكمية المطلوبة
    
            // طلب Ajax لإضافة الكتاب إلى السلة
            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    '_token': token,  // تمرير CSRF token في الطلب
                    'quantity': quantity,
                    'bookId': bookId
                },
                success: function(data) {
                    // تحديث عدد المنتجات في السلة
                    $('span.badge').text(data.num_of_product); 
                    toastr.success('تم إضافة الكتاب بنجاح');
                },
                error: function() {
                    toastr.error('حدث خطأ ما');
                }
            });
        });
    });
</script>


@endsection