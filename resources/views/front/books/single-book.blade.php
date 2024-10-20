@extends('front.main')

@section('title', 'All Books')

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="book-info" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="owl-carousel book-carousel pe-0">
                    @foreach ($book->images as $image)
                        <div class="book-image-holder d-flex justify-content-center align-items-center">
                            <img src="{{ asset($image->url) }}" alt="" srcset="">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-9 ps-4">
                <h2>{{ $book->title }}</h2>
                <hr>
                <p>
                    <i class="fa-solid fa-pen-nib"></i> {{ $book->author->name }}
                </p>
                <p>
                    <i class="fa-solid fa-message"></i> {{ $book->reviews->count() }} @lang('custom.books.reviews')
                </p>
                <p>
                    @for ($i = 0; $i < round($book->avg_review); $i++)
                        <i class="fa-solid fa-star text-wraning"></i>
                    @endfor
                    @for ($i = 0; $i < 5 - round($book->avg_review); $i++)
                        <i class="fa-regular fa-star"></i>
                    @endfor
                    ({{ $book->avg_review }})
                </p>
                @if($book->downloadable)
                    <a href="{{ $book->source }}" class="btn btn-success" target="_blank">@lang('custom.books.read')</a>
                @else
                    <a href="{{ $book->source }}" class="btn btn-primary" target="_blank">@lang('custom.books.download')</a>
                    <p>@lang('custom.books.no-download')</p>
                @endif
                <div class="add-review">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection