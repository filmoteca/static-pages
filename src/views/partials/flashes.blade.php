@foreach(['danger', 'success', 'warning'] as $type)
    @if (Session::has($type))
        <div class="alert alert-{{ $type }}">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session::get($type) }}
        </div>
    @endif
@endforeach

{{-- Validations --}}
@if (!$errors->isEmpty())
    <ul class="list-group">
        @foreach ($errors->all() as $error)
            <li class="list-group-item list-group-item-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif