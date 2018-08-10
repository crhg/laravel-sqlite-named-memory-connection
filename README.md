# DESCRIPTION

This package extends Laravel's SQLiteConnector and introduces a database specification of the form `:named-memory:<name>`.
(`<name>` is an arbitrary string (including empty string))

It connects to SQLite's in-memory database as well as `:memory:`.
`:memory:` creates a new database for each connection, whereas `:named-memory:<name>` returns the same connection　
if `<name>` is same.

# INSTALL

```shell
composer require crhg/laravel-sqlite-named-memory-connection
```

# BACKGROUND

SQLite's in-memory database is effective to speed up tests using the database.
However, using `refreshApplication()` caused the problem of emptying the database.

This is due to the following reasons.

* Since the IoC container is regenerated, `\Illuminate\Database\DatabaseManager` that was registered as singleton is discarded and replaced with a new one.
* Information on the connected database managed by `DatabaseManager` is not passed to the newly generated` DatabaseManager`.
* When a connection to the DB is requested for the first time after `refreshApplication()`, the DatabaseManager has no connection, so a new connection to `:memory:` is generated
* The connection to `:memory:` is a connection to a newly created empty in-memory database.

If you use `:named-memory:<name>` instead of `:memory:`, 
this problem can be avoided by returning the connection identified by `<name>`
which was used before `refreshApplication ()`.
