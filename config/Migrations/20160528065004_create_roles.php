<?php

use Phinx\Migration\AbstractMigration;

class CreateRoles extends AbstractMigration {

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
        $table = $this->table('roles', [
            'id' => false,
            'primary_key' => ['id']
        ]);

        // add columns
        $table->addColumn('id', 'integer', [
            'signed' => false,
            'identity' => true
        ])->addColumn('name', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ])->addColumn('fullname', 'string', [
            'default' => null,
            'limit' => 256,
            'null' => false
        ])->addColumn('description', 'string', [
            'default' => null,
            'limit' => 256,
            'null' => false
        ])->addColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false
        ])->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false
        ]);

        // add index
        $table->addIndex('name', [
            'unique' => true
        ]);

        // execute
        $table->create();
    }
    
    /**
     * 
     */
    public function up(){
        
    }

}
