@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>

            {{ $person->body }}

        </div>
    </div>
</div>
@endsection
