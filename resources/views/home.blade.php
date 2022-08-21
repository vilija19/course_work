@extends('layouts.main')
@section('content')
@if (session('message'))
<div style="color:green;">
    {!! session('message') !!}
</div>
@endif
@if (session('error'))
<div style="color:red;">
    {!! session('error') !!}
</div>
@endif
<div class="row mb-3 text-left">
    <div class="col-md-6 themed-grid-col">
        <h3>Общая информация о сервисе</h3>
    </div>
</div>  


@endsection