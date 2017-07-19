@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">All payments</div>
                @if ($userBelongsToGroup)
                    <div class="panel-body">
                        <article>
                            Nothing yet to show :)
                        </article>
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
                            </article>
                        @endif
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
