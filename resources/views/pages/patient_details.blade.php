@extends('master')
@section('patient-details')
    <div class="container">
        <br>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3 blue-text"><a href="#dnevniVnosi">Dnevni vnosi</a></li>
                    <li class="tab col s3"><a href="#izmjerenSladkor">Izmerjen sladkor</a></li>
                    <li class="tab col s3"><a href="#obisk">Obiski</a></li>
                </ul>
            </div>
            <div id="dnevniVnosi" class="col s12">
                <br>
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="datum">Datum meritve</th>
                        <th data-field="vrstHrane">Vrst hrane</th>
                        <th data-field="kodaHrane">Koda hrane</th>
                        <th data-field="mascober">Masčoba</th>
                        <th data-field="beljankovine">Beljankovine</th>
                        <th data-field="kalorije">Kalorije</th>
                        <th data-field="ogljikohidrati">Oglj.hidrati</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ( $Patient->getDayvisits as $dv)
                    <tr>
                        <td>{{ $dv->date_of_visit }}</td>
                        <td>{{ $dv->food_type }}</td>
                        <td>{{ $dv->food_code }}</td>
                        <td>{{ $dv->fat }}</td>
                        <td>{{ $dv->protein }}</td>
                        <td>{{ $dv->calories }}</td>
                        <td>{{ $dv->carbohydrates }}</td>
                        @can('admin')
                            <td class="td-icon">
                                <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel'.$dv->id }}"  data-method="delete">
                                    <i class="material-icons  red darken-1">delete</i>
                                </a>
                            </td>
                        @endcan
                    </tr>


                    <!-- Delete Day Visit-->
                    <div id="{{ 'deletemodel'.$dv->id }}" class="modal bottom-sheet">
                        <div class="modal-content">
                            <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                        </div>
                        <div class="modal-footer">

                            <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Preklic</a>

                            {!! FORM::open([
                                'method' => 'DELETE',
                                'url' => ['app/patient/day_visit_delete', $dv->id]]) !!}
                            {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                        </div>
                        {!! FORM::close() !!}
                    </div>

                    @endforeach
                    </tbody>
                </table>


                <!-- Add 1. Button-->
                <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                    <a href="#addDetail-dayVisit"
                       class="btn-floating btn-large tooltipped waves-effect waves-light purple darken-4 modal-trigger "
                       data-position="left"
                       data-delay="50"
                       data-tooltip="Dnevni vnos">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>

            <div id="izmjerenSladkor" class="col s12">
                <br>
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="datum">Datum meritve</th>
                        <th data-field="stevilkaObiska">Številka obiska</th>
                        <th data-field="meritev">Meritev</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ( $Patient->getMeasuredsugars as $ms)
                        <tr>
                            <td>{{ $ms->date_of_measurement }}</td>
                            <td>{{ $ms->number_of_visits }}</td>
                            <td>
                                @if($ms->measurement >= 11)
                                    <b class="red-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Sladkorno bolezen">{{ $ms->measurement }}<b>
                                @else 
                                    {{ $ms->measurement }}
                                @endif
                            </td>
                            @can('admin')
                                <td class="td-icon">
                                    <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel'.$ms->id }}"  data-method="delete">
                                        <i class="material-icons  red darken-1">delete</i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                        

                        <!-- Delete Measured sugar-->
                        <div id="{{ 'deletemodel'.$ms->id }}" class="modal bottom-sheet">
                            <div class="modal-content">
                                <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Preklic</a>

                                {!! FORM::open([
                                    'method' => 'DELETE',
                                    'url' => ['app/patient/m_sugar_delete', $ms->id]]) !!}
                                {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>


                    @endforeach
                    </tbody>
                </table>

                <!-- Add 2. Button-->
                <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                    <a href="#addDetail-measuredSugar"
                       class="btn-floating btn-large tooltipped waves-effect waves-light purple darken-4 modal-trigger "
                       data-position="left"
                       data-delay="50"
                       data-tooltip="Vnos izmerjenega sladkorja">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </div>


            <div id="obisk" class="col s12">
                <br>
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="stevilkaObiska">Število hospitalizacije</th>
                        <th data-field="Datum zacetka hospitalizacije">Datum z/hosp.</th>
                        <th data-field="Datum konca hospitalizacije">Datum k/hosp.</th>
                        <th data-field="koda odelka">koda odelka</th>
                        <th data-field="Visina">Visina</th>
                        <th data-field="Teza">Teza</th>
                        <th data-field="Idealna teza">Idealna teza</th>
                        <th data-field="Hranilne potrebe">Hranilne potrebe</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ( $Patient->getVisits as $v)
                        <tr>
                            <td>{{ $v->number_of_visits }}</td>
                            <td>{{ $v->start_date }}</td>
                            <td>{{ $v->end_date }}</td>
                            <td>{{ $v->section_code }}</td>
                            <td>{{ $v->height }}</td>
                            <td>{{ $v->heaviness }}</td>
                            <td>{{ $v->i_heaviness }}</td>
                            <td>{{ $v->nutritive_needs }}</td>
                            @can('admin')
                                <td class="td-icon">
                                    <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel'.$v->id }}"  data-method="delete">
                                        <i class="material-icons  red darken-1">delete</i>
                                    </a>
                                </td>
                            @endcan
                        </tr>

                         <!-- Delete Visit sugar-->
                        <div id="{{ 'deletemodel'.$v->id }}" class="modal bottom-sheet">
                            <div class="modal-content">
                                <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Preklic</a>

                                {!! FORM::open([
                                    'method' => 'DELETE',
                                    'url' => ['app/patient/visits_delete', $v->id]]) !!}
                                {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>

                    @endforeach
                    </tbody>
                </table>

                <!-- Add 3. Button-->
                <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                    <a href="#addDetail-visits"
                       class="btn-floating btn-large tooltipped waves-effect waves-light purple darken-4 modal-trigger "
                       data-position="left"
                       data-delay="50"
                       data-tooltip="Vnos obiska">
                        <i class="material-icons">add</i>
                    </a>
                </div>


            </div>
        </div>
    </div>

    <!-- MODELs-->


    <div id="addDetail-dayVisit" class="modal modal-fixed-footer">

        {!! FORM::model($Patient,[
            'method' => 'POST',
            'url' => ['app/patient/store_day_v', $Patient->id]
           ])
		!!}
        <div class="modal-content">

            <div class="input-field col 12">
                {!! FORM::select('food_type', array('Per os'=>'Per os','Inravenozno'=>'Inravenozno'),"Vrsta hrane") !!}
                {!! FORM::label('food_type', 'Vrsta hrane:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::select('food_code', $Food_list,"Kode hrane") !!}
                {!! FORM::label('food_code', 'Koda hrane:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::text('date_of_visit', null ,array('class' => 'datepicker')) !!}
                {!! FORM::label('date_of_visit', 'Datum vnosa:') !!}
            </div>

            <div class="input-field col 12">
               {!! FORM::input('number','fat',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('fat', 'Maščoba :') !!}
            </div>

            <div class="input-field col 12">
               {!! FORM::input('number','protein',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('protein', 'Beljankovine:') !!}
            </div>

            <div class="input-field col 12">
               {!! FORM::input('number','calories',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('calories', 'Kalorije :') !!}
            </div>

            <div class="input-field col 12">
               {!! FORM::input('number','carbohydrates',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('carbohydrates', 'Oglj.hidrati:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>
            {!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>

    <div id="addDetail-measuredSugar" class="modal modal-fixed-footer">

        {!! FORM::model($Patient,[
            'method' => 'POST',
            'url' => ['app/patient/store_m_sugar', $Patient->id]
           ])
		!!}
        
        <div class="modal-content">
            <div class="input-field col 12">
                {!! FORM::text('date_of_measurement', null, array('class' => 'datepicker')) !!}
                {!! FORM::label('date_of_measurement', 'Datum meritve:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','number_of_visits',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('number_of_visits', 'Število obiska:') !!}
            </div>
            <div class="input-field col 12">
                {!! FORM::input('number','measurement',null, array('min'=>'1','step' => '0.1','max'=>'30')) !!}
                {!! FORM::label('measurement', 'Meritev (mmol/l):') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3 " style="margin-left: 10px;">Cancel</a>
            {!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>


    <div id="addDetail-visits" class="modal modal-fixed-footer">

        {!! FORM::model($Patient,[
            'method' => 'POST',
            'url' => ['app/patient/store_visits', $Patient->id]
           ])
		!!}
        <div class="modal-content">

            <div class="input-field col 12">
                {!! FORM::text('start_date', null, array('class' => 'datepicker')) !!}
                {!! FORM::label('start_date', 'Datum začetka hospitalizacije:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::text('end_date', null, array('class' => 'datepicker')) !!}
                {!! FORM::label('end_date', 'Datum konca hospitalizacije:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','section_code',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('section_code', 'Koda odelka:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','height',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('height', 'Višina:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','heaviness',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('heaviness', 'Teža:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','i_heaviness',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('i_heaviness', 'Idealna teža:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','nutritive_needs',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('nutritive_needs', 'Hranilne potrebe:') !!}
            </div>



        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Cancel</a>
            {!! FORM::submit('Save', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>

@stop