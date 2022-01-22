
export default class DeleteModal {

    constructor(table) {
        this.table = table;
        this.overlay = document.getElementById('sweet-overlay');
        this.alert = document.getElementById('sweet-alert');
        this.option = this.table.data.querySelector('select[name=pagination-select]').value;
        this.data_for_removing = [];
        this.del_by_filter = false;
        this.search_attr = '';
        this.delete_all = 0;
    }

    show_modal() {
        this.alert.querySelector('#warning-icon').style.display = 'block';
        this.alert.querySelector('#success-icon').style.display = 'none';
        if (!this.table.data.querySelector('input[name=all-element-id]').checked) {
            this.alert.querySelector('h2').innerText = 'Вы выбрали записи в таблице';
            this.alert.querySelector('p').innerText = 'Нажмите удалить или закройте';
            this.alert.querySelector('button[name=delete]').innerText = 'Удалить';
            this.alert.querySelector('button[name=delete]').style.display = 'inline-block';
            this.alert.querySelector('button[name=delete_all]').style.display = 'none';
        }
        else {
            this.alert.querySelector('h2').innerText = 'Вы выбрали все записи в таблице';
            this.alert.querySelector('p').innerText = 'Выберите как удалить записи или закройте';
            this.alert.querySelector('button[name=delete]').innerText = 'Удалить только отображенные';
            this.alert.querySelector('button[name=delete_all]').innerText = 'Удалить все по фильтру';
            this.alert.querySelector('button[name=delete]').style.display = 'inline-block';
            this.alert.querySelector('button[name=delete_all]').style.display = 'inline-block';
        }
        this.overlay.style.display = 'block';
        this.alert.style.display = 'block';
    }

    close_modal() {
        this.overlay.style.display = 'none';
        this.alert.style.display = 'none';
        this.table.data.querySelectorAll('.row-checkbox').forEach(function(item) {
            item.checked = false;
        });

    }

    delete_rows(del_by_filter) {
        this.#set_request_data(del_by_filter);
        this.#send_ajax();
        this.#success();

    }

    #set_request_data(dbf) {
        if(!dbf) {
            for (let e of this.table.data.querySelectorAll('input[name=element-id]')){
                if (e.checked && this.table.ids.includes(e.value)) {
                    this.data_for_removing.push(e.value);
                }
            }
            this.del_by_filter = false;
        }
        else {
            this.del_by_filter = true;
        }
        this.search_attr = this.table.data.querySelector('input[name=table-search]').value;
    }

    #send_ajax() {
        const xhr = new XMLHttpRequest();
        const url = '/' + this.table.data.dataset.link + '/update_table';
        const json = JSON.stringify({
            option: this.option,
            search_attribute: this.search_attr,
            data_for_removing: this.data_for_removing,
            delete_all: this.del_by_filter
        });
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        xhr.open("POST", url, true);
        xhr.setRequestHeader('X-CSRF-Token', csrf);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.send(json);
        let t = this.table;
        xhr.onloadend = function() {
            if (xhr.status == 200) {
                t.data.querySelector('#table_data').innerHTML = xhr.responseText;
            }
        };
    }

    #success() {
        this.alert.querySelector('#warning-icon').style.display = 'none';
        this.alert.querySelector('#success-icon').style.display = 'block';
        this.alert.querySelector('h2').innerText = 'Записи удалены';
        this.alert.querySelector('p').innerText = 'Нажмите закрыть чтобы выйти';
        this.alert.querySelector('button[name=delete]').style.display = 'none';
        this.alert.querySelector('button[name=delete_all]').style.display = 'none';
    }
}
