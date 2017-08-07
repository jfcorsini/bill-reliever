@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/payment" method="POST" class="smart-form">
		        {{ csrf_field() }}
                <div class="form-group">
                    <label for="member_id">Group</label>
                    <select type="text" class="form-control" id="member_id" name="member_id">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}"> {{ $member->group->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="number" step="any" class="form-control" id="value" name="value">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" maxlength="50" id="description" name="description" placeholder="Describe here what was this payment">
                </div>
                <hr/>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
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
