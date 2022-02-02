<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInterestedTable extends AbstractMigration
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
        $table = $this->table('interested');
        $table
            ->addColumn('person_id', 'integer')
            ->addColumn('eletronic_part_id', 'integer')
            ->addForeignKey('person_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('eletronic_part_id', 'eletronic_part', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
