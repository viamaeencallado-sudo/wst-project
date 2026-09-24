@extends('layouts.app')

@section('content')
<div class="form-heading"><a class="back-link" href="{{ route('tasks.index') }}">&larr; Back to tasks</a><p class="eyebrow">New task</p><h1>Make space for <em>what matters.</em></h1><p class="intro">A clear next step is a good place to begin.</p></div>
<form class="task-form" method="POST" action="{{ route('tasks.store') }}">@csrf @include('tasks.form')<div class="form-actions"><a class="button button-quiet" href="{{ route('tasks.index') }}">Cancel</a><button class="button button-primary" type="submit">Add task <span>&rarr;</span></button></div></form>
@endsection