@extends(Config::get('filmoteca/static-pages::pages-layout'))

@section(Config::get('filmoteca/static-pages::sections.title'))
    {{ $page->getTitle() }}
@endsection

@section(Config::get('filmoteca/static-pages::sections.main-menu'))
    {{ Form::menu($mainMenu->getEntries()) }}
@endsection

@section(Config::get('filmoteca/static-pages::sections.sidebar'))
    {{ Form::siblingsPages($page) }}
@endsection

@section(Config::get('filmoteca/static-pages::sections.content'))
    {{ $page->getContent() }}
@endsection
