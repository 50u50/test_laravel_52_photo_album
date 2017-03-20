@extends('layouts.app')
@section('title', 'Album list')
@section('content')
<table>
    <thead>
        <tr>
            <td>
                ID
            </td>
            <td>
                Title
            </td>
            <td>
                Description
            </td>
            <td>
                Count
            </td>
            <td>
                Actions
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($albums as $album)
        <tr>
            <td>
                {{ $album->id }}
            </td>
            <td>
                <a href="{{ route('album.view', $album->id) }}">
                    {{ $album->title }}
                </a>
            </td>
            <td>
                {{ str_limit($album->description, 25, '...') }}
            </td>
            <td>
                {{ $album->photos->count() }}
            </td>
            <td>
                <a href="{{ route('album.edit', $album->id) }}">
                    Edit
                </a>
                <a href="{{ route('album.delete', $album->id) }}">
                    Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<ul>
    <li>
        <a href="{{ route('album.add') }}">
            + Add new album
        </a>
    </li>
</ul>

@endsection