@extends('layouts.master')

@section('content')
<div class="p-8">
    <a href="/login/github">Log in with GitHubb</a>

    @auth

    @endauth
</div>
@overwrite
