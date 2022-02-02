<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAddressTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('address');
        $table
            ->addColumn('person_id', 'integer')
            ->addColumn('address', 'string', ['limit' => 255])
            ->addColumn('city', 'string', ['limit' => 255])
            ->addColumn('state', 'string', ['limit' => 255])
            ->addColumn('district', 'string', ['limit' => 255])
            ->addColumn('zip_code', 'string', ['limit' => 15])
            ->addIndex(['person_id'], ['unique' => true])
            ->addForeignKey('person_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
