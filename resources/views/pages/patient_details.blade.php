@extends('master')
@section('patient-details')
    <div class="container">
        <br>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3 blue-text"><a href="#dnevniVnosi">Dnevni vnosi</a></li>
                    <li class="tab col s3"><a href="#izmerjenSladkor">Izmerjen sladkor</a></li>
                    <li class="tab col s3"><a href="#obisk">Obiski</a></li>
                </ul>
            </div>
            <div id="dnevniVnosi" class="col s12">
                <br>
                @if(count($Patient->getDayvisits) == 0)
                    <div class="col s12"> 
                       <div class="card-panel center">
                           <h5 class="deep-purple-text">Ni podatkov.</h5>
                        </div>
                    </div>
                @else
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="datum">Datum meritve</th>
                        <th data-field="vrstaHrane">Vrsta hrane</th>
                        <th data-field="kodaHrane">Naziv hrane</th>
                        <th data-field="mascober">Masčoba</th>
                        <th data-field="beljakovine">Beljakovine</th>
                        <th data-field="kalorije">Kalorije</th>
                        <th data-field="ogljikohidrati">Oglj.hidrati</th>
                        <th data-field="količinaZaušiteSnovi">Količina zaušite snovi</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ( $Patient->getDayvisits->sortByDesc('updated_at') as $dv)
                        <tr>
                            <td>{{ $dv->updated_at->format('d.m.Y') }}</td>
                            
                            @if( $dv->food_category_id == 2)
                               <td>Intravenozno</td> 
                            @endif

                            @if( $dv->food_category_id == 1)
                                <td>Per Os</td>
                            @endif
                            
                            <td>{{ App\Food::returnTitle($dv->food_code)->title }}</td>
                            <td>{{ $dv->fat }}</td>
                            <td>{{ $dv->protein }}</td>
                            <td>{{ $dv->calories }}</td>
                            <td>{{ $dv->carbohydrates }}</td>
                            <td>{{ $dv->quantity }}</td>
                            <td class="td-icon">
                                <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Urejanje" href="#{{ 'ds_model'.$dv->id }}" >
                                    <i class="material-icons  green darken-3">mode_edit</i>
                                </a>
                            </td>
                            @can('admin')
                                <td class="td-icon">
                                    <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel_dv'.$dv->id }}"  data-method="delete">
                                        <i class="material-icons  red darken-1">delete</i>
                                    </a>
                                </td>
                            @endcan
                        </tr>


                        <!-- Delete Day Visit-->
                        <div id="{{ 'deletemodel_dv'.$dv->id }}" class="modal">
                            <div class="modal-content">
                                <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::open([
                                    'method' => 'DELETE',
                                    'url' => ['app/patient/day_visit_delete', $dv->id]]) !!}
                                {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>

                        <!-- Edit Day Visit-->
                        <div id="{{ 'ds_model'.$dv->id }}" class="modal modal-fixed-footer">
                            {!! FORM::model($dv,[
                                'method' => 'PUT',
                                'url' => ['app/patient/day_visit_edit', $dv->id]
                               ])
                            !!}
                            <div class="modal-content">
                                <div class="input-field">
                                    {!! FORM::input('number', 'quantity', null, array('min'=>'0','max'=>'1000')) !!}
                                    {!! FORM::label('quantity', 'Količina:') !!}
                                </div>
                               {{--  <div class="input-field">
                                    {!! FORM::text('updated_at', null, array('class' => 'datepicker')) !!}
                                    {!! FORM::label('updated_at', 'Datum konca hospitalizacije:') !!}
                                </div> --}}
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>
                        @endforeach
                    
                    </tbody>
                    @if(count($Patient->getDayvisits) > 1)
                    <tr style="border-top: 1px solid #d0d0d0;" class="indigo lighten-5">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold;">{{ $Patient->getDayvisits->sum('fat') }}</td>
                        <td style="font-weight: bold;">{{ $Patient->getDayvisits->sum('protein') }}</td>
                        <td style="font-weight: bold;">{{ $Patient->getDayvisits->sum('calories') }}</td>
                        <td style="font-weight: bold;">{{ $Patient->getDayvisits->sum('carbohydrates') }}</td>
                        <td style="font-weight: bold;">{{ $Patient->getDayvisits->sum('quantity') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </table>
                @endif


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

            <div id="izmerjenSladkor" class="col s12">
                <br>
                 @if(count($Patient->getMeasuredsugars) == 0)
                    <div class="col s12"> 
                       <div class="card-panel center">
                           <h5 class="deep-purple-text">Ni podatkov.</h5>
                        </div>
                    </div>
                @else
                <table class="centered">
                    <thead>
                    <tr>
                        <th data-field="datum">Datum meritve</th>
                        <th data-field="stevilkaObiska">Številka obiska</th>
                        <th data-field="meritev">Meritev</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ( $Patient->getMeasuredsugars->sortByDesc('updated_at') as $ms)
                        <tr>
                            <td>{{ $ms->updated_at->format('d.m.Y') }}</td>
                            <td>{{ $ms->number_of_visits }}</td>
                            <td>
                                @if($ms->measurement >= 11)
                                    <b class="red-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Sladkorno bolezen">{{ $ms->measurement }}<b>
                                @else 
                                    {{ $ms->measurement }}
                                @endif
                            </td>
                            <td class="td-icon">
                                <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Urejanje" href="#{{ 'ms_model'.$ms->id }}" >
                                    <i class="material-icons  green darken-3">mode_edit</i>
                                </a>
                            </td>
                             @can('admin')
                                <td class="td-icon">
                                    <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel_ms'.$ms->id }}"  data-method="delete">
                                        <i class="material-icons  red darken-1">delete</i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                        

                        <!-- Delete Measured sugar-->
                        <div id="{{ 'deletemodel_ms'.$ms->id }}" class="modal">
                            <div class="modal-content">
                                <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::open([
                                    'method' => 'DELETE',
                                    'url' => ['app/patient/m_sugar_delete', $ms->id]]) !!}
                                {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>

                        
                        <!-- Edit Measured sugar-->
                        <div id="{{ 'ms_model'.$ms->id }}" class="modal modal-fixed-footer">
                            {!! FORM::model($ms,[
                                'method' => 'PUT',
                                'url' => ['app/patient/m_sugar_edit', $ms->id]
                               ])
                            !!}
                            <div class="modal-content">
                                <div class="input-field">
                                    {!! FORM::input('number','measurement',null, array('min'=>'1','step' => '0.1','max'=>'30')) !!}
                                    {!! FORM::label('measurement', 'Meritev:') !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div> 

                    @endforeach
                    
                    </tbody>
                    @if(count($Patient->getMeasuredsugars) > 1)
                    <tr style="border-top: 1px solid #d0d0d0;" class="indigo lighten-5">
                        <td></td>
                        <td style="font-weight: bold;">{{ $Patient->getMeasuredsugars->sum('number_of_visits') }}</td>
                        <td style="font-weight: bold;">{{ $Patient->getMeasuredsugars->sum('measurement') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </table>
                @endif

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
                @if(count($Patient->getVisits) == 0)
                        <div class="col s12"> 
                           <div class="card-panel center">
                               <h5 class="deep-purple-text">Ni podatkov.</h5>
                            </div>
                        </div>
                    @else
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
                    @foreach ( $Patient->getVisits->sortByDesc('updated_at') as $v)
                        <tr>
                            <td>{{ $v->number_of_visits }}</td>
                            <td>{{ $v->start_date }}</td>
                            <td>{{ $v->end_date }}</td>
                            <td>{{ $v->section_code }}</td>
                            <td>{{ $v->height }}</td>
                            <td>{{ $v->heaviness }}</td>
                            <td>{{ $v->ideal_heaviness }}</td>
                            <td>{{ $v->nutritive_needs }}</td>
                            <td class="td-icon">
                                <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Urejanje" href="#{{ 'v_model'.$v->id }}" >
                                    <i class="material-icons  green darken-3">mode_edit</i>
                                </a>
                            </td>
                            @can('admin')
                                <td class="td-icon">
                                    <a class="btn-floating modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Brisanje" href="#{{ 'deletemodel_v'.$v->id }}"  data-method="delete">
                                        <i class="material-icons  red darken-1">delete</i>
                                    </a>
                                </td>
                            @endcan
                        </tr>

                         <!-- Delete Visit-->
                        <div id="{{ 'deletemodel_v'.$v->id }}" class="modal">
                            <div class="modal-content">
                                <h5>Ali ste prepričani, da želite izbrisati ?</h5>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class=" modal-action modal-close waves-effect btn purple darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::open([
                                    'method' => 'DELETE',
                                    'url' => ['app/patient/visits_delete', $v->id]]) !!}
                                {!! FORM::submit('Delete', ['class' => 'btn danger-3 red']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div>

                        <!-- Edit Visit -->
                        <div id="{{ 'v_model'.$v->id }}" class="modal modal-fixed-footer">
                            {!! FORM::model($v,[
                                'method' => 'PUT',
                                'url' => ['app/patient/visits_edit', $v->id]
                               ])
                            !!}
                             <div class="modal-content">
                                <div class="input-field">
                                    {!! FORM::text('start_date', null, array('class' => 'datepicker')) !!}
                                    {!! FORM::label('start_date', 'Datum začetka hospitalizacije:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::text('end_date', null, array('class' => 'datepicker')) !!}
                                    {!! FORM::label('end_date', 'Datum konca hospitalizacije:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::input('number','section_code',null, array('min'=>'0','max'=>'9999')) !!}
                                    {!! FORM::label('section_code', 'Koda odelka:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::input('number','height',null, array('min'=>'0','max'=>'9999')) !!}
                                    {!! FORM::label('height', 'Višina:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::input('number','heaviness',null, array('min'=>'0','max'=>'9999')) !!}
                                    {!! FORM::label('heaviness', 'Teža:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::input('number','ideal_heaviness',null, array('min'=>'0','max'=>'9999')) !!}
                                    {!! FORM::label('ideal_heaviness', 'Idealna teža:') !!}
                                </div>

                                <div class="input-field">
                                    {!! FORM::input('number','nutritive_needs',null, array('min'=>'0','max'=>'9999')) !!}
                                    {!! FORM::label('nutritive_needs', 'Hranilne potrebe:') !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>

                                {!! FORM::submit('Posodobi', ['class' => 'btn green darken-3']) !!}
                            </div>
                            {!! FORM::close() !!}
                        </div> 
                    @endforeach
                    
                    </tbody>
                    @if(count($Patient->getVisits) > 1)
                    <tr style="border-top: 1px solid #d0d0d0;" class="indigo lighten-5">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </table>
                @endif

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

    <!-- 
    ++++********************
            MODEL ADD
    ************************
    -->

    <!-- ADD DAY VISIT-->
    <div id="addDetail-dayVisit" class="modal modal-fixed-footer">

        {!! FORM::model($Patient,[
            'method' => 'POST',
            'url' => ['app/patient/store_day_v', $Patient->id]
           ])
		!!}
        <div class="modal-content">

            <div class="input-field col 12">
                <select name="food_type" id="cateogries">
                    @foreach($categorys as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                {!! FORM::label('food_type', 'Vrsta hrane:') !!}
            </div>
            
            <div class="input-field col 12">
                <select name="food_code" id="subcategory" disabled>
                   <option value="" disabled selected>None</option>
                </select>
                {!! FORM::label('food_code', 'Naziv hrane:') !!}
            </div>

            <div class="input-field col 12">
               {!! FORM::input('number','quantity',null, array('min'=>'0','max'=>'10000')) !!}
                {!! FORM::label('quantity', 'Količina zaušite snovi (ml):') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>
            {!! FORM::submit('Shrani', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>
    <!-- ADD MEASURED SUGAR-->
    <div id="addDetail-measuredSugar" class="modal modal-fixed-footer">

        {!! FORM::model($Patient,[
            'method' => 'POST',
            'url' => ['app/patient/store_m_sugar', $Patient->id]
           ])
		!!}
        
        <div class="modal-content">

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
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3 " style="margin-left: 10px;">Prekliči</a>
            {!! FORM::submit('Shrani', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>
    <!-- ADD VISITS-->
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
                {!! FORM::input('number','ideal_heaviness',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('ideal_heaviness', 'Idealna teža:') !!}
            </div>

            <div class="input-field col 12">
                {!! FORM::input('number','nutritive_needs',null, array('min'=>'0','max'=>'9999')) !!}
                {!! FORM::label('nutritive_needs', 'Hranilne potrebe:') !!}
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect btn red darken-3" style="margin-left: 10px;">Prekliči</a>
            {!! FORM::submit('Shrani', ['class' => 'btn btn-primary green darken-3']) !!}
        </div>
        {!! FORM::close() !!}
    </div>



@stop