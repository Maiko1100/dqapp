@extends('layouts.app')
                         
@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>
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
            </div>
                
                    
        </div>
     </div>
</div>
@endsection
       


