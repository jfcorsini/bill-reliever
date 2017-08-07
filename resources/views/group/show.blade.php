@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
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
                                <table class="table">
                                <thead>
                                    <tr>
                                        <th>Creator</th>
                                        <th>Description</th>
                                        <th>Value</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->creator() }}</td>
                                        <td>{{ $payment->description }}</td>
                                        <td> R$ {{ (string) $payment->value }}</td>
                                        <td>
                                            <div class="dropup">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    <li><a href="#">Action</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                    <li><a href="#">Something else here</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="#">Separated link</a></li>
                                                </ul>                                                
                                            </div>
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $group->name }}</div>

                <div class="panel-body">
                    <article>
                        {{ $group->description }}
                    </article>
                </div>
            </div
            <hr><hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Users:</div>
                    <div class="panel-body">
                        @if ($userBelongsToGroup)
                            <article>
                            <ul>
                                @foreach($users as $user)
                                    <li>
                                        <a href="/user/{{$user->id}}">
                                            {{ $user->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </article>
                        </ul>
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
</div>
@endsection
