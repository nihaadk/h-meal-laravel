@extends('master')
@section('welcome')
<div class="container" style="min-height: 900px">
  <div class="section">
    <div class="row">
    	<div class="col s6">
			<h2 class="deep-purple-text">Comments:</h2>    
        </div>
        
        <div class="col s6">
            @if($patient_id != null)
               <div class="chip">
                   Bolnik: <b>{{ App\Patient::findOrFail($patient_id)->first_name  }} {{ App\Patient::findOrFail($patient_id)->last_name  }}</b>
                   <i class="close material-icons">close</i>
               </div> 
            @endif
            @if($author != null)
                <div class="chip">
                    Autor: <b>{{ $author->name }}</b>
                    <i class="close material-icons">close</i>
                </div> 
            @endif
            @if($dateFrom != null && $dateTo != null)
                <div class="chip">
                    Od: <b>{{ $dateFrom }}</b> Do: <b>{{ $dateTo }}</b>
                    <i class="close material-icons">close</i>
                </div> 
            @endif
        </div>

        @if(count($tasks) == 0)
        <div class="col s12"> 
           <div class="card-panel center">
               <h5 class="deep-purple-text">No comments.</h5>
               <a href="/app"><i class="large material-icons deep-purple-text">settings_backup_restore</i></a>
            </div>
        </div>
        @else
             <div class="col s12">
                <ul class="collapsible popout" data-collapsible="accordion">
                @foreach( $tasks as $task)
                    <li>
                      <div class="collapsible-header">
                      <i class="material-icons deep-purple-text lighten-5">comment</i>
                      <b class="black-text">
                      {{ $task->title }}
                      </b>  
                      <a 
                        class="modal-trigger tooltipped secondary-content" 
                        data-position="right" 
                        data-delay="50" 
                        data-tooltip="Edit" 
                        href="#{{ 'editmodel'.$task->id }}"  
                        data-method="edit" 
                        style="bottom: 20px; margin-right: 5px;">
                        <i class="material-icons deep-purple-text lighten-5">edit</i>
                      </a>

                      <a 
                        class="modal-trigger tooltipped secondary-content"
                        data-position="left" 
                        data-delay="50" 
                        data-tooltip="Delete" 
                        href="#{{ 'deletemodel'.$task->id }}"  
                        data-method="delete" 
                        style="bottom: 20px; margin-right: 5px;">
                        <i class="material-icons deep-purple-text lighten-5">delete</i>
                      </a>
                      </div>
                      <div class="collapsible-body">
                        <p>{{ $task->description }}</p>
                            <p  style="padding: 0; margin-top: 1px; margin-left: 1%;">
                                <b class="deep-purple-text darken-3">Date:</b> {{ $task->created_at->format('d.m.Y') }}
                            </p>
                            <p style="padding: 0; margin-top: 1px; margin-left: 1%;">
                                <b class="deep-purple-text darken-3">Author:</b> {{ $task->author }}
                            </p>
                            <p style="padding: 0; margin-bottom: 3px; margin-left: 1%; margin-top: 4px;">
                            <b class="deep-purple-text darken-3" >Patient:</b> {{ $task->patient->first_name }} {{ $task->patient->last_name }} 
                            </p>
                      </div>
                    </li>
                  
               
                
                <!-- Delete Patient Model-->
                <div id="{{ 'deletemodel'.$task->id }}" class="modal">
                    <div class="modal-content">
                        <h4>Are you sure want to delete?</h4>
                    </div>
                    <div class="modal-footer">
                        <a 
                            href="#!" 
                            class=" modal-action modal-close waves-effect btn purple darken-3" 
                            style="margin-left: 10px;">
                            Cancel
                        </a>
                        {!! FORM::open([
                            'method' => 'DELETE',
                            'url' => ['app/task/delete', $task->id]]) !!}
                        {!! FORM::submit('Delete', ['class' => 'btn red darken-3']) !!}
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
                            {!! FORM::label('description', 'Description:') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>

                        {!! FORM::submit('Update', ['class' => 'btn green darken-3']) !!}
                    </div>
                    {!! FORM::close() !!}
                </div>

            @endforeach
            </ul>
                </div>
        @endif
    </div>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
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
            data-tooltip="New comment">
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
                {!! FORM::select('patient_id', $patientList) !!}
                {!! FORM::label('patient', 'Patient:') !!}
            </div>
            <div class="input-field col 12">
                {!! FORM::text('title', null) !!}
                {!! FORM::label('title', 'Title:') !!}
            </div>
            <div class="input-field col 12">
                {!! FORM::textarea('description', null, ['class' => 'materialize-textarea', 'size' => '10x5']) !!}
                {!! FORM::label('description', 'Description:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>
            {!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>

    <!-- Filter Task Model-->
    <div id="modal_filter" class="modal modal-fixed-footer">
            {!! FORM::open(['url' => 'app/task/filter','class' => 'filterForm']) !!}
        <div class="modal-content">
            <div class="input-field col 12">
                {!! FORM::select('user_id',$userList) !!}
                {!! FORM::label('user', 'User:') !!}
            </div>
            <div class="input-field col 12">
                {!! FORM::select('patient_id',$patientList) !!}
                {!! FORM::label('patient', 'Patient:') !!}
            </div>
            <div class="input-field col 12">
            {!! FORM::text('from_date', null ,array('class' => 'datepicker')) !!}
                {!! FORM::label('user', 'From:') !!}
            </div>
            <div class="input-field col 12">
            {!! FORM::text('to_date', null ,array('class' => 'datepicker')) !!}
                {!! FORM::label('user', 'To:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect btn red darken-3" style="margin-left: 20px;">Cancel</a>
            {!! FORM::submit('Submit', ['class' => 'btn btn-primary green darken-3']) !!}
            <input type="button" onclick="reset()" value="Reset" class="btn btn-primary deep-purple" style="margin-right: 20px;">
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