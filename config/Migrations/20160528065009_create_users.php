<?php

use Phinx\Migration\AbstractMigration;

class CreateUsers extends AbstractMigration {

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {
        // create table
        $table = $this->table('users', [
            'id' => false,
            'primary_key' => ['id']
        ]);

        // add colums
        $table->addColumn('id', 'integer', [
            'signed' => false,
            'identity' => true
        ])->addColumn('username', 'string', [
            'default' => null,
            'length' => 32,
            'null' => false
        ])->addColumn('password', 'string', [
            'default' => null,
            'length' => 32,
            'null' => false
        ])->addColumn('email', 'string', [
            'default' => null,
            'length' => 32,
            'null' => true
        ])->addColumn('address', 'string', [
            'default' => null,
            'length' => 256,
            'null' => true
        ])->addColumn('gender', 'string', [
            'default' => 'Male',
            'length' => '10'
        ])->addColumn('phone', 'string', [
            'default' => null,
            'length' => 13,
            'null' => true
        ])->addColumn('fullname', 'string', [
            'default' => null,
            'length' => 256,
            'null' => true
        ])->addColumn('ip_address', 'string', [
            'default' => null,
            'length' => 15,
            'null' => true
        ])->addColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'length' => 256,
            'null' => false
        ])->addColumn('modified', 'datetime', [
            'default' => null,
            'length' => 256,
            'null' => false
        ])->addColumn('role_id', 'integer', [
            'signed' => false,
            'default' => null,
            'length' => 11,
            'null' => true
        ]);

        // add constraint
        $table->addIndex('username', [
            'unique' => true
        ]);

        // add foreign key
        $table->addForeignKey('role_id', 'roles', 'id');

        // table execute
        $table->create();
    }

}
