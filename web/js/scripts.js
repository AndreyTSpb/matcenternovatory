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

})();