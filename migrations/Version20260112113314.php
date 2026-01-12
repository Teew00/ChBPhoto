<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260112113314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY `FK_8A8E26E979F37AE5`');
        $this->addSql('ALTER TABLE conversation CHANGE id_user_id id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E979F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY `FK_B6BD307F79F37AE5`');
        $this->addSql('ALTER TABLE message CHANGE id_user_id id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user CHANGE telephone telephone VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E979F37AE5');
        $this->addSql('ALTER TABLE conversation CHANGE id_user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT `FK_8A8E26E979F37AE5` FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79F37AE5');
        $this->addSql('ALTER TABLE message CHANGE id_user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT `FK_B6BD307F79F37AE5` FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE `user` CHANGE telephone telephone VARCHAR(10) DEFAULT \'NULL\'');
    }
}
