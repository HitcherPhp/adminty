@if (count($table_data))
    <table id="dt-nested-object" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="dt-nested-object_info" style="width: auto">
        <thead>
        <tr role="row">
            <th id="select-delete-options" tabindex="0" aria-controls="dt-nested-object" rowspan="1" colspan="1" style="width: 20px;">
                <div class="checkbox-fade fade-in-primary">
                    <label class="check-task">
                        <input id="all-element-id" name="all-element-id" class="row-checkbox" type="checkbox" value="">
                        <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                    </label>
                </div>
            </th>
            @foreach($column_names as $column_name)
                <th class="sorting" tabindex="0" aria-controls="dt-nested-object" rowspan="1" colspan="1" style="width: 200px;">{{ $column_name }}</th>
            @endforeach
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th rowspan="1" colspan="1"></th>
            @foreach($column_names as $column_name)
                <th rowspan="1" colspan="1">{{ $column_name }}</th>
            @endforeach
        </tr>
        </tfoot>
        <tbody>
        @foreach($table_data as $row)
            <tr role="row" class="odd table-row">
                @foreach($row as $key => $elem)
                    @if($key == "id")
                        <td>
                            <div class="checkbox-fade fade-in-primary">
                                <label class="check-task">
                                    <input name="element-id" class="row-checkbox" type="checkbox" value="{{$elem}}">
                                    <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                </label>
                            </div>
                        </td>
                    @elseif(in_array($key, ["name"]))
                        <td><div class="info-card"><a class="text-primary">{{ $elem }}</a></div></td>
                    @else
                        <td>{{ $elem }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <?php echo $paginator; ?>
@else

    <div class="data-table-main message-icon">
        <div class="mrow">
            <i class="zmdi zmdi-comment-alert mg-icon-position"></i>
            @if ($search)
                <h4>По запросу {{ $search }}. Ничего не найдено.</h4>
            @else
                <h4>Данных не найдено.</h4>
            @endif
        </div>
    </div>

@endif
