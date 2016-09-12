@extends('master')
@section('food-list')
<div class="container">

	<div class="row">
		<div class="col s8 push-s5">
			<h2 class="deep-purple-text">Hranilne snovi</h2>
		</div>
		<div class="col s4 pull-s7">
			<div class="input-field">
				{!! FORM::open(['method' => 'GET']) !!}
				{!! FORM::input('search','search', null, 
				   ['data-list' => $list,
              		'data-minchars' => '2',
              		'class' => 'awesomplete',
              		'placeholder' => 'Iskanje, vpiši kodo hrane']) 
              	!!}
				{!! FORM::close() !!}
			</div>
		</div>
	</div>

	<table class="centered bordered highlight">
		@if( count($Foods) == 0)
			<div class="card-panel red lighten-1 white-text"><h5 style="text-align: center;">Seznam je prazen !</h5></div>
		@else
			<thead>
			<tr>
				<th data-field="titel">Naziv</th>
				<th data-field="food_code">Koda</th>
				<th data-field="fat">Maš(g)</th>
				<th data-field="protein">Belj.(g)</th>
				<th data-field="calories">E(kCal)</th>
				<th data-field="carbohydrates">Og.H.(g)</th>
				<th data-field="food_type">Vrsta hrane</th>
				<th data-field="quantity">Količina</th>
			</tr>
			</thead>

			<tbody class="tbody-center">


			@foreach ( $Foods as $f)
				<tr>
					<td>{{ $f->title  }}</td>
					<td>{{ $f->food_code }}</td>
					<td>{{ $f->fat }}</td>
					<td >{{ $f->protein }}</td>
					<td>{{ $f->calories }}</td>
					<td>{{ $f->carbohydrates }}</td>
					<td>{{ $f->food_type }}</td>
					<td>{{ $f->quantity }}</td>

					<td class="td-icon">
						<a class="btn-floating modal-trigger" href="#{{ 'editmodel'.$f->id }}" >
							<i class="material-icons  green darken-3">mode_edit</i>
						</a>
					</td>
					<td class="td-icon">
						<a class="btn-floating modal-trigger" href="#{{ 'deletemodel'.$f->id }}"  data-method="delete">
							<i class="material-icons  red darken-1">delete</i>
						</a>
					</td>
					<td class="td-icon">

							<!-- /app/food/quantity/-->
						<a class="btn-floating modal-trigger" href="{{ URL::to('/app/food/quantity/'.$f->id) }}">

							<i class="material-icons blue darken-3">exposure_plus_1</i>
						</a>
					</td>
				</tr>

				<!-- Delete Food Model-->
				<div id="{{ 'deletemodel'.$f->id }}" class="modal bottom-sheet">
					<div class="modal-content">
						<h5>Ali ste prepričani, da želite izbrisati {{ $f->title }} ?</h5>
					</div>
					<div class="modal-footer">

						<a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Prekliči</a>

						{!! FORM::open([
                            'method' => 'DELETE',
                            'url' => ['app/food/delete', $f->id]]) !!}
						{!! FORM::submit('Briši', ['class' => 'btn danger-3 red']) !!}
					</div>
					{!! FORM::close() !!}
				</div>

				<!-- Edit Food Model-->
				<div id="{{ 'editmodel'.$f->id }}" class="modal modal-fixed-footer">
					{!! FORM::model($f,[
                        'method' => 'PUT',
                        'url' => ['app/food/update', $f->id]
                       ])
                    !!}
					<div class="modal-content">

							<!--
						<div class="input-field col 12">
			    			{!! FORM::select('food_type', array('Per os'=>'Per os','Intravenozno'=>'Intravenozno')) !!}
			    			{!! FORM::label('food_type', 'Vrsta hrane:') !!}
           				</div>
           					-->

						<div class="input-field col 12">
							{!! FORM::text('title', null) !!}
							{!! FORM::label('title', 'Naziv proizvoda:') !!}
						</div>
						<!--
						<div class="input-field col 12">
							{!! FORM::input('number', 'food_code', null, array('min'=>'0','max'=>'9999')) !!}
							{!! FORM::label('food_code', 'Koda proizvoda:') !!}
						</div>
						-->

						<div class="input-field col 12">
							{!! FORM::input('number', 'fat', null, array('min'=>'0','step'=>'0.01')) !!}
							{!! FORM::label('fat', 'Maščoba  (g):') !!}
						</div>

						<div class="input-field col 12">
							{!! FORM::input('number', 'protein', null, array('min'=>'0','step'=>'0.01')) !!}
							{!! FORM::label('protein', 'Beljankovine (g):') !!}
						</div>

						<div class="input-field col 12">
							{!! FORM::input('number', 'calories', null, array('min'=>'0','step'=>'0.01')) !!}
							{!! FORM::label('calories', 'Kalorije (kCal):') !!}
						</div>

						<div class="input-field col 12">
							{!! FORM::input('number', 'carbohydrates', null, array('min'=>'0','step'=>'0.01')) !!}
							{!! FORM::label('carbohydrates', 'Ogljikovi hidrati (g):') !!}
						</div>

						<div class="input-field col 12">
							{!! FORM::input('number', 'quantity', null, array('min'=>'0','max'=>'999')) !!}
							{!! FORM::label('quantity', 'Kolicina:') !!}
						</div>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>
						{!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
					</div>
					{!! FORM::close() !!}
				</div>
			@endforeach

			@endif
			</tbody>
	</table>

</div>

	<!-- Add Food Button-->
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    	<a href="#modal_add"
    		class="btn-floating btn-large tooltipped waves-effect waves-light purple darken-4 modal-trigger "
    		data-position="left"
    		data-delay="50"
    		data-tooltip="Dodaj novo hranilno snov">
    		<i class="material-icons">add</i>
    	</a>
    </div>

	<!-- Add Food Model-->
	<div id="modal_add" class="modal modal-fixed-footer">
			{!! FORM::open(['url' => 'app/food/add']) !!}
	    <div class="modal-content">

	    	<div class="input-field col 12">
			    {!! FORM::select('food_type', array('Per os'=>'Per os','Intravenozno'=>'Intravenozno'),null) !!}
			    {!! FORM::label('food_type', 'Vrsta hrane:') !!}
           	</div>

			<div class="input-field col 12">
				{!! FORM::text('title',null) !!}
				{!! FORM::label('title', 'Naziv proizvoda:') !!}
			</div>
		
			<div class="input-field col 12">
				{!! FORM::input('number', 'food_code', null, array('min'=>'000','max'=>'999')) !!}
				{!! FORM::label('food_code', 'Koda proizvoda:') !!}
			</div>
		
			<div class="input-field col 12">
				{!! FORM::input('number', 'calories', null, array('min'=>'0','max'=>'999','step'=>'1.0')) !!}
				{!! FORM::label('calories', 'Kalorije (kCal):') !!}
			</div>

			<div class="input-field col 12">
				{!! FORM::input('number', 'fat', null, array('min'=>'0','step'=>'0.1')) !!}
				{!! FORM::label('fat', 'Maščoba (g):') !!}
			</div>

			<div class="input-field col 12">
				{!! FORM::input('number', 'protein', null, array('min'=>'0','step'=>'0.1')) !!}
				{!! FORM::label('protein', 'Beljankovine (g):') !!}
			</div>

			<div class="input-field col 12">
				{!! FORM::input('number', 'carbohydrates', null, array('min'=>'0','step'=>'0.1')) !!}
				{!! FORM::label('carbohydrates', 'Ogljikovi hidrati  (g):') !!}
			</div>

			<div class="input-field col 12">
				{!! FORM::input('number', 'quantity', null, array('min'=>'0','max'=>'999')) !!}
				{!! FORM::label('quantity', 'Kolicina:') !!}
			</div>
		</div>
	    <div class="modal-footer">
	    	<a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>
	      	{!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
	    </div>
		{!! FORM::close() !!}
	</div>

@stop