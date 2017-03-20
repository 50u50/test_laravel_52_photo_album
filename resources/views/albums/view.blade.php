@extends('layouts/app')
@section('title', 'Album list')
@section('content')

<h2>
    {{ $album->title }}
</h2>
<p>
    {{ $album->description }}
</p>

<div class="photo-gallery">
    @foreach($album->photos as $photo)
    <div class="album-photo">
        <dl>
            <dt>
                {{ $photo->title }}
            </dt>
            <dd>
                {{ $photo->description }}
            </dd>
        </dl>        
        <img 
            class="album-photo"
            width="100"
            src="{{ route('get_album_photos_image', [$photo->filename, $photo->original_name]) }}" 
            title="{{ $photo->title }}"
            alt="{{ $photo->description }}"/>
    </div>
    @endforeach
</div>


<ul>
    <li>
        <a href="{{ route('album.list') }}">
            Back to the album list
        </a>
    </li>
</ul>

@endsection