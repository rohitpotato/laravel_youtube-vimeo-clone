@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Videos From Your Subscription!</div>

                <div class="panel-body">
                    
                    @if(!$videos->count())

                        <p>You have no subscriptions at the moment</p>

                    @else
                        @foreach($videos as $video)
                            <div class="well">
                                
                                @include('video.partials._video_result', [

                                    'video' => $video
                                ])

                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
