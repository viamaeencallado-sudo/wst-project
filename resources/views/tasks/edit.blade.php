@extends('layouts.app')

@section('content')
<div class="form-heading"><a class="back-link" href="{{ route('tasks.index') }}">&larr; Back to tasks</a><p class="eyebrow">Edit task</p><h1>Refine the <em>next step.</em></h1><p class="intro">Keep the details useful and the momentum going.</p></div>
<form class="task-form" method="POST" action="{{ route('tasks.update', $task) }}">@csrf @method('PUT') @include('tasks.form')<div class="form-actions"><a class="button button-quiet" href="{{ route('tasks.index') }}">Cancel</a><button class="button button-primary" type="submit">Save changes <span>&rarr;</span></button></div></form>
@endsection