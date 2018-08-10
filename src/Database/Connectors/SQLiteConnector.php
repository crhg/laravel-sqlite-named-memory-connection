<?php
/**
 * Created by IntelliJ IDEA.
 * User: matsui
 * Date: 2018/08/09
 * Time: 13:27
 */

namespace Crhg\SQLiteNamedMemoryConnection\Database\Connectors;


class SQLiteConnector extends \Illuminate\Database\Connectors\SQLiteConnector
{
    /** @var \PDO[] named in-memory database connections */
    protected static $named_connections = [];

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
        if (preg_match('/\A:named-memory:(.*)\z/', $config['database'] ?? '', $matches)) {
            $name = $matches[1];
            if (!isset(self::$named_connections[$name])) {
                $options = $this->getOptions($config);
                self::$named_connections[$name] = $this->createConnection('sqlite::memory:', $config, $options);
            }

            return self::$named_connections[$name];
        }

        return parent::connect($config);
    }
}