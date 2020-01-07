<?php
/**
 * Created by IntelliJ IDEA.
 * User: matsui
 * Date: 2018/08/09
 * Time: 13:27
 */

namespace Crhg\SQLiteNamedMemoryConnection\Database\Connectors;


use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Void_;

class SQLiteConnector extends \Illuminate\Database\Connectors\SQLiteConnector
{
    /** @var \PDO[] named in-memory database connections */
    protected static $named_connections = [];

    /** @var array to store $config parametar for named connections */
    protected static $config = [];

    /**
     * Establish a database connection.
     *
     *
     * @param  array  $config
     * @return \PDO
     *
     * @throws \InvalidArgumentException
     */
    public function connect(array $config): \PDO
    {
        $name = $config['database'] ?? '';
        if (Str::startsWith($name, ':named-memory:')) {
            if (!isset(self::$named_connections[$name])) {
                self::$config[$name] = $config;
                $this->refreshNamedInMemoryConnection($name);
            }

            return self::$named_connections[$name];
        }

        return parent::connect($config);
    }

    public function refreshNamedInMemoryConnection($name)
    {
        $config = self::$config[$name];
        $options = $this->getOptions($config);
        self::$named_connections[$name] = $this->createConnection('sqlite::memory:', $config, $options);
    }
}