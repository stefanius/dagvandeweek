@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Overzicht historische personen</h1>

            <ul>
                @foreach($persons as $person)
                    <li>
                        <a href="{{ route('website.persons.show', [$person->slug]) }}">
                            {{ $person->first_name }} {{ $person->last_name }}
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
@endsection
