<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProfileTable extends AbstractMigration
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
        $table = $this->table('profile');
        $table
            ->addColumn('person_id', 'integer')
            ->addColumn('cpf', 'string', ['limit' => 11])
            ->addColumn('email', 'string', ['limit' => 320])
            ->addColumn('user_name', 'string', ['limit' => 45])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addIndex(['person_id'], ['unique' => true])
            ->addIndex(['cpf'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->addForeignKey('person_id', 'person', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('cpf', 'person', 'cpf', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('email', 'person', 'email', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
