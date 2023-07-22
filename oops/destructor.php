<html>

<body>
    <h1>class</h1>


    <?php
    class Fruit
    {
        public $name;
        public $color;

        function __construct($name,$color)
        {
            $this->name = $name;
            $this->color = $color;
        }

        function __destruct()
        {
            echo "the name is {$this->name} and color is {$this->color}";
        }
    }
    $apple = new Fruit('apple','red');
    ?>
</body>

</html>