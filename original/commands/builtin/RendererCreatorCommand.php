<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\Renderer\RendererFileCreator;
use CouponURLs\Original\Creators\Tasks\TestFileCreatorTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class RendererCreatorCommand extends Command
{
    protected function configure()
    {
        $this->setName('new.renderer');
        $this->setDescription('Creates a new Renderable (by default) or RendererDecorator class.');

        $this->addArgument('rendererNameNoSuffix', InputArgument::REQUIRED, 'The name of the renderer WITHOUT a Renderer suffix. It will be added automatically for you.');
        $this->addArgument('relativeDirectory', InputArgument::REQUIRED, 'The relative directory based on the project root. No extra directories will be created. The file will be created in the same directory as you specify.');
        $this->addOption('decorator', null, InputOption::VALUE_NONE, 'Create a RendererDecorator instead of a base Renderable');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (object) $rendererFileCreator = new RendererFileCreator(
            $input->getArgument('rendererNameNoSuffix'),
            $input->getArgument('relativeDirectory'),
            $input->getOption('decorator')
        );

        $rendererFileCreator->registerCompletionTasks([
            new TestFileCreatorTask
        ]);

        $rendererFileCreator->create();
    }
}