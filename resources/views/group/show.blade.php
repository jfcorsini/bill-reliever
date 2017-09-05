@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $group->name }}</div>
                <div class="panel-body">
                    {{ $group->description }}

                    <hr>
                    @if ($userBelongsToGroup)
                        <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#group-users-modal">
                            Show / Hide users
                        </button>
                    @else
                        <article>
                            <p>You are not part of this group to see the users.</p>
                            @if (Auth::user())
                            <form method="POST" class="smart-form" action="/member" name="create-{{$group->id}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="group_id" value="{{$group->id}}">
                            </form>
                            <p>Click <a href="javascript:document.forms['create-{{$group->id}}'].submit()">here</a> to join</p>
                            @endif
                        </article>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All payments
                    @if (Auth::user())
                        <button id="create-new-payment" class="btn btn-info btn-xs pull-right">
                            Create new
                        </button>
                    @endif
                </div>
                @if ($userBelongsToGroup)
                    <div class="panel-body">
                        @if (is_null($payments))
                            <article>No payments to show :)</article>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="payment-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" value="all" id="payment-check-all"></th>
                                        <th>Creator</th>
                                        <th>Description</th>
                                        <th>Value</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            @if (!$payment->hasBill())
                                                <input type="checkbox" value="{{$payment->id}}" class="payment-checkbox">
                                            @endif
                                        </td>
                                        <td class="col-md-2">
                                            <a href="/user/{{$payment->creator()->id}}">
                                                {{ $payment->creator()->name }}
                                            </a>
                                        </td>
                                        <td class="col-md-8">{{ $payment->description }}</td>
                                        <td class="col-md-1"> R$ {{ (string) $payment->value }}</td>
                                        <td class="col-md-1">
                                            @if ($payment->hasBill())
                                                <button class="btn btn-primary btn-xs see-bill-button" data-bill-name="{{$payment->bill()->name}}" data-bill-id="{{$payment->bill()->id}}">See Bill <i class="fa fa-money"></i></button>
                                            @else
                                                <button class="btn btn-danger btn-xs delete-payment-button" data-token="{{ csrf_token() }}" data-payment-id="{{$payment->id}}">Delete <i class="fa fa-trash-o"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>
                                {{ $payments->links() }}
                            </div>
                        <button class="btn btn-primary btn-sm" data-title="Split" id="split-payments">
                             Split <i class="fa fa-group"></i>
                        </button>
                        @endif
                    </div>
                @else
                    <div class="panel-body">
                        <article>
                            <p>You are not part of this group to see the payments.</p>
                        </article>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($userBelongsToGroup)
    @include('group._users_modal')
    @include('group._split_payment_modal')
    @include('group._bill_modal')
@endif

@endsection
