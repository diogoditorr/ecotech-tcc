<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOrderTable extends AbstractMigration
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
        $table = $this->table('order', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'string', ['limit' => 8])
            ->addColumn('eletronic_part_id', 'integer')
            ->addColumn('donor_id', 'integer')
            ->addColumn('receiver_id', 'integer')
            ->addColumn('status', 'string', ['length' => 9, 'default' => 'pendente'])
            ->addForeignKey('eletronic_part_id', 'eletronic_part', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('donor_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('receiver_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addTimestampsWithTimezone()
            ->create();
    }
}
