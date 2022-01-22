import DeleteModal from './DeleteModal.js';

document.addEventListener('DOMContentLoaded', table_events);
let table = {data: null, ids: []};
let c = 0;

export function table_events() {
    table.ids = [];
    document.querySelectorAll('button[name=delete-row]').forEach(function(item) {
        item.disabled = true;
    });
    document.querySelectorAll('.row-checkbox').forEach(function(item) {
        item.addEventListener(`click`, checkbox_logic);
        if (item.value) { table.ids.push(item.value); }
    });
}


function checkbox_logic() {
    if (!table.data || table.data.dataset.link != this.closest('.table-name').dataset.link) {
        if (!table.data) {
            table.data = this.closest('.table-name');
        }
        button_logic();
    }
    if (this.name == 'all-element-id') {
        select_all();
    }
    else {
        select_some();
    }
}

function button_logic() {
    delete_button_show(false);
    table.data.querySelector('button[name=delete-row]').addEventListener('click', open_modal);
}


function select_all() {

    table.data.querySelectorAll('input[name=element-id]').forEach(function (item) {
        if (!table.data.querySelector('input[name=all-element-id]').checked) {
            c = 0;
            item.checked = false;
            item.closest('.table-row').classList.remove('active');
            delete_button_show(false);
        }
        else {
            c = table.ids.length;
            item.checked = true;
            item.closest('.table-row').classList.add('active');
            delete_button_show(true);
        }
    });
}

function select_some() {

    c = 0;
    if (table.data.querySelector('input[name=all-element-id]').checked) {
        table.data.querySelector('input[name=all-element-id]').checked = false;
    }
    table.data.querySelectorAll('input[name=element-id]').forEach(function (item) {
        if(item.checked) {
            item.closest('.table-row').classList.add('active');
            c++;
        }
        else {
            item.closest('.table-row').classList.remove('active');
        }
    });

    if (c == table.ids.length) {
        table.data.querySelector('input[name=all-element-id]').checked = true;
    }

    if(c > 0 && c <= table.ids.length) {
        delete_button_show(true);
    }
    else {
        delete_button_show(false);
    }
}

function delete_button_show(a) {
    if (a) {
        table.data.querySelector('button[name=delete-row]').disabled = false;
    }
    else {
        table.data.querySelector('button[name=delete-row]').disabled = true;
    }
}

function open_modal() {
    let DM = new DeleteModal(table);
    DM.show_modal();
    DM.alert.querySelector('button[name=cancel]').onclick = function () {
        DM.close_modal();
        table.data = null;
        table_events();
    };
    DM.alert.querySelector('button[name=delete]').onclick = function () {
        DM.delete_rows(false);
        table_events();
    }
    DM.alert.querySelector('button[name=delete_all]').onclick = function () {
        DM.delete_rows(true);
        table_events()
    }
}
