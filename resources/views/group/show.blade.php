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
                        @include('group._users_modal')
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
                        <input type="button" class="btn btn-info btn-xs pull-right" value="Create new" onclick="location.href = '/payment/create';">
                    @endif
                </div>
                @if ($userBelongsToGroup)
                    <div class="panel-body">
                        @if (is_null($payments))
                            <article>No payments to show :)</article>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped" id="payment-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" value="all"></th>
                                        <th>Creator</th>
                                        <th>Description</th>
                                        <th>Value</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td><input type="checkbox" name="payment[]" value="{{$payment->id}}"></td>
                                        <td class="col-md-2">{{ $payment->creator() }}</td>
                                        <td class="col-md-6">{{ $payment->description }}</td>
                                        <td class="col-md-2"> R$ {{ (string) $payment->value }}</td>
                                        <td class="col-md-2">
                                        {{-- To be implemented   --}}
                                            <button class="btn btn-primary btn-xs" data-title="Edit">Edit <i class="fa fa-pencil-square-o"></i></button>
                                            <button class="btn btn-danger btn-xs" data-title="Delete">Delete <i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
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
@endsection
