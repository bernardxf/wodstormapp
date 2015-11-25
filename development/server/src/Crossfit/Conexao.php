<?php
namespace Crossfit;

use Silex\Application;

class Conexao
{

    private static $app;

    public static function init(Application $app)
    {
        self::$app = $app;
    }

    /**
     * @static
     *
     * @return \Doctrine\DBAL\Connection
     */
    public static function get()
    {
        return self::$app['db'];
    }
}