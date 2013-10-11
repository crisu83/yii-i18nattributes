<?php

class m130927_130245_create_i18n_attribute_table extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `i18n_attribute` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `locale` VARCHAR(255) NOT NULL,
                `modelClass` VARCHAR(255) NOT NULL,
                `modelId` INT UNSIGNED NOT NULL,
                `attribute` VARCHAR(255) NOT NULL,
                `text` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) COLLATE='utf8_general_ci' ENGINE=InnoDB;"
        );
    }

    public function down()
    {
        $this->dropTable('i18n_attribute');
    }
}