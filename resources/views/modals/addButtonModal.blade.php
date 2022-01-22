<div id="add_modal_window" class="add-modal_window  md-effect-1">
    <div id="modal_window_content" class="add-modal_window_content {{ $inputs['modal_size'] }}">
        <div class="card">
            <div class="card-header">
                <h5 id="add_modal_header"></h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="product-edit">
                            <ul class="nav nav-tabs nav-justified md-tabs " role="tablist">
                                @foreach($inputs['tabs'] as $tabs)
                                <li class="nav-item">
                                    <a class="nav-link {{ $tabs['class_active'] }}" data-toggle="tab" href="#{{ $tabs['href'] }}" role="tab">
                                        <div class="f-20">
                                            <i class="icofont {{ $tabs['icon_class'] }}"></i>
                                        </div>
                                        {{ $tabs['text'] }}
                                    </a>
                                    <div class="slide {{ $inputs['slide_tabs'] }}" ></div>
                                </li>
                                @endforeach
                            </ul>
                            <form class="md-float-material card-block" id="modal_inputs" data="{{ $link }}/store" method="POST">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="{{ $inputs['tabs'][0]['href'] }}" role="tabpanel">
                                        @csrf
                                        @foreach($inputs['first_tab'] as $addinput )
                                        @if($addinput['mode'] == 'input')
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icofont {{ $addinput['class'] }}" ></i></span>
                                                <input type="{{ $addinput['type'] }}" class="form-control" placeholder="{{ $addinput['placeholder'] }}" name="{{ $addinput['name'] }}">
                                            </div>
                                        </div>
                                        @endif
                                        @if($addinput['mode'] == 'select_groups')
                                        <div class="col-sm-12" id ="select_group">
                                            <div class="input-group">
                                                <select name="{{$addinput['name']}}" id="group_select_val" class="form-control form-control-primary">
                                                    <option hidden value="0">{{ $addinput['placeholder'] }}</option>
                                                    @foreach($addinput['options'] as $groupitem)
                                                    <option value="{{ $groupitem->id }}">{{ $groupitem->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        @if($addinput['mode'] == 'select_reception')
                                        @if(count($addinput['options']) != 0)
                                        <div class="col-sm-12 validation_ignore" id ="select_reception">
                                            <div class="input-group">
                                                <select name="{{$addinput['name']}}" id="reception_select_val" class="form-control form-control-primary validation_ignore">
                                                    <option hidden value="0">{{ $addinput['placeholder'] }}</option>
                                                    @foreach($addinput['options'] as $receptions)
                                                    <option value="{{ $receptions->id }}">{{ $receptions->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endforeach
                                        @if($addinput['mode'] == 'household')
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <div class="border-checkbox-section">
                                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                                        <input class="border-checkbox for_ignore" name="household_check" type="checkbox" id="household_check">
                                                        <label class="border-checkbox-label" for="household_check">Поставьте галочку, если есть услуги ремонта крашения и хранения</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif


                                        <input id="franchise_id" type="text" name="franchise_id" hidden value="">
                                    </div>
                                    @if(count($inputs['tabs']) > 1)
                                    <div class="tab-pane" id="{{ $inputs['tabs'][1]['href'] }}" role="tabpanel">
                                        @foreach($inputs['second_tab'] as $addinput )
                                        @if($addinput['mode'] == 'input')
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icofont {{ $addinput['class'] }}" ></i></span>
                                                <input type="{{ $addinput['type'] }}" class="form-control" placeholder="{{ $addinput['placeholder'] }}" name="{{ $addinput['name'] }}">
                                            </div>
                                        </div>
                                        @endif
                                        @if($addinput['mode'] == 'schedule')
                                        <schedule-wrapper ref="schedule_wrapper"></schedule-wrapper>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    @if(count($inputs['tabs']) > 2)
                                    <div class="tab-pane" id="{{ $inputs['tabs'][2]['href'] }}" role="tabpanel">
                                        @foreach($inputs['third_tab'] as $addinput )
                                        @if($addinput['mode'] == 'input')
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icofont {{ $addinput['class'] }}" ></i></span>
                                                <input type="{{ $addinput['type'] }}" class="form-control" placeholder="{{ $addinput['placeholder'] }}" name="{{ $addinput['name'] }}">
                                            </div>
                                        </div>
                                        @endif
                                        @if($addinput['mode'] == 'select_city')
                                        <div class="row" id="select_city">
                                            <div class="col-sm-12 col-xl-12 m-b-30">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icofont {{ $addinput['class'] }}" ></i></span>
                                                    <select name="org_city_select" class="js-example-data-array col-sm-12 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                        <option hidden value="0">Выберите город</option>
                                                        @foreach($addinput['options'] as $key => $value)
                                                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    @if(count($inputs['tabs']) > 3)
                                    <div class="tab-pane" id="{{ $inputs['tabs'][3]['href'] }}" role="tabpanel">
                                        @foreach($inputs['fourth_tab'] as $addinput )
                                        @if($addinput['mode'] == 'input')
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icofont {{ $addinput['class'] }}" ></i></span>
                                                <input type="{{ $addinput['type'] }}" class="form-control" placeholder="{{ $addinput['placeholder'] }}" name="{{ $addinput['name'] }}">
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="text-center m-t-20">
                                            <button type="submit" id="save_new_data" class="btn btn-primary waves-effect waves-light m-r-10" >Сохранить
                                            </button>
                                            <button type="button" id="close_add_modal" class="btn btn-warning waves-effect waves-light" name="close_add_modal">Отменить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
