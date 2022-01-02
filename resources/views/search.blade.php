@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($results['Response'])
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach ($results['Search'] as $key => $result)
                        <div class="col">
                            <div class="card h-100">
                                <figure class="card-img-top ratio overflow-hidden" style="--bs-aspect-ratio: 133.3333%;">
                                    <img class="top-50 start-50 translate-middle h-auto" src="{{ $result->Poster }}" />
                                </figure>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $result->Title }}</h4>
                                    <p class="card-text text-muted">{{ $result->Year }}</p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="#" class="btn btn-primary btn-sm" role="button{{ $key }}" data-bs-toggle="button{{ $key }}" onClick="{{ Auth::user()->movies()->attach($result->imdbID) }}">Watched</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h2>No movies found</h2>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
