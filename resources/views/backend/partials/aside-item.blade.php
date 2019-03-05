<p class="menu-label">
    {{ $title }}
</p>

<ul class="menu-list">
    <li>
        <a @if(request()->routeIs("{$base}.index")) class="is-active" @endif href="{{ route("{$base}.index") }}">Index</a>
    </li>

    <li>
        <a @if(request()->routeIs("{$base}.create")) class="is-active" @endif href="{{ route("{$base}.create") }}">Create</a>
    </li>
</ul>