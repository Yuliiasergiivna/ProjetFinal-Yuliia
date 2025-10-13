<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013073402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attraction (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, route VARCHAR(255) DEFAULT NULL, latitude NUMERIC(10, 7) DEFAULT NULL, longitude NUMERIC(10, 7) DEFAULT NULL, INDEX IDX_D503E6B812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_9474526CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_comment_likes (comment_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_EDE7BDCF8697D13 (comment_id), INDEX IDX_EDE7BDCFB88E14F (utilisateur_id), PRIMARY KEY(comment_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, attraction_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_68C58ED93C216F9D (attraction_id), INDEX IDX_68C58ED9FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, attraction_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_upload DATE NOT NULL, url VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_14B784183C216F9D (attraction_id), INDEX IDX_14B78418FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_2C42079FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route_attraction (id INT AUTO_INCREMENT NOT NULL, attraction_id INT DEFAULT NULL, route_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_DB742C5F3C216F9D (attraction_id), INDEX IDX_DB742C5F34ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_attraction (utilisateur_id INT NOT NULL, attraction_id INT NOT NULL, INDEX IDX_E7BB24AEFB88E14F (utilisateur_id), INDEX IDX_E7BB24AE3C216F9D (attraction_id), PRIMARY KEY(utilisateur_id, attraction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attraction ADD CONSTRAINT FK_D503E6B812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE user_comment_likes ADD CONSTRAINT FK_EDE7BDCF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_comment_likes ADD CONSTRAINT FK_EDE7BDCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED93C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784183C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE route_attraction ADD CONSTRAINT FK_DB742C5F3C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id)');
        $this->addSql('ALTER TABLE route_attraction ADD CONSTRAINT FK_DB742C5F34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('ALTER TABLE utilisateur_attraction ADD CONSTRAINT FK_E7BB24AEFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_attraction ADD CONSTRAINT FK_E7BB24AE3C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attraction DROP FOREIGN KEY FK_D503E6B812469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFB88E14F');
        $this->addSql('ALTER TABLE user_comment_likes DROP FOREIGN KEY FK_EDE7BDCF8697D13');
        $this->addSql('ALTER TABLE user_comment_likes DROP FOREIGN KEY FK_EDE7BDCFB88E14F');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED93C216F9D');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9FB88E14F');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784183C216F9D');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418FB88E14F');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079FB88E14F');
        $this->addSql('ALTER TABLE route_attraction DROP FOREIGN KEY FK_DB742C5F3C216F9D');
        $this->addSql('ALTER TABLE route_attraction DROP FOREIGN KEY FK_DB742C5F34ECB4E6');
        $this->addSql('ALTER TABLE utilisateur_attraction DROP FOREIGN KEY FK_E7BB24AEFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_attraction DROP FOREIGN KEY FK_E7BB24AE3C216F9D');
        $this->addSql('DROP TABLE attraction');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE user_comment_likes');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE route_attraction');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_attraction');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
