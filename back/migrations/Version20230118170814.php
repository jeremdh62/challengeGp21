<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118170814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Version 0 : All tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id UUID NOT NULL, created_by_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66B03A8386 ON article (created_by_id)');
        $this->addSql('COMMENT ON COLUMN article.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN article.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN article.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE clip (id UUID NOT NULL, uploaded_by_id UUID NOT NULL, path VARCHAR(255) NOT NULL, is_valid BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AD201467A2B28FE8 ON clip (uploaded_by_id)');
        $this->addSql('COMMENT ON COLUMN clip.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN clip.uploaded_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN clip.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE comment (id UUID NOT NULL, created_by_id UUID NOT NULL, forum_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CB03A8386 ON comment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_9474526C29CCBAD0 ON comment (forum_id)');
        $this->addSql('COMMENT ON COLUMN comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.forum_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE forum (id UUID NOT NULL, created_by_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, is_valid BOOLEAN NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_852BBECDB03A8386 ON forum (created_by_id)');
        $this->addSql('COMMENT ON COLUMN forum.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN forum.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN forum.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media (id UUID NOT NULL, owner_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10C7E3C61F9 ON media (owner_id)');
        $this->addSql('COMMENT ON COLUMN media.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN media.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE signaled_comment (id UUID NOT NULL, signaled_by_id UUID NOT NULL, signaled_user_id UUID NOT NULL, comment_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_693ABA496226B1BA ON signaled_comment (signaled_by_id)');
        $this->addSql('CREATE INDEX IDX_693ABA495A203BB0 ON signaled_comment (signaled_user_id)');
        $this->addSql('CREATE INDEX IDX_693ABA49F8697D13 ON signaled_comment (comment_id)');
        $this->addSql('COMMENT ON COLUMN signaled_comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.signaled_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.signaled_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN signaled_comment.comment_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tournament (id UUID NOT NULL, created_by_id UUID NOT NULL, max_players INT NOT NULL, is_free BOOLEAN NOT NULL, is_over BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, participation_deadline DATE NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD5FB8D9B03A8386 ON tournament (created_by_id)');
        $this->addSql('COMMENT ON COLUMN tournament.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.participation_deadline IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tournament.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tournament_user (tournament_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(tournament_id, user_id))');
        $this->addSql('CREATE INDEX IDX_BA1E647733D1A3E7 ON tournament_user (tournament_id)');
        $this->addSql('CREATE INDEX IDX_BA1E6477A76ED395 ON tournament_user (user_id)');
        $this->addSql('COMMENT ON COLUMN tournament_user.tournament_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tournament_user.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE clip ADD CONSTRAINT FK_AD201467A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT FK_693ABA496226B1BA FOREIGN KEY (signaled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT FK_693ABA495A203BB0 FOREIGN KEY (signaled_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE signaled_comment ADD CONSTRAINT FK_693ABA49F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D9B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT FK_BA1E647733D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT FK_BA1E6477A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66B03A8386');
        $this->addSql('ALTER TABLE clip DROP CONSTRAINT FK_AD201467A2B28FE8');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CB03A8386');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C29CCBAD0');
        $this->addSql('ALTER TABLE forum DROP CONSTRAINT FK_852BBECDB03A8386');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C7E3C61F9');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT FK_693ABA496226B1BA');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT FK_693ABA495A203BB0');
        $this->addSql('ALTER TABLE signaled_comment DROP CONSTRAINT FK_693ABA49F8697D13');
        $this->addSql('ALTER TABLE tournament DROP CONSTRAINT FK_BD5FB8D9B03A8386');
        $this->addSql('ALTER TABLE tournament_user DROP CONSTRAINT FK_BA1E647733D1A3E7');
        $this->addSql('ALTER TABLE tournament_user DROP CONSTRAINT FK_BA1E6477A76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE clip');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE signaled_comment');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE tournament_user');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
