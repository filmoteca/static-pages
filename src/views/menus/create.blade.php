@extends('static-pages::layout.default')

@section('content')

    @include('static-pages::partials.menu-toolbar')

    @include('static-pages::partials.available-items-to-menu', ['enable' => false])

    {{ Form::open(['route' => 'filmoteca.static-pages.create']) }}

    <div class="form-group">
        <label for="name" class="control-label">Menu name</label>
        <input class="form-control" type="text" name="name">
    </div>

    {{ Form::close() }}
@stop