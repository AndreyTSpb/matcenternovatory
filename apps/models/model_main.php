<?php


class Model_Main extends Model
{
    function get_user_data(){
        /**
         * Все заявки пользователя
         */
        $header = array(
            '#',
            'Класс',
            'Тип',
            'Описание',
            'Ответственный',
            'Дата создания',
            'Дата завершения'
        );
        $body = $this->get_body_user_order();
        return Class_Create_Simple_Table::html($header, $body);
    }

    /**
     * Данные по заявкам созданым пользователем
     * @return array
     */
    function get_body_user_order(){
        $obj = new Model_Orders(
            ['where' => 'users_id = '.(int)$this->id_user,
                "order" => 'dt DESC'
            ]);
        if(!$obj->num_row){
            return array(
                0 => array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        '1',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных'
                    )
                )
            );
        }
        $arr = array();
        $rows = $obj->getAllRows();
        /**
         * $arr[$row['id']]['class_tr'] - стили для раскраски строк в таблице
         *  table-success - выполнено,
         *  table-danger - просрочено,
         *  table-warning - принято,
         *  table-light - новая
         */
        foreach ($rows as $row){
            $arr[$row['id']]['class_tr'] = $this->statusOrder($row['status'], $row['dt']);
            $arr[$row['id']]['tds'] = array(
                $row['id'],
                'Класс',
                'Тип',
                'Описание',
                'Ответственный',
                'Дата создания',
                'Дата завершения'
            );
        }

        return $arr;
    }

    /**
     * Кнопка новая заявка
     */
    function btn_new_order(){
        return '<div class=\'input-group date\' id=\'datetimepicker3\'> 
                    <a href="'. DOCUMENT_ROOT.'/order/new" class="btn btn-sm btn-outline-secondary">Новая</a>
                </div>';
    }

    /**
     * Кнопка выбора дня для сортировки в таблице
     */
    function btn_select_date(){
        return "<div class='input-group date' id='datetimepicker3'>
                    <input id='select_date' type='date' class='form-control' />
                </div>";
    }
    /**
     * Выбор сотрудника службы тех.поддержки
     */
    function btn_select_admin(){
        return "<div class=\"input-group\">
            <select id=\"select_id_admin\" name=\"id_admin\" class=\"form-select form-select-sm\" aria-label=\".form-select-sm example\">
                <option value=\"0\" selected>Все</option>
                <option value=\"1\">Иванов Николай</option>
                <option value=\"2\">Осипова Наталья</option>
                <option value=\"3\">Никитин Сергей</option>
            </select>
        </div>";
    }

    /**
     * Вывод данных ппо всем заявкам для супер админа
     */
    function get_super_admin_data(){
        /**
         * Header
         */
        $header = array(
            '#',
            'Пользователь',
            'Класс',
            'Тип',
            'Описание',
            'Ответственный',
            'Дата создания',
            'Дата завершения',
            'Статус'
        );
        $body = $this->get_body_all_users_order();
        return Class_Create_Simple_Table::html($header, $body);
    }

    /**
     * Получения всего списка заявок от всех пользователей
     * id_admin - если передан айди админа выборку делать только по этому админу
     */
    function get_body_all_users_order($id_admin = false){
        $obj = new Model_Orders(
            ['where' => 'users_id = '.(int)$this->id_user,
                "order" => 'dt DESC'
            ]);
        if(!$obj->num_row){
            return array(
                0 => array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        '1',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных'
                    )
                )
            );
        }
        $arr = array();
        $rows = $obj->getAllRows();
        /**
         * $arr[$row['id']]['class_tr'] - стили для раскраски строк в таблице
         *  table-success - выполнено,
         *  table-danger - просрочено,
         *  table-primary - принято,
         *  table-light - новая,
         *  table-warning - новая но не назначен ответственный и прошло 20 минут
         */
        foreach ($rows as $row){

            $arr[$row['id']]['class_tr'] = $this->statusOrder($row['status'], $row['dt']);
            $arr[$row['id']]['tds'] = array(
                $row['id'],
                'Пользователь',
                'Класс',
                'Тип',
                'Описание',
                'Ответственный',
                'Дата создания',
                'Дата завершения',
                'Статус'
            );
        }

        return $arr;
    }

    /**
     * Для раскрашивание с
     * @param $status - имя класса в стилях
     * @param $dt - время создания заявки
     * @return string - возвращаем имя класса CSS
     */
    function statusOrder($status, $dt){
        switch ($status){
            case 0:
                $now = time();
                if(strtotime($dt) < $now+20*60){
                    $status = 'table-light';
                }else{
                    $status = 'table-warning';
                }
                break;
            case 1:
                $now = time();
                if(strtotime($dt) < $now+60*60){
                    $status = 'table-primary';
                }else{
                    $status = 'table-danger';
                }
                break;
            case 2:
                $status = 'table-success';
                break;
            default:
                $status = '';
                break;
        }
        return $status;
    }
}