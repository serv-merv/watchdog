<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170516171825 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE OR REPLACE FUNCTION public.geodistance(alat double precision, alng double precision, blat double precision, blng double precision)
                              RETURNS double precision AS
                            $BODY$
                            SELECT asin(
                                       sqrt(
                                           sin(radians($3-$1)/2)^2 +
                                           sin(radians($4-$2)/2)^2 *
                                           cos(radians($1)) *
                                           cos(radians($3))
                                       )
                                   ) * 7926.3352 AS distance;
                            $BODY$
                            LANGUAGE sql IMMUTABLE
                            COST 100;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
