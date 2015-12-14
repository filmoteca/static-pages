@extends(Config::get('filmoteca/static-pages::admin-layout'))

@section('content')

    {{ $pages->links() }}

    <table class="table table-condensed table-bordered">
        <thead>
            @include('filmoteca/static-pages::static-pages.partials.table-titles')
        </thead>
        <tbody>
        @foreach ($pages as $index => $page)
            <tr class="{{ $index % 2 === 0? 'active': '' }}">
                <td>{{ $page->id }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->status }}</td>
                <td>{{ $page->created_at }}</td>
                <td>{{ $page->updated_at }}</td>
                <td>
                    {{ Form::open(['action' => ['Filmoteca\StaticPages\StaticPagesController@destroy', $page->id], 'method'=> 'DELETE']) }}
                        <button class="btn btn-danger" type="submit">@lang('filmoteca/static-pages::general.delete')</button>
                    {{ Form::close() }}

                    <a class="btn btn-info" href="{{ URL::action('Filmoteca\StaticPages\StaticPagesController@edit', ['id' => $page->id]) }}">
                        @lang('filmoteca/static-pages::general.edit')
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            @include('filmoteca/static-pages::static-pages.partials.table-titles')
        </tfoot>
    </table>

    {{ $pages->links() }}

@endsection
