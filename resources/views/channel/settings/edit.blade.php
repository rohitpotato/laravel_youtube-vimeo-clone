@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Channel Settings</div>

                <div class="panel-body">
                <form action="{{ route('channel.update', $channel) }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>

                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ? old('name') : $channel->name }}">

                        @if ($errors->has('name'))

                        <div class="help-block">

                            {{ $errors->first('name') }}

                        </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                        <label for="name">Unique Url</label>

                        <div class="input-group">
                            <div class="input-group-addon">http://localhost/channel/</div>

                            <input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                        </div>
                        @if ($errors->has('slug'))

                        <div class="help-block">

                            {{ $errors->first('slug') }}

                        </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">description</label>

                        <textarea name="description" class="form-control" id="description"> {{ old('description') ? old('description') : $channel->description }} </textarea>

                        @if ($errors->has('description'))

                        <div class="help-block">

                            {{ $errors->first('description') }}

                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image">Channel Image</label>

                       <input type="file" name="image">

                    </div>

                    <button class="btn btn-default" type="submit">Update</button>

                    {{ csrf_field() }}
                    {{ method_field('put') }}

                </form>

            </div>

            </div>
        </div>
    </div>
</div>
@endsection
