@extends('filmoteca/static-pages::layouts.default')

@section('content')

    @if ($menu === null)
        {{ Form::open(['action' => 'Filmoteca\StaticPages\MenusController@store']) }}
    @else
        {{ Form::model($menu, ['action' => 'Filmoteca\StaticPages\MenusController@update']) }}
    @endif

    <div class="row">
        <div class="col-sm-4">
            <div class="panel-group well" role="tablist" id="available-items">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <a role="button" data-toggle="collapse" data-parent="#available-items" href="#pages">
                            {{ Lang::get('filmoteca/static-pages::general.pages') }}
                        </a>
                    </div>
                    <div id="pages" class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            <button class="add-pages">
                                {{ Lang::get('filmoteca/static-pages::menus.add-selected-pages') }}
                            </button>
                            {{ Form::staticPagesTree($pages) }}
                            <button class="add-pages">
                                {{ Lang::get('filmoteca/static-pages::menus.add-selected-pages') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <a role="button" data-toggle="collapse" data-parent="#available-items" href="#links">
                            {{ Lang::get('filmoteca/static-pages::general.links') }}
                        </a>
                    </div>
                    <div id="links" class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            Links
                        </div>
                    </div>
                </div>
                </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="form-group">
                        <label for="name" class="control-label">Menu name</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <input type="submit" value="{{ Lang::get('filmoteca/static-pages::general.create') }}">
                    </div>
                </div>
                <div class="panel-body">
                    <h2>{{ Lang::get('filmoteca/static-pages::menus.menu-structure') }}</h2>
                </div>
                <div class="panel-footer">
                    <input type="submit" value="{{ Lang::get('filmoteca/static-pages::general.create') }}">
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
@stop