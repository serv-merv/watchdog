<?php
declare(strict_types=1);


namespace DisasterBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 * @package DisasterBundle\Command
 */
class TestCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('disaster:test');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $outputs
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $sync = $this->getContainer()->get('usgs.resources.sync');
        $sync->sync();
        $sync = $this->getContainer()->get('viirs.resources.sync');
        $sync->sync();
    }
}