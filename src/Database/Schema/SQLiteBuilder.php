<?php

declare(strict_types=1);


namespace Crhg\SQLiteNamedMemoryConnection\Database\Schema;

use Illuminate\Support\Str;

class SQLiteBuilder extends \Illuminate\Database\Schema\SQLiteBuilder
{
    public function dropAllTables()
    {
        $name = $this->connection->getDatabaseName();

        if (Str::startsWith($this->connection->getDatabaseName(), ':named-memory:')) {
            $this->connection->refreshNamedInMemoryConnection($name);
            return;
        }

        parent::dropAllTables();
    }
}