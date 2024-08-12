<?php


namespace install;


class CreateModelDbFiles{
    private $tableName;
    private $link;
    private $arrFields;
    private $fileName;
    private $pathToModels = 'apps/models';

    function __construct($tableName, $link, $arrFields)
    {
        if (!file_exists($this->pathToModels)) {
            echo "Папки ".$this->pathToModels." не нашли ";
            exit();
        }

        $this->tableName = strtolower($tableName);
        $this->link = $link;
        $this->arrFields = $arrFields;
        $this->fileName =   "model_".$this->tableName.".php";
        $this->createFile();
    }

    private function createFile(){
        $strProp = "";
        $strArr = "";
        foreach ($this->arrFields AS $field){
            $strProp .=  "      public $" . $field . "; \n";
            $strArr .= "            '" . $field . "' => '" . $field . "',\n";
        }

        $text = "<?php ".
            "class Model_".ucfirst($this->tableName)." extends Mysql\n".
            "{\n". $strProp ."\n".
            "   public function fieldsTable() {\n".
            "        return array(\n".
            $strArr.
            "        );\n".
            "    }\n".
            "}";
        file_put_contents($this->pathToModels."/".$this->fileName, $text);
    }

}