<?php

namespace Artack\SymlinkBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

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
        
        $startpoint = $input->getArgument('startpoint');
        $output->writeln("STARTPOINT: ".$startpoint);
        
        if (!is_dir($startpoint))
        {
            throw new \Exception("Startpoint not a dir");
        }
        
        $filter = function (\SplFileInfo $file)
        {
            if ($file->isLink()) {
                return true;
            }
            return false;
        };
        
        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder->in($startpoint);
        $finder->filter($filter);
        
        foreach($finder as $file)
        {
            $output->writeln("FILE: ".$file->getPathname());
            $output->writeln("TARGET [OLD]: ".$file->getLinkTarget());
            
            chdir($file->getPath());
            
            $symlinkRelSource = rtrim($filesystem->makePathRelative($file->getLinkTarget(), $file->getPath()), "/");
            $symlinkRelTarget = $file->getBasename();
            
            if (true === $filesystem->isAbsolutePath($file->getLinkTarget()))
            {
                $filesystem->remove($file->getPathname());
                $filesystem->symlink($symlinkRelSource, $symlinkRelTarget);

                $newSymLink = new \SplFileInfo($file->getPathname());
                $output->writeln("TARGET [NEW]: ".$newSymLink->getLinkTarget());
            }
        
        }
        
        $output->writeln("END");
    }
    
}