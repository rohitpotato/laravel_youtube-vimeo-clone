@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Trending Videos</div>

                <div class="panel-body">
                    
                    @if($videos)

                        @foreach($videos as $video)

                            <div class="well">
                                    
                                <div class="row">
                                    
                                    <div class="col-sm-3">

                                        <a href="{{ route('video.show', $video->uid) }}">
                                            
                                            <img src="{{ $video->thumbnail }}" class="img-responsive" alt="{{ $video->title }}">

                                        </a>

                                    </div>

                                    <div class="col-sm-9">
                                            
                                         <a href="{{ route('video.show', $video->uid) }}">{{ $video->title }}</a>
                                      <div class="row">

                                         <div class="col-sm-6">
                                            
                                            <p class="muted">{{  $video->description}}</p>
                                            <p class="muted">{{ $video->view_count }} Views</p>
                                        
                                         </div>   

                                         <div class="col-sm-6">
                                                
                                             <p>{{ ucfirst($video->visibility) }}</p>   

                                         </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @else
                        <p>You have no videos yet</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
