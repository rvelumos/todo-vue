@extends('layouts.app')

@section('content')
    <div id="app">
        <task-list :tasklist-id="{{ $tasklist->id }}"></task-list>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
