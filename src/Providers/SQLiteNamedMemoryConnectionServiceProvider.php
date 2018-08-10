<?php
/**
 * Created by IntelliJ IDEA.
 * User: matsui
 * Date: 2018/08/09
 * Time: 13:44
 */

namespace Crhg\SQLiteNamedMemoryConnection\Providers;


use Crhg\SQLiteNamedMemoryConnection\Database\Connectors\SQLiteConnector;
use Illuminate\Support\ServiceProvider;

class SQLiteNamedMemoryConnectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('db.connector.sqlite', SQLiteConnector::class);
    }

}