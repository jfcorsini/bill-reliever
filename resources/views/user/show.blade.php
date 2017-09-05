@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}</div>

                <div class="panel-body">
                    <article>
                        <div class="body">{{ $user->email }}</div>
                    </article>
                </div>
            </div>
            @if ($debtors)
                <div class="panel panel-default">
                    <div class="panel-heading">Debtors</div>
                    <div class="panel-body">
                            @include('bill._table', ['transactions' => $debtors])
                    </div>
                </div>
            @endif
            @if ($creditors)
                <div class="panel panel-default">
                    <div class="panel-heading">Creditors</div>
                    <div class="panel-body">
                            @include('bill._table', ['transactions' => $creditors])
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

                        