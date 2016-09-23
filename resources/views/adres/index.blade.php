@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Zoeken</div>

                <div class="panel-body">
                
                	
                	
                {!! Form::open(['url' => 'adres/search']) !!}
                	
    			{!! Form::label('email', 'Adres')!!}

    			{!! Form::text('postcode'); !!}
    			{!! Form::text('huisnummer'); !!}
    			
    				{!! Form::submit('Click Me!') !!}

					{!! Form::close() !!}

					@if ( isset($adressen) )
<div>
  {!! Form::open(['url' => 'adres/brief']) !!}
  
  {{ Form::date('datum', \Carbon\Carbon::now()) }}

	<div class="row">
<div class="col-md-4">
<label class="radio-inline">
  <input type="radio" name="afspraak"  value="inmeten" required> Inmeten
</label>
<label class="radio-inline">
  <input type="radio" name="afspraak" value="zetten" required> Zetten
</label>
  </div>
	</div>
<div class="row">
<div class="col-md-4">
<label class="radio-inline">
  <input type="radio" name="tijd" value="ochtend"required> Ochtend
</label>
<label class="radio-inline">
  <input type="radio" name="tijd" value="middag"required> Middag
</label>
  </div>
	</div>	
  </div>

<div class="col-md-6">
 <table class="table table-striped table-bordered table-hover table-condensed name="table" id="table">
    <tr>
	<th>Straat</th>
	<th>Postcode</th>
	<th>Woonplaats</th>
	<th>Naam</th>
	<th>Mail</th>
	<th>Brief</th>
  </tr>


@foreach ($adressen as $adres)

<tr name= 'id' value={{$adres['id']}}>
 <td>{{ $adres['straat'] }} {{ $adres['huisnummer'] }} {{ $adres['toevoeging'] }}</td>
  <td>{{ $adres['postcode'] }}</td>
  <td>{{ $adres['stad'] }}</td>
  <td>{{ $adres['naam'] }}</td>
  <td>
         <p><a class="btn btn-default" href="email/{{$adres['id']}}">Mail</a></p>
   </td>
  <td>
         {!! Form::submit('Brief') !!}
   </td>
 </tr>

					@endforeach
					  </table>
</div>
{!! Form::close() !!}

					@endif



					
					

		

					
					

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
