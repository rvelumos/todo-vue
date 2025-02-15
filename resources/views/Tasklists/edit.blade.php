@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Bewerk Tasklist</h2>
        <form method="POST" action="{{ route('tasklists.update', $tasklist->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Naam van de lijst</label>
                <input type="text" name="name" value="{{ $tasklist->name }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('tasklists.index') }}" class="btn btn-secondary">Terug</a>
        </form>
    </div>
@endsection
