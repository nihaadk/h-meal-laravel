@extends('master')
@section('welcome')
<div class="container" style="min-height: 900px">
  <div class="section">
    <div class="row">
    	<div class="col s12 push-s5">
			<h2 class="deep-purple-text">Komentari</h2>
		</div>
        @if(count($tasks) == 0)
        <div class="col s12"> 
           <div class="card-panel">
               <h5 class="deep-purple-text center">Ni nobenga komentarja, vpišite nove komentar.</h5>
            </div>
        </div>
        @else
            @foreach( $tasks as $task)
                <div class="col s6">  
                    <div class="card white-grey">
                        <div class="card-content black-text">
                          <span class="card-title deep-purple-text">
                            {{ $task->author }}
                          </span>
                          <p>{{ $task->description }}</p>
                          <p class="blue-text text-darken-2" style="margin-top: 5%;">{{ $task->created_at }}</p>
                            <a 
                                class="btn-floating modal-trigger tooltipped right" 
                                data-position="top" 
                                data-delay="50" 
                                data-tooltip="Brisanje" 
                                href="#{{ 'deletemodel'.$task->id }}"  
                                data-method="delete" 
                                style="bottom: 20px; margin-right: 5px;">
                                <i class="material-icons red darken-1">delete</i>
                            </a>

                            <a 
                                class="btn-floating modal-trigger tooltipped right" 
                                data-position="top" 
                                data-delay="50" 
                                data-tooltip="Urejanje" 
                                href="#{{ 'editmodel'.$task->id }}"  
                                data-method="delete" 
                                style="bottom: 20px; margin-right: 5px;">
                                <i class="material-icons green darken-1">edit</i>
                            </a>
                        </div>
                    </div>
                </div>
                
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
                            Preklic
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
                        <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Preklic</a>

                        {!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
                    </div>
                    {!! FORM::close() !!}
                </div>

            @endforeach
        @endif
    </div>

    <!-- Add Task Button-->
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a href="#modal_add" 
            class="btn-floating btn-large tooltipped waves-effect waves-light purple darken-4 modal-trigger "
            data-position="left" 
            data-delay="50"
            data-tooltip="Dodaj novega Bolnika">
            <i class="material-icons">add</i>
        </a>      
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
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>
            {!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>

  </div>
</div>
@stop