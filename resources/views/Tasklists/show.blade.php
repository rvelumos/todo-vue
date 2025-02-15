@extends('layouts.app')

@section('content')
    <div id="app">
        <task-lists :tasklist-id="{{ $tasklist->id }}"></task-lists>
    </div>
@endsection
