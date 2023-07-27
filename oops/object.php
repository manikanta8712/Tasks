<html>

<body>
    <h1>class</h1>
    <?php
   class Weather{
    public static $tempcondition = ['cold','mild','warm'];

    public static function celsisToFarenheit($c){
        return $c*9/5+32;
    }
    public static function determineTempCondition($f){
        if($f < 40){
            return self::$tempcondition[0];
        }
       else if($f < 70){
            return self::$tempcondition[1];
        }
        else{
            return self::$tempcondition[2];
        }
    }
   }
   //$condition = new Weather();
   //print_r($condition);
   print_r(Weather::$tempcondition);
   echo Weather::celsisToFarenheit(20);
   echo Weather::determineTempCondition(20);
    ?>
</body>

</html>