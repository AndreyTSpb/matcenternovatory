<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 14:20
 */

/**
 * Базовый класс для рабты с MYSQL
 */
class Mysql {
    /**
     * Константы
     */
    protected $db; //Сюда отправляем подключение объект к БД
    protected $table; //Таблица
    private   $dataResult; // сюда результат выборки
    public    $num_row; //Сколько вернулось строк
    public    $id_row;


    public function fieldsTable() {
        /**
         * массив с полями таблицы
         * перекроим дочерним классом
         */
    }

    function profile_mysql_query($sql)
    {
        global $link;
        global $global_sql_profile_html;
        global $global_sql_summ_time;

        $time_start = microtime(true);
        $res = $link->query($sql);
        $time_end = microtime(true);
        $delta = round($time_end - $time_start, 6);
        //$delta = $time_end - $time_start;
        $global_sql_profile_html .= "$delta сек. - $sql | ";

        return $res;
    }

    public function __construct($select = false) {
        /**
         * глобальный подключение к БД
         */
        global $link;
        $this->db = $link;
        /**
         * Имя таблицы получаем из названия класса
         * Имеется введу класс наследник
         */
        $modelName   = get_class($this);
        $arrExp      = explode('_', $modelName);
        unset($arrExp[0]); //удаляем првый элемент изстроки
        $name        = implode('_', $arrExp);
        $tableName   = strtolower($name); //получили название таблицы
        $this->table = $tableName;
        //echo $this->table;
        /**
         * обработка запроса
         * Отсылает к запросу ниже
         * если вернется строка,
         * то запрос выполнять
         */
        if(!empty($select)){
            //print_r($select);
            $sql = $this->_getSelect($select);
            //echo $sql; exit;
            if($sql){
                $this->dataResult = $this->_getResult("SELECT * FROM " .$this->table . $sql);
            }
        }
    }

    /**
     * Получаем имя таблицы
     * (для отображния где нибуть)
     * возвращает в объект класса имя таблицы
     */
    public function getTableName(){
        return $this->table;
    }
    /**
     * Получить все записи
     * (Отображает в объекте)
     * Если в переменной результат есть данные то вернуть эту переменную.
     */
    public function getAllRows(){
        if(!isset($this->dataResult) OR empty($this->dataResult)) return FALSE;
        //print_r($this->dataResult); exit;
        return $this->dataResult;
    }
    /*получить одну запись*/
    public function getOneRow() {
        if(!isset($this->dataResult) OR empty($this->dataResult)) return FALSE;
        return $this->dataResult[0];
    }
    /*Получить запись по ID*/
    public function getRowById($id) {
        try{
            $id = (int)$id;
            $db = $this->db;
            $r = $this->profile_mysql_query("SELECT * FROM ". $this->table ." WHERE id = '" .$id. "'");
            $m = $r->fetch_assoc();
        } catch (Exception $e){
//            echo $e->getMessage();
//            exit;
        }
        return $m;
    }
    /**
     * Извлеч из выборки dateResult одну запись,
     * И заполнить значениями переменные которые отвечают за поля таблицы.
     * $this->{$key} = $val;
     * $this->{$key} - значение ключа использовать как переменную.
     */
    public function fetchOne() {

        if(!isset($this->dataResult) OR empty($this->dataResult)) return FALSE;
        foreach ($this->dataResult[0] as $key => $val) {
            $this->{$key} = $val;
        }
        return true;
    }
    /**
     * Сохранение записи в Базу Данных
     */
    // запись в базу данных
    public function save() {
        global $dbObject;
        $arrayAllFields = array_keys($this->fieldsTable());
        $arraySetFields = array();
        $arrayData = array();
        foreach($arrayAllFields as $field){
            if(!empty($this->$field)){
                $arraySetFields[] = $field;
                $arrayData[] = $this->$field;
            }
        }
        $forQueryFields =  implode(', ', $arraySetFields);
        $rangePlace = array_fill(0, count($arraySetFields), '?');
        $forQueryPlace = implode(', ', $rangePlace);
        try {
            $stmt = $dbObject->prepare("INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)");
            $stmt->execute($arrayData);
            $id = $dbObject->lastInsertId();
        }catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            echo "<br/>Error sql : INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)";
            exit();
        }

