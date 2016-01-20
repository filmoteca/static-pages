@extends(Config::get('filmoteca/static-pages::admin-layout'))

@section('title')
    @lang('filmoteca/static-pages::menus.title')
@endsection

@section('scripts')
    <script src="{{ asset('packages/filmoteca/static-pages/scripts/menu-creator.js') }}"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('packages/filmoteca/static-pages/stylesheets/menu-creator.css') }}">
@endsection

@section('content')

    {{-- With this style we archivement to do not hardcode text inside of the control to delete the a entry. --}}
    <style>
        .delete:after {
            content: '@lang('filmoteca/static-pages::general.delete')';
        }
        .select:before {
            content: '@lang('filmoteca/static-pages::menus.select-to-add-sub-entries')';
        }
    </style>

    <script>
        var baseUrl = "{{ '//' . Request::getHost() . '/' . Config::get('filmoteca/static-pages::pages-url-prefix') }}";
    </script>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel-group well" role="tablist" id="available-items">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <a role="button" data-toggle="collapse" data-parent="#available-items" href="#pages">
                            @lang('filmoteca/static-pages::general.pages')
                        </a>
                    </div>
                    <div id="pages" class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            <button class="add-pages">
                                @lang('filmoteca/static-pages::menus.add-selected-pages')
                            </button>
                            {{ Form::staticPagesTree($pagesTree) }}
                            <button class="add-pages">
                                @lang('filmoteca/static-pages::menus.add-selected-pages')
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <a role="button" data-toggle="collapse" data-parent="#available-items" href="#links">
                            @lang('filmoteca/static-pages::general.links')
                        </a>
                    </div>
                    <div id="links" class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="link-value" class="control-label">
                                    @lang('filmoteca/static-pages::general.link')
                                </label>
                                <input name="link" type="text" class="form-control" id="link-value"
                                        placeholder="http://www.google.com.mx">
                            </div>
                            <div class="form-group">
                                <label for="link-label" class="control-label">
                                    @lang('filmoteca/static-pages::general.label')
                                </label>
                                <input name="label" type="text" class="form-control" id="link-label">
                            </div>
                            <button class="add-link">
                                @lang('filmoteca/static-pages::menus.add-link')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <form name="menu-creation-form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="form-group">
                            <label for="name" class="control-label">@lang('filmoteca/static-pages::menus.menu-name')</label>
                            <input class="form-control" type="text" name="name" id="name"
                                   value="{{ $menu === null? '': $menu->name }}">
                        </div>
                    </div>
                    <div class="panel-body">
                        <h2>@lang('filmoteca/static-pages::menus.menu-structure')</h2>
                        <p>@lang('filmoteca/static-pages::menus.sort-instructions')</p>
                        <div class="menu-container menu-entry selected">
                            <a class="text-info select" href="#"></a>
                            <ul class="menu-entries list-group">
                                @if ($menu !== null)
                                    @include(
                                        'filmoteca/static-pages::menus.partials.menu',
                                        ['entries' => $menu->getEntries()]
                                    )
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer">
                        @if ($menu === null)
                            <input type="submit" value="@lang('filmoteca/static-pages::general.create')">
                        @else
                            <input type="submit" value="@lang('filmoteca/static-pages::general.update')">
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- The real form to send--}}
        @if ($menu === null)
            {{ Form::open(['action' => 'Filmoteca\StaticPages\MenusController@store', 'name' => 'menu-form']) }}
        @else
            {{ Form::model($menu, ['action' => 'Filmoteca\StaticPages\MenusController@store', 'name' => 'menu-form']) }}
            {{ Form::hidden('id', $menu->id) }}
        @endif

        {{ Form::close() }}
    </div>
@stop
