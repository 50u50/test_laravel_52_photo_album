@extends('layouts.app')
@section('title', $album->exists  ? 'Editing ' . $album->name : 'Create New Album')

@section('content')
{!! Form::model($album, [
'method' => $album->exists ? 'put' : 'post',
'route' => $album->exists ? ['album.update', $album->id] : ['album.store'],
'files' => $album->exists ? true : false,
]) !!}

<p>
    Total photos in album: {{ $album->photos->count() }}
</p>

<div>
    {!! Form::label('title') !!}
    {!! Form::text('title') !!}
</div>

<div>
    {!! Form::label('description') !!}
    {!! Form::textarea('description') !!}
</div>

<div>
    {!! Form::label('is_active') !!}
    {!! Form::checkbox('is_active') !!}
</div>

@if ($album->exists)
<h3>
    Add new photo to the album:
</h3>
<div>
    {!! Form::label('photo_title') !!}
    {!! Form::text('photo_title') !!}

    {!! Form::label('photo_description') !!}
    {!! Form::text('photo_description') !!}

    {!! Form::file('photo') !!}
</div>
@endif

{!! Form::submit($album->exists ? 'Save Album' : 'Create New Album') !!}

{!! Form::close() !!}

<ul>
    <li>
        <a href="{{ route('album.list') }}">
            Back to the album list
        </a>
    </li>
</ul>

@endsection
