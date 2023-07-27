<html>

<body>
    <h1>class</h1>


    <?php
    class User
    {
        protected $email;
        private $name;
        public $role = "member";
        public function __construct($email, $name)
        {
            //    echo $this->email = $email;
            //   echo  $this->name = $name;
            $this->email = $email;
            $this->name = $name;
        }
        public function login($msg)
        {
            // echo "you logged in successfully";
            echo $msg;
        }
        public function message()
        {
             return "$this->email you logged in successfully";
        }
        // getters
        public function getUser()
        {
            return  $this->email;
        }
        public function setUser($email)
        {
            return $this->email = $email;
        }
    }
    class AdminUser extends User
    {
        public $level;
        public $role = "admin";
        public function __construct($email, $name, $level)
        {
            $this->level = $level;
            parent::__construct($email, $name);
        }
        public function message()
        {
             return "$this->email, an admin,sent new message";
        }
    }
     $loginOne = new User("manikanta@gmail.com", "manikanta");
    // $loginOne->login("you logged in successfully");
    // echo $loginOne->name;
    // echo $loginOne->email."</br>";

    // $loginTwo = new User("king@gmail.com", "king");
    // echo $loginTwo->name;
    // echo $loginTwo->email."</br>";
    // echo  $loginOne->getUser();
    // echo  $loginOne->setUser("manikanta@gmail.com");
    $loginThree = new AdminUser("virat@gmail.com", "virat", 5);
    echo $loginThree->getUser();
    echo $loginThree->level;
    echo $loginOne->role."</br>";
    echo $loginThree->role;
    echo $loginOne->message()."</br>";
    echo $loginThree->message()."</br>";
    ?>
</body>

</html>