@extends(Config::get('filmoteca/static-pages::pages-layout'))

@section(Config::get('filmoteca/static-pages::sections.title'))
    {{ $page->getTitle() }}
@endsection

@section(Config::get('filmoteca/static-pages::sections.main-menu'))
    Main menu:
    <div class="well">
        {{ Form::menu($mainMenu->getEntries(), 'super-menu', 'entry', 'link', 'sub-menu') }}
    </div>
@endsection

@section(Config::get('filmoteca/static-pages::sections.sidebar'))
    Side bar menu (siblings pages):
    <div class="well">
        {{ Form::siblingsPages($page) }}
    </div>
@endsection

@section(Config::get('filmoteca/static-pages::sections.content'))
    Content:
    <div class="well">
        {{ $page->getContent() }}
    </div>
@endsection
