@extends('filmoteca/static-pages::layouts.default')

@section('content')

    @if ($page === null)
        {{ Form::open(['action' => 'Filmoteca\StaticPages\StaticPagesController@store']) }}
    @else
        {{ Form::model($page, ['action' => 'Filmoteca\StaticPages\StaticPagesController@store']) }}

        {{ Form::hidden('id', $page->id) }}
    @endif

    <div class="form-group">
        <label for="title" class="control-label">{{ Lang::get('filmoteca/static-pages::general.title') }}</label>
        {{ Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) }}
    </div>

    <div class="form-group">
        <label for="slug" class="control-label">Slug</label>
        {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
    </div>

    <div class="form-group">
        <label for="content" class="control-label">{{ Lang::get('filmoteca/static-pages::general.content') }}</label>
        {{ Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content']) }}
    </div>

    <div class="form-group">
        <label for="status" class="control-label">{{ Lang::get('filmoteca/static-pages::general.status') }}</label>
        {{ Form::select('status', $status, $defaultStatus, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        <label for="parent_page_id" class="control-label">{{ Lang::get('filmoteca/static-pages::general.page-parent') }}</label>

        {{ Form::selectParentPage('parent_page_id', $pages, $page, ['class' => 'form-control']) }}
    </div>

    @if ($page === null)
        {{ Form::submit(Lang::get('filmoteca/static-pages::general.create'), ['class' => 'btn btn-success']) }}
    @else
        {{ Form::submit(Lang::get('filmoteca/static-pages::general.update'), ['class' => 'btn btn-success']) }}
    @endif

    {{ Form::close() }}
@endsection