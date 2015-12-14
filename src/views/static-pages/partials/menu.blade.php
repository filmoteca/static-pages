{{-- MenuEntryInterface $entry --}}
@foreach ($entries as $entry)
    <li class="menu-entry list-group-item">
        <div class="content">
            <p class="label">{{ $entry->label }}</p>
            <small class="url">{{ $entry->url }}</small>
            <p>
                <a class="text-danger delete" href="#"></a>
                <a class="text-info select" href="#"></a>
            </p>
        </div>
        <ul class="menu-entries list-group-item">
            @if ($entry->hasSubEntries())
                @include('filmoteca/static-pages::static-pages.partials.menu', ['entries' => $entry->getSubEntries()])
            @endif
        </ul>
    </li>
@endforeach
