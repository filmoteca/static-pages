@extends(Config::get('filmoteca/static-pages::admin-layout'))

@section('content')

    {{ $menus->links() }}

    <table class="table table-condensed table-bordered">
        <thead>
        @include('filmoteca/static-pages::menus.partials.table-titles')
        </thead>
        <tbody>
        @foreach ($menus as $index => $menu)
            <tr class="{{ $index % 2 === 0? 'active': '' }}">
                <td>{{ $menu->id }}</td>
                <td>{{ $menu->name }}</td>
                <td>{{ $menu->created_at }}</td>
                <td>{{ $menu->updated_at }}</td>
                <td>
                    {{ Form::open(['action' => ['Filmoteca\StaticPages\MenusController@destroy', $menu->id], 'method'=> 'DELETE']) }}
                    <button class="btn btn-danger" type="submit">@lang('filmoteca/static-pages::general.delete')</button>
                    {{ Form::close() }}

                    <a class="btn btn-info" href="{{ URL::action('Filmoteca\StaticPages\MenusController@edit', ['id' => $menu->id]) }}">
                        @lang('filmoteca/static-pages::general.edit')
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        @include('filmoteca/static-pages::menus.partials.table-titles')
        </tfoot>
    </table>

    {{ $menus->links() }}

@endsection
