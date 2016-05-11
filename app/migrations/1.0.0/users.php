<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class UsersMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'users',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 1,
                        'first' => true
                    )
                ),
                new Column(
                    'username',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'password',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'username'
                    )
                ),
                new Column(
                    'email',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'password'
                    )
                ),
                new Column(
                    'token',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'email'
                    )
                ),
                new Column(
                    'valid',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'token'
                    )
                ),
                new Column(
                    'created',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'valid'
                    )
                ),
                new Column(
                    'deleted',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 1,
                        'after' => 'created'
                    )
                )
            ),
            'indexes' => array(
                new Index('sqlite_autoindex_users_3', array('email')),
                new Index('sqlite_autoindex_users_2', array('username')),
                new Index('sqlite_autoindex_users_1', array('id'))
            ),        )
        );
    }
}
