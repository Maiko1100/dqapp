@extends('layouts.app')
                         
@section('content')

    <script type="text/javascript" src="{{ asset('assets/js/adres/adres.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/adres/adres.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>

    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>
                @if ( isset($error) )
                    <div class="alert alert-success fade in alert-margin">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>{{$error}}</strong>
                    </div>
                @endif
                <div class="panel-body">
                    
                            {!! Form::open(
                                array(
                                'route' => 'upload.store',
                                'class' => 'form',
                                'novalidate' => 'novalidate',
                                'files' => true)) !!}
                                <div class="form-group">
                                {!! Form::label('Adressenbestand') !!}
                                {!! Form::file('file[]', array('class' => 'filestyle','multiple' => 'true')) !!}
                                </div>

                            <div class="form-group">
                            {!! Form::submit('Import adressen!') !!}
                            </div>
                            {!! Form::close() !!}

                            
                </div>
                <div style="padding: 5px">
                <a href="{{url("upload/cleardb")}}" class="btn btn-default" >Database Leegmaken</a>
                    </div>
            </div>
                
                    
        </div>
     </div>
</div>
@endsection
       


