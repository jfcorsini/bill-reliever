@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Groups</div>

                <div class="panel-body">
                    @foreach ($groups as $group)
                        <article>
                            <h4>
                            <a href="/group/{{ $group->id }}">
                                {{ $group->name }}
                            </a>
                            </h4>
                            <div class="body">{{ $group->description }}</div>
                        </article>

                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
