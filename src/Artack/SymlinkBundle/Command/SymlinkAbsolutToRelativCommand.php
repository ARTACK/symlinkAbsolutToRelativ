<?php

namespace Artack\SymlinkBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymlinkAbsolutToRelativCommand extends Command
{
    
    protected function configure()
    {
        $this
            ->setName('symlink:absolut-to-relativ')
            ->setDescription('Recreate symlinks absolute to relative')
            ->addArgument('startpoint', InputArgument::REQUIRED, 'Where do we start?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("START");
        
        
        
        $output->writeln("END");
    }
    
}