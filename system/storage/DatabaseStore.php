<?php namespace igniteStack\System\Storage;

use igniteStack\System\ErrorHandling\Exception;


class DatabaseStore
{
    public function __call($a, $b)
    {
        //die($a);
    }

    final public function engine ()
    {
        $config = '../config/Datasource/mysql.php';

        if(!file_exists($config))
            Exception::cast ('DatasourceConfigIO', 500);

        include($config);

        $_HOST = $_MYSQL['host'];
        $_DB = $_MYSQL['database'];
        $_USERNAME = $_MYSQL['username'];
        $_PASSWORD = $_MYSQL['password'];
        $_CHARSET = $_MYSQL['charset'];

        try {
            $dbc = new \PDO("mysql:host=$_HOST;dbname=$_DB;charset=$_CHARSET", $_USERNAME, $_PASSWORD,
                array(
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                )
            );

            $dbc->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

            return $dbc;

        } catch( \PDOException $Exception ) {
            Exception::cast ($Exception->getMessage(), 500);
        }
    }

    final public function init ()
    {
        $this->query = array();

        // TODO: Implement the model loading service
    }

    final public function query ($q)
    {
        // Make a DB Connection
        $engine = $this-> engine();
        try {

            // Run the query
            $r = $engine->query($q)->fetch();

            // Close connection
            $engine = null;

            // Return results
            return $r;

        } catch( \PDOException $Exception )
        {
            die($Exception->getMessage());
        }
    }

    final public function save ($m)
    {
        // TODO: Implement to use query in session, then persist
    }

    final protected function setQuery($m, $q)
    {
        self::$query[$m] = $q;
    }

} 