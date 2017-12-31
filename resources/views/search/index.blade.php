@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search for {{ Request::get('q') }}:</div>

                <div class="panel-body">
                     
                    @if($channels->count())
                        <h4>Channels</h4>

                        <div class="well">
                         @foreach($channels as $channel)
                            <div class="media">
                                    
                                <div class="media-left">
                                        
                                    <a href="{{ url('/channel') }}/{{ $channel->slug }}"><img src="{{ $channel->getImage() }}" class="media-object" width="50px" height="50px"></a>

                                </div>
                                <div class="media-body">
                                    
                                    <a href="{{ url('/channel') }}/{{ $channel->slug }}" class="media-heading">{{ $channel->name }}</a>

                                    Subscription count

                                </div>

                            </div>
                        @endforeach
                        </div>

                    @endif

                    @if (!$videos->count())
                        <p>No videos Found</p>
                    @else
                        @foreach($videos as $video)

                            @include('video.partials._video_result', [

                                'video' => $video

                            ])

                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
