<?php
/**
 * Created by IntelliJ IDEA.
 * User: matsui
 * Date: 2018/08/09
 * Time: 13:44
 */

namespace Crhg\SQLiteNamedMemoryConnection\Providers;


use Crhg\SQLiteNamedMemoryConnection\Database\Connectors\SQLiteConnector;
use Crhg\SQLiteNamedMemoryConnection\Database\SQLiteConnection;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class SQLiteNamedMemoryConnectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('db.connector.sqlite-named', SQLiteConnector::class);

        Connection::resolverFor('sqlite-named', static function ($connection, $database, $prefix, $config) {
            return new SQLiteConnection($connection, $database, $prefix, $config);
        });
    }
}