# 説明

LaravelのSQLiteConnectorを拡張し、`:named-memory:<name>`という形式のデータベース指定を導入します。
(`<name>`は任意の文字列(空文字列を含む))

これは`:memory:`と同様にSQLiteのインメモリデータベースに接続しますが、`:memory:`が接続のたびに
新たなデータベースを作成するのに対し、`:named-memory:<name>`は`<name>`が同じならば
同じ接続を返します。

# インストール

```shell
composer require crhg/laravel-sqlite-named-memory-connection
```

# 背景

データベースを使用したphpunitによるテストを高速化するのに、SQLiteのインメモリデータベースを使用することは有効です。
しかし`refreshApplication()`を使うとその後にデータベースが空になってしまう問題がありました。

これは以下の理由によります。

* IoCコンテナが再生成されるためにsingletonとして登録されていた`\Illuminate\Database\DatabaseManager`
が新しくなってしまう
* `DatabaseManager`が管理していた接続済みのデータベースの情報は新しく生成された`DatabaseManager`にはひきつがれない
* `refreshApplication()`以後はじめてDBへの接続が要求されたとき、`:memory:`に対しての新たな接続が生成される
* `:memory:`への接続は新たな空のインメモリデータベースへの接続である

`:memory:`のかわりに`:named-memory:<name>`を使用すれば`refreshApplication()`後の接続要求に対してその前に使っていた
同じ名前の接続を返すので、この問題を回避することができます。