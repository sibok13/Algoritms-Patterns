<?php
class Config
{
    public static $db_type = 1;
}

interface DbInterface
{
    public function DBConnection();
}

abstract class AbstractDb
{
    public static function getFactory()
    {
        switch (Config::$db_type) {
            case 1:
                return new MySQLFactory();
            case 2:
                return new PostgreSQLFactory();
            case 3:
                return new OracleFactory();
        }
    }

    abstract public function getDbInterface();
}

class MySQLFactory extends AbstractDb
{
    public function getDbInterface()
    {
        return new SQLInterface();
    }
}

class SQLInterface implements DbInterface
{
    public function DBConnection()
    {
        return 'DBConnection';
    }

    public function DBRecrord()
    {
        return 'DBRecrord';
    }

    public function DBQueryBuiler()
    {
        return 'DBQueryBuiler';
    }
}

class PostgreSQLFactory extends AbstractDb
{
    public function getDbInterface()
    {
        return new PostgreInterface();
    }
}

class PostgreInterface implements DbInterface
{
    public function DBConnection()
    {
        return 'DBConnection';
    }

    public function DBRecrord()
    {
        return 'DBRecrord';
    }

    public function DBQueryBuiler()
    {
        return 'DBQueryBuiler';
    }
}

class OracleFactory extends AbstractDb
{
    public function getDbInterface()
    {
        return new OracleInterface();
    }
}

class OracleInterface implements DbInterface
{
    public function DBConnection()
    {
        return 'DBConnection';
    }

    public function DBRecrord()
    {
        return 'DBRecrord';
    }

    public function DBQueryBuiler()
    {
        return 'DBQueryBuiler';
    }
}

$SQLInterface = AbstractDb::getFactory()->getDbInterface();
Config::$db_type = 2;
$PostgreInterface = AbstractDb::getFactory()->getDbInterface();

print_r($SQLInterface->DBConnection());
print_r($PostgreInterface->DBConnection());