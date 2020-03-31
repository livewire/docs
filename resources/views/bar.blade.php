@extends('layouts.master')

@section('content')
<div class="p-8">
    Hey {{ auth()->user()->name }}!

    You are successfully authenticated.
</div>
@overwrite
