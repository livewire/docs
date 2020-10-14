@extends('layouts.screencasts')

@section('content')
    @livewire('screencast-player', ['screencast' => $screencast])
@endsection
