(function () {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);

    });

    /**
     * текущий год
     */
    let year_bottom = document.getElementById("year");
    if(year_bottom != null){
        year_bottom.innerHTML = new Date().getFullYear();
    }

    /**
     * пОиск по таблице
     */
    let inputSearch = document.querySelector('#search-page'),
        btnSearch   = document.querySelector('#btn-search');

    if(inputSearch !== null && btnSearch !== null){
        btnSearch.addEventListener('click',(e)=>{
            e.preventDefault();
            searchInTable(inputSearch);
        });

    }

    function searchInTable(inputSearch){
        let tableSearch = document.querySelector('.table-search'),
            searchText = inputSearch.value.toUpperCase();
        if(tableSearch !== null){
            /**
             * поиск в строках таблицы искомого значения
             */
            let trs = tableSearch.querySelectorAll('tbody>tr'),
                found = false;
            for (var i = 0; i < trs.length; i++){
                let tds = trs[i].querySelectorAll('td');
                for(var j = 0; j<tds.length; j++){
                    if (tds[j].innerHTML.toUpperCase().indexOf(searchText) > -1) {
                        found = true;
                    }
                }
                if (found) {
                    trs[i].style.display = "";
                    found = false;
                } else {
                    trs[i].style.display = "none";
                }
            }
        }
    }

    /**
     * Отображение данных только по конкретному администратору
     * Переход на страницу с Get запросом
     * url?id_admin=1
     */
    let select_id_admin = document.getElementById('select_id_admin');
    if(select_id_admin != null){
        select_id_admin.addEventListener("change", GoToPageWhithIdAdmin);
    }

    function GoToPageWhithIdAdmin(){
        let id_admin = select_id_admin.value,
            fullUrl  = document.location.href;
        //window.location.href = 'URL2';
        /**
         * Отризаем все что после ? у адреса
         */
        let url = fullUrl.split('?')[0];
        console.log(url);
        window.location.href = url + '?id_admin=' + id_admin;
    }
    /**
     * Календарик для таблиц
     */
    let select_date = document.getElementById('select_date');
    if(select_date != null){
        select_date.addEventListener("change", ()=>{
            //2202-10-10
            let dateDay = select_date.value;

            /**
             * Дату переделываем в формат дд.мм.гггг
             */
            let arrDate = dateDay.split('-'),
                newDate = arrDate[2]+'.'+arrDate[1]+'.'+arrDate[0];

            let tableSearch = document.querySelector('.table-search');

            if(tableSearch !== null){
                /**
                 * поиск в строках таблицы искомого значения
                 */
                let trs = tableSearch.querySelectorAll('tbody>tr'),
                    found = false;
                for (var i = 0; i < trs.length; i++){
                    let tds = trs[i].querySelectorAll('.date-order');
                    for(var j = 0; j<tds.length; j++){
                        if (tds[j].innerHTML.toUpperCase().indexOf(newDate) > -1) {
                            found = true;
                        }
                    }
                    if (found) {
                        trs[i].style.display = "";
                        found = false;
                    } else {
                        trs[i].style.display = "none";
                    }
                }

                if(dateDay.length<1){
                    console.log('empty');
                    for (var i = 0; i < trs.length; i++){
                        trs[i].style.display = "";
                    }
                }
            }
        });
    }

    /**
     * Получение данных клиента и размещение в инпутах
     */
    let form_bill = document.getElementById('form_bill');
    if(form_bill != null){
        let selector = form_bill.querySelector("#customers"),
            phone    = form_bill.querySelector('#phone'),
            email    = form_bill.querySelector("#email"),
            id_group = form_bill.querySelector('#id_group'),
            price    = form_bill.querySelector('#price');

        /**
         * Получаем данне о клиенте
         */
        selector.addEventListener("change", (e)=>{
            //console.log(e.target.value);
            $.ajax({
                url: '/customer/get_cust_info',
                method: 'post',
                dataType: 'html',
                data: {get_cust: 'Текст', id_cust: e.target.value},
                success: function(data){
                    console.log(data);
                    //{"email":"kotwler@mail.ru","phone":"79500239724"}
                    let arr = JSON.parse(data);
                    phone.value = arr.phone;
                    email.value = arr.email;
                }
            });
        });
        /**
         * Получаем данные о группе
         */
        id_group.addEventListener("change", (e)=>{
            $.ajax({
                url: '/group/get_group_info',
                method: 'post',
                dataType: 'json',
                data: {get_group: 'Текст', id_group: e.target.value},
                success: function(data){
                    console.log(data);
                    //{"email":"kotwler@mail.ru","phone":"79500239724"}
                    //let arr = JSON.parse(data);
                    price.value = data;
                }
            });
        });
    }

})();

/**
 * Сортировка таблицы
 */
$(document).ready(function() {
    $('#sortTable').DataTable({
        //disable sorting on last column
        "columnDefs": [
            { "orderable": false, "targets": 5 }
        ],
        language: {
            //customize pagination prev and next buttons: use arrows instead of words
            'paginate': {
                'previous': '<span class="fa fa-chevron-left"></span>',
                'next': '<span class="fa fa-chevron-right"></span>'
            },
            //customize number of elements to be displayed
            "lengthMenu": 'Display <select class="form-control input-sm">'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">All</option>'+
                '</select> results'
        }
    })
} );