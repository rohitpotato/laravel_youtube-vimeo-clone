@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Videos</div>

                <div class="panel-body">
                    
                    @if($videos->count())

                        @foreach($videos as $video)

                            <div class="well">
                                    
                                <div class="row">
                                    
                                    <div class="col-sm-3">

                                        <a href="{{ route('video.show', $video->uid) }}">
                                            
                                            <img src="{{ $video->getThumbnail() }}" class="img-responsive" alt="{{ $video->title }}">

                                        </a>

                                    </div>

                                    <div class="col-sm-9">
                                            
                                         <a href="{{ route('video.show', $video->uid) }}">{{ $video->title }}</a>
                                      <div class="row">

                                         <div class="col-sm-6">
                                            <p class="muted"> 
                                                @if(!$video->isProcessed())

                                                    <p>Processing, please wait...reload the page to keep checking!</p>

                                                @else

                                                    <span>{{ $video->created_at->diffForHumans() }}</span>

                                                @endif

                                            </p>
                                        @can('update', $video)
                                            <form action="{{ route('video.edit', $video->uid) }}" method="GET">

                                                {{ csrf_field() }}
                                                
                                               <button class="btn btn-xs btn-default" type="submit">Edit</button>

                                            </form> 

                                           <form action="{{ route('video.delete', $video->uid) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field("DELETE") }}
                                                <button class="btn btn-xs btn-danger">Delete</button>
                                                
                                            
                                            </form> 
                                        @endcan
                                        
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
