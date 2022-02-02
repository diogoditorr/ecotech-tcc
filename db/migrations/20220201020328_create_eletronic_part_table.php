<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEletronicPartTable extends AbstractMigration
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
        $table = $this->table('eletronic_part');
        $table
            ->addColumn('person_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('type', 'string', ['limit' => 255])
            ->addColumn('model', 'string', ['limit' => 255])
            ->addColumn('description', 'string', ['limit' => 765])
            ->addColumn('image_identifier', 'string', ['limit' => 512])
            ->addColumn('stock', 'integer', ['null' => true, 'default' => 0])
            ->addForeignKey('person_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
