<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePersonTable extends AbstractMigration
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
        $table = $this->table('person');
        $table
            ->addColumn('cpf', 'string', ['limit' => 11])
            ->addColumn('email', 'string', ['limit' => 320])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('school', 'string', ['limit' => 255])
            ->addColumn('phone_number_1', 'string', ['limit' => 20])
            ->addColumn('phone_number_2', 'string', ['limit' => 20])
            ->addIndex(['cpf'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->addTimestampsWithTimezone()
            ->create();
    }
}
