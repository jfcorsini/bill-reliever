@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/group" method="POST" class="smart-form">
		        {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Group name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Trip for the Arctic">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="A group to share all our expenses">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            @if (count($errors))
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li> 
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
