<?php

namespace ADW\ConfigBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Persisters\PersisterException;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ADW\ConfigBundle\Entity\AllowIp;
use ADW\ConfigBundle\Entity\ConfigSite;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class ConfigBundleCommand.
 * Project ConfigBundle.
 *
 * @author Anton Prokhorov
 */
class ConfigBundleCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('adw:config:install')
            ->setDescription('Install config bundle');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $tool = new SchemaTool($this->em);

        $classes = [
            $this->em->getClassMetadata(ConfigSite::class),
        ];

        try {
            $output->writeln('Create table for Bundle');
            $tool->createSchema($classes);
            $output->writeln('-------------------------');
            $output->writeln('<info>Table created</info>');
        } catch (ToolsException $e) {
            $output->writeln('-------------------------');
            $output->writeln('<error>Table already exists!</error>');
        }

        $this->truncateTable(ConfigSite::class);

        $output->writeln('Truncate table');

        $new_config_record = new ConfigSite();

        $new_config_ip = new AllowIp();

        $new_config_ip->setName('127.0.0.1');

        $new_config_record->setName('ConfigSite');
        $new_config_record->setTurnOff(false);
        $new_config_record->addAllowIp($new_config_ip);
        $new_config_record->setStartAt(new \DateTime());
        $new_config_record->setStopAt(new \DateTime());

        $this->em->persist($new_config_record);
        try {
            $this->em->flush();
            $output->writeln('-------------------------');
            $output->writeln('<info>Add default record</info>');
        } catch (PersisterException $e) {
            $output->writeln('-------------------------');
            $output->writeln('<error>Error write record!</error>');
        }
    }

    /**
     * @param ConfigSite $entity
     *
     * @return mixed
     */
    protected function truncateTable(ConfigSite $entity)
    {
        $classMetaData = $this->em->getClassMetadata($entity);
        $connection = $this->em->getConnection();

        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');

            return $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
    }
}
