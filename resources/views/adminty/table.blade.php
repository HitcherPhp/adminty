@extends('layouts.adminty')

@section('table')
<div class="card">
    <div class="card-header">
        <h5>Nested Object Data (objects)</h5>
        <span>The example below shows DataTables loading data for a table from arrays as the data source, where the structure of the row's data source in this example is:</span>
    </div>
    <div class="card-block table-name">
        <div data-link="{{ $link }}" class="table-name table-responsive dt-responsive">
            <div id="dt-nested-object_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div id="select-option-unic">
                        <div class="dataTables_length" id="dt-nested-object_length">
                            <label>
                                Show
                                <select id="pagination-select" name="pagination-select" aria-controls="dt-nested-object" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div id="class-btn_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <button id="add-row" class="btn btn-add-row" name="add-row">Добавить</button>
                        <button id="delete-row" disabled class="btn btn-delete-row" name="delete-row">Удалить</button>
                    </div>
                    <div id="search-input-unic" class="dataTables_filter">
                        <input id="table-search" name="table-search" type="search" class="form-control input-sm" placeholder="Поиск по таблице" aria-controls="class-btn"></div>
                    </div>
                </div>
                <div class="row">
                    <div id="table_data" class="col-xs-12 col-sm-12">
                        @include('adminty.tablePaginationRender')
                    </div>
                </div>
                <script async type="text/babel" src="{{ asset('js/DeleteModal.js') }}"></script>
                <script type="text/babel" src="{{ asset('js/TableDeleteController.js') }}"></script>
            </div>
        </div>
    </div>
</div>
@include('modals.addButtonModal')

@endsection