        return $id;
    }
    /**
     * Модуль составления условия запроса к бд
     */
    private function _getSelect($select) {
        if(is_array($select)){
            $allQuery1 = array_keys($select);
            /**
             * Применяем свою функцию к каждому элемнту массива
             */
//            array_walk($allQuery, function(&$val){
//                echo $val = strtoupper($val); //Все к верхнему регистру
//            });
            $allQuery = array();
            foreach ($allQuery1 as $val){
                $allQuery[] = strtoupper($val);
            }
            /**
             * начинаем поиск в моссиве ключевых слов
             * WHERE, ORDER, IN итд.
             * чтоб можно было построить условие к запросу
             */
            $querySql = '';
            if(in_array("WHERE", $allQuery)){
                foreach ($select as $key=> $val){
                    if(strtoupper($key) == "WHERE"){
                        $querySql .= " WHERE " . $val;
                    }
                }
            }
            if(in_array("GROUP", $allQuery)){
                foreach ($select as $key=> $val){
                    if(strtoupper($key) == "GROUP"){
                        $querySql .= " GROUP BY " . $val;
                    }
                }
            }
            if(in_array("ORDER", $allQuery)){
                foreach ($select as $key=> $val){
                    if(strtoupper($key) == "ORDER"){
                        $querySql .= " ORDER BY " . $val;
                    }
                }
            }
            if(in_array("LIMIT", $allQuery)){
                foreach ($select as $key=> $val){
                    if(strtoupper($key) == "LIMIT"){
                        $querySql .= " LIMIT " . $val;
                    }
                }
            }
            if(in_array("OFFSET", $allQuery)){
                foreach ($select as $key=> $val){
                    if(strtoupper($key) == "OFFSET"){
                        $querySql .= " OFFSET " . $val;
                    }
                }
            }
            return $querySql;
        }
        return FALSE;
    }
    /*
     * Выполнение запроса к БД,
     * Метод закрытый
     */
    private function _getResult($sql) {
        try{
            $db = $this->db;
            $r=$this->profile_mysql_query($sql);
            //$r = $this->profile_mysql_query_counter($sql);
            //echo $sql;
            if(!empty($r->num_rows)) $this->num_row = $r->num_rows; //echo "<p>";
            if($r) $m = $r->fetch_all(3); //MYSQLI_BOTH
            else $m = FALSE;
        } catch (Exception $e) {
//            echo 'Error: '.$e->getMessage();
//            exit;
        }
        return $m;
    }
    /**
     * Показать результат
     */
    public function show_result(){
        return $this->dataResult;
    }

    /**
     * удаление из БД по условию
     */
    public function deleteBySelect($select) {
        $sql = $this->_getSelect($select);
        try{
            $db = $this->db;
            $r = $this->profile_mysql_query("DELETE FROM " . $this->table ." ".$sql);
        } catch (Exception $e) {
//            echo 'Error: '. $e->getMessage();
//            echo "<b> Error sql:  DELETE FROM " . $this->table ." ".$sql;
//            exit;
        }
        return $r;
    }
    /**
     * удаление строки по ее id
     */
    public function deleteRow($id){
        /**
         * Проверка есть ли в данной таблице поле ID
         */
        $arrayAllField = array_keys($this->fieldsTable());
        array_walk($arrayAllField, function(&$val){
            $val = strtoupper($val);
        });
        if(in_array('ID', $arrayAllField)){
            /*Если есть ID удаляем*/
            try{
                $db = $this->db;
                $r = $this->profile_mysql_query("DELETE FROM ".$this->table." WHERE id = '".$id."'");
            } catch (Exception $e) {
//                echo 'Error: '. $e->getMessage();
                exit;
            }
        }else{
            echo "ID table ".$this->table." not found!!!";
            exit;
        }
        return $r;
    }
    /**
     * обновление записи по ID
     */
    public function update() {
        /**
         * Проверка есть ли в данной таблице поле ID
         */
        $arrayAllField = array_keys($this->fieldsTable()); // масив с полями таблицы
        $arrayForSet = array(); //массив для параметров которые меняем
        foreach ($arrayAllField as $field){
            if(isset($this->{$field})){
                if(strtoupper($field) != 'ID'){
                    $arrayForSet[] = $field . " = '" . $this->{$field} . "'";
                }
                $whereId = $this->dataResult[0][0];
            }
        }
        /**
         * Проверка заполнениых массивов с полями и значениями таблицы
         */
        if(!isset($arrayForSet) OR empty($arrayForSet)){
            echo " Array data table " .$this->table. " not found";
            exit;
        }
        if(!isset($whereId) OR empty($whereId)){
            echo "ID table ".$this->table." not found";
            exit;
        }
        /**
         * в строку превращаем массив с параметрами
         */
        $strForSet = implode(', ', $arrayForSet);

        try{
            $sql = "UPDATE ".$this->table." SET ".$strForSet." WHERE id = '".$whereId."'";
            $db = $this->db;
            $r = $this->profile_mysql_query($sql);
        } catch (Exception $e) {
            echo 'Error: '. $e->getMessage();
            echo '<b> Error sql: '. "UPDATE ".$this->table." SET ".$strForSet." WHERE id = '".$whereId."'";
            exit;
        }
        return $r;
    }
    /**
     * Надо сделать UPDATE через условие.
     *
     */
    public function updateQuery($select) {
        $strQuery = $this->_getSelect($select);
        /**
         * Проверка есть ли в данной таблице поле ID
         */
        $arrayAllField = array_keys($this->fieldsTable()); // масив с полями таблицы
        $arrayForSet = array(); //массив для параметров которые меняем
        foreach ($arrayAllField as $field){
            if(isset($this->$field)){
                if(strtoupper($field) != 'ID'){
                    $arrayForSet[] = $field . " = '" . $this->$field . "'";
                }
            }
        }
        /**
         * Проверка заполнениых массивов с полями и значениями таблицы
         */
        if(!isset($arrayForSet) OR empty($arrayForSet)){
            echo " Array data table " .$this->table. " not found";
            exit;
        }
        /**
         * в строку превращаем массив с параметрами
         */
        $strForSet = implode(', ', $arrayForSet);
        try{
            $sql = "UPDATE ".$this->table." SET ".$strForSet." ".$strQuery."";
            $db = $this->db;
            $r = $this->profile_mysql_query($sql);
        } catch (Exception $e) {
            echo 'Error: '. $e->getMessage();
            echo "<b> Error sql: UPDATE ".$this->table." SET ".$strForSet." ".$strQuery;
            exit;
        }
        return $r;
    }
    /**
     * Количество строк в
     */
}
