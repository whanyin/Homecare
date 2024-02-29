<?php
/*
Design a class that can connect to the MySQL database as soon as it is instantiated!
Of course, when instantiating, you need to pass the basic information to connect to the database:
Server address, port, user name, password, connection encoding, database name to be used;
Expansion requirements:
The instantiated object can also:
1. Set the encoding to be used individually.
2, and individually select the database to use!

Continue to expand demand:
6. There is a method that can execute the "add, delete, modify" statement and return the number of affected rows.

7. There is a method that can execute the select statement "return a row of data" and get a one-dimensional array;
For example: select * from XXX where id = 5;

8. There is a method that can execute the select statement of "returning multiple rows of data" and get a two-dimensional array;
For example: select * from XXX where id > 5 and id < 10;

9. There is a method that can execute a select statement that "returns a data" and obtains a "scalar value";
For example: select count(*) as c from XXX;
*/

class MySQLDB{
    //Used to save resources after successful connection    
    private $link;

    private $host ;	//Define some properties to save connection information   
     private $port ;
    private $user ;
    private $pass ;
    private $charset ;
    private $dbname ;

    //Step 1: Privatize the constructor：
    private function __construct($conf){
        //Save the passed connection information to the corresponding attributes and consider the default value.
        $this->host = !empty($conf['host']) ? $conf['host'] : "localhost";
        $this->port = !empty($conf['port']) ? $conf['port'] : 3306;
        $this->user = !empty($conf['user']) ? $conf['user'] : "root";
        $this->pass = !empty($conf['pass']) ? $conf['pass'] : "123456";
        $this->charset = !empty($conf['charset']) ? $conf['charset'] : "utf8";
        $this->dbname = !empty($conf['dbname']) ? $conf['dbname'] : "php";

        //establish connection
        $this->connect();

    }
    //Step 2: Define a private static property：
    private  static $instance = null;
    //Step 3: Define a public static method to return the object based on certain logic：
    static  function GetDB( $conf ){
        //if(  empty( static::$instance)  ){//改The following judgment logic is
        if( (static::$instance instanceOf static)  === false){
            static::$instance  =  new  static( $conf );
        }
        return  static::$instance;
    }
    //第Step 4: The magic method of privatizing cloning to disable outside cloning：
    private function __clone(){}


    function setCharset($char){
        //mysql_query("set names $char", $this->link);
        //Replace the previous line with the following line
        $this->query("set names $char");
    }
    function use_db( $db ){
        //mysql_query("use $db", $this->link);
        //Replace the previous line with the following line
                $this->query("use $db");
    }
    function close_db(){

        mysqli_close($this->link);
    }

    //This method is used to execute "add, delete, modify" statements：
    function exec( $sql ){
        $result = $this->query( $sql );

        return $this->affectedRow();

    }
    //This method is used to execute the select statement "return a row of data" and return a one-dimensional array：
    function  GetOneRow( $sql ){
        $result = $this->query( $sql );

        //The next step is naturally to process the data when successful.：
        $rec = mysqli_fetch_assoc( $result );//This is a one-dimensional array！
        //something like this：array('id'=>5, 'name'=>'张三', 'age'=>18);
        return $rec;

    }

    //This method is used to execute the select statement "returning multiple rows of data" and return a two-dimensional array：
    function  GetAllRow( $sql ){
        $result = $this->query( $sql );
        $rows = array();
        while($rec = mysqli_fetch_assoc( $result ) ){
            $rows[] = $rec;	//After this, $rows is a two-dimensional array.
        }
        return $rows;
    }
    //This method is used to execute the "return a data" select statement and return a scalar data value：
    function  GetOneData( $sql ){
        $result = $this->query( $sql );//Still a result set (resource)
        $rec = mysqli_fetch_row( $result );	//Take out the first row and make it into an index array
        $data = $rec[0];

        return $data;
    }

    private function query( $sql ){

        $result = mysqli_query($this->link, $sql);
        if($result === false){
            echo "<p>Database execution failed：";
            echo "<br />failure statement：" . $sql;
            echo "<br />Error code：" . mysqli_connect_errno();
            echo "<br />Error message：" . mysqli_connect_error();
            echo "</p>";
            die();	//Execution fails and terminates directly！
        }
        return $result;
    }
    //When serializing, we only need to serialize 6 pieces of data
        function __sleep(){

        return array("host","port","user","pass","charset","dbname");
    }

    //When deserializing, we need to use the data to successfully connect to the database
        function __wakeup(){
        //establish connection
        $this->connect();
    }

    //Complete the basic database connection operations necessary for object instantiation
        private function connect(){
        $this->link = mysqli_connect(
            "{$this->host}:{$this->port}",
            "{$this->user}",
            $this->pass
        );
        if (empty($this->link)) {
            die("Unable to connect to the database！");
        }
        $this->setCharset( $this->charset );
        $this->use_db( $this->dbname );
    }

    function affectedRow(){
        return mysqli_affected_rows($this->link);
    }

    //Get the self-increasing id value of the last insert
        function getInsertedId(){
        return mysqli_insert_id($this->link);
    }
}
