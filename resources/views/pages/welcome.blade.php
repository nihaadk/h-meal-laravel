@extends('master')
@section('welcome')
<div class="container" style="min-height: 900px">
  <div class="section">
    <div class="row">
    	<div class="col s12 push-s5">
			<h2 class="deep-purple-text">Komentarji:</h2>
		</div>
        @if(count($tasks) == 0)
        <div class="col s12"> 
           <div class="card-panel">
               <h5 class="deep-purple-text center">Ni nobenga komentarija.</h5>
            </div>
        </div>
        @else
             <div class="col s12">
                <ul class="collapsible popout" data-collapsible="accordion">
                @foreach( $tasks as $task)
                    <li>
                      <div class="collapsible-header">
                      <i class="material-icons blue-grey-text lighten-4">comment</i>
                      <b class="deep-purple-text darken-3">{{ $task->author }}</b>
                      <a 
                        class="modal-trigger tooltipped secondary-content" 
                        data-position="right" 
                        data-delay="50" 
                        data-tooltip="Urejanje" 
                        href="#{{ 'editmodel'.$task->id }}"  
                        data-method="delete" 
                        style="bottom: 20px; margin-right: 5px;">
                        <i class="material-icons blue-grey-text lighten-4">edit</i>
                      </a>

                      <a 
                        class="modal-trigger tooltipped secondary-content"
                        data-position="left" 
                        data-delay="50" 
                        data-tooltip="Brisanje" 
                        href="#{{ 'deletemodel'.$task->id }}"  
                        data-method="delete" 
                        style="bottom: 20px; margin-right: 5px;">
                        <i class="material-icons blue-grey-text lighten-4">delete</i>
                      </a>
                      </div>
                      <div class="collapsible-body">
                        <p>{{ $task->description }}</p>
                        <p class="indigo-text lighten-2">{{ $task->created_at }}</p>
                      </div>
                    </li>
                  
               
                
                <!-- Delete Patient Model-->
                <div id="{{ 'deletemodel'.$task->id }}" class="modal">
                    <div class="modal-content">
                        <h5>Ali ste prepricani, da želite izbrisati ?</h5>
                    </div>
                    <div class="modal-footer">
                        <a 
                            href="#!" 
                            class=" modal-action modal-close waves-effect btn purple darken-3" 
                            style="margin-left: 10px;">
                            Prekliči
                        </a>
                        {!! FORM::open([
                            'method' => 'DELETE',
                            'url' => ['app/task/delete', $task->id]]) !!}
                        {!! FORM::submit('Briši', ['class' => 'btn red darken-3']) !!}
                    </div>
                    {!! FORM::close() !!}
                </div>

                <!-- Edit Patient Model-->
                <div id="{{ 'editmodel'.$task->id }}" class="modal modal-fixed-footer">

                    {!! FORM::model($task,[
                        'method' => 'PUT',
                        'url' => ['app/task/update', $task->id]
                       ])
                    !!}
                    <div class="modal-content">
                        <div class="input-field col 12">
                            {!! FORM::textarea('description',null,['class' => 'materialize-textarea', 'size' => '100x40']) !!}
                            {!! FORM::label('description', 'Komentar:') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>

                        {!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
                    </div>
                    {!! FORM::close() !!}
                </div>

            @endforeach
            </ul>
                </div>
        @endif
    </div>

    <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large purple darken-4">
      <i class="large material-icons">menu</i>
    </a>
    <ul>
        <li>
            <a href="#modal_filter" 
            class="btn-floating btn-large tooltipped waves-effect waves-light deep-purple accent-2 modal-trigger "
            data-position="left" 
            data-delay="50"
            data-tooltip="Filter">
            <i class="fa fa-filter" aria-hidden="true"></i>
            </a>  
        </li>
        <li>
            <a href="#modal_add" 
            class="btn-floating btn-large tooltipped waves-effect waves-light deep-purple accent-3 modal-trigger "
            data-position="left" 
            data-delay="50"
            data-tooltip="Novi komentar">
            <i class="material-icons">add</i>
            </a>  
        </li>
    </ul>
  </div>

    <!-- Add Task Model-->
    <div id="modal_add" class="modal modal-fixed-footer">
            {!! FORM::open(['url' => 'app/task/create']) !!}
        <div class="modal-content">
            <div class="input-field col 12">
                {!! FORM::select('user_id', $userList) !!}
                {!! FORM::label('user', 'Uporabnik:') !!}
            </div>
            <div class="input-field col 12">
                {!! FORM::textarea('description', null, ['class' => 'materialize-textarea', 'size' => '10x5']) !!}
                {!! FORM::label('description', 'Komentar:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>
            {!! FORM::submit('SHRANI', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>

    <!-- Filter Task Model-->
    <div id="modal_filter" class="modal modal-fixed-footer">
            {!! FORM::open(['url' => 'app/task/filter','class' => 'filterForm']) !!}
        <div class="modal-content">
            <div class="col 12">
                <center><h4 class="deep-purple-text">Potrebno je vse podatke vnesiti</h4></center>
                <br>
            </div>
            <div class="input-field col 12">
                {!! FORM::select('user_id', $userList) !!}
                {!! FORM::label('user', 'Uporabnik:') !!}
            </div>
            <div class="input-field col 12">
            {!! FORM::text('from_date', null ,array('class' => 'datepicker')) !!}
                {!! FORM::label('user', 'Od:') !!}
            </div>
            <div class="input-field col 12">
            {!! FORM::text('to_date', null ,array('class' => 'datepicker')) !!}
                {!! FORM::label('user', 'Do:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>
            {!! FORM::submit('Potrdi', ['class' => 'btn btn-primary green darken-3']) !!}
            <input type="button" onclick="reset()" value="Reset" class="btn btn-primary deep-purple" style="margin-right: 320px;">
        </div>
        {!! FORM::close() !!}
    </div>
    <script>
        function reset() {
           $('.filterForm')[0].reset();
        }
    </script>

  </div>
</div>
@stop