<?php

namespace CouponURLs\Original\Commands\BuiltIn;

use CouponURLs\Original\Creators\DomainFilesCreator;
use CouponURLs\Original\Creators\ModelFilesCreator;
use CouponURLs\Original\Language\Classes\Properties;
use CouponURLs\Original\Language\Classes\Property;
use CouponURLs\Original\Language\Types;
use CouponURLs\Original\Language\Visibilities;
use League\CLImate\CLImate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

Class ModelCreatorCommand extends Command
{
    private $weather;

    protected function configure()
    {
        $this->setName('new.model');
        $this->setDescription('Create model files in the app/data directory');

        $this->addArgument('singularName', InputArgument::REQUIRED, 'Singular Name');
        $this->addArgument('pluralName', InputArgument::REQUIRED, 'Plural Name');

        $this->addOption('dd', null, InputOption::VALUE_REQUIRED, 'A directory to create the entity classes relative to the app/domain directory. The files will be created in the first level of the directory specified, instead of its own directory');
        $this->weather = new CLImate;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // create the domains
        // create the gatewyas
        // create the exporter and improrer mappers
        // and all of them tests

        (object) $domainFilesCreator = new DomainFilesCreator(
            $input->getArgument('singularName'),
            $input->getArgument('pluralName'),
            $this->askForProperties(),
            $this->askExportable(),
            $input->getOption('dd')
        );

        $domainFilesCreator->create();
return 0;
        (object) $modelFilesCreator = new ModelFilesCreator(
            $input->getArgument('singularName'),
            $input->getArgument('pluralName')
        );

        $modelFilesCreator->create();
    }

    protected function askExportable() : bool
    {
        return (boolean) $this->askQuestionUsingMenu([
            1 => 'yes',
            0 => 'no'
        ], "Is it exportable? (creates EntityTemplate* classes and tests)");
    }
    
    protected function askForProperties() : Properties
    {
        (object) $properties = [];

        while ($propertyName = $this->askForPropertyName()) {
            (integer) $propertyVisibilityOption = $this->askForPropertyVisibility($propertyName);
            (string) $propertyTypeOption = $this->askForPropertyType($propertyName);

            $properties[] = new Property($propertyName, $propertyTypeOption, $propertyVisibilityOption);
        }

        return new Properties($properties);   
    }

    protected function askForPropertyName() : string
    {
        return $this->weather->input("New field name (leave empty to skip): \n")->prompt();
    }

    protected function askForPropertyVisibility(string $propertyName) : string
    {       
        (array) $options = [
            Visibilities::PUBLIC_ID => 'Public (creates a getter and a setter)',
            Visibilities::READONLY_ID => 'Readonly (creates only a getter)',
            Visibilities::PRIVATE_ID => 'Private (no getter nor setter)'
        ];

        (integer) $visibilityId = $this->askQuestionUsingMenu($options, $this->formatQuestion($propertyName, "Visibility"));

        return (new Visibilities)->getNameFromId($visibilityId);
    }
    
    protected function askForPropertyType(string $propertyName)  : string
    {       
        (array) $options = [
            Types::STRING_ID => 'String (native)',
            Types::INETEGER_ID => 'Integer (native)',
            Types::FLOAT_ID => 'Float (native)',
            Types::ARRAY_ID => 'Array (native)',
            Types::COLLECTION_ID => 'Collection (user)',
            Types::CLASS_ID => 'Class|Interface (user)',
            ($none = 0) => 'None (:P)',
        ];

        (integer) $result = $this->askQuestionUsingMenu($options, $this->formatQuestion($propertyName, "Property type"));

        if ($result === Types::CLASS_ID) {
            return $this->weather->input("Enter fully qualified class or interface: \n")->prompt();
        }

        return (new Types)->getNameFromId($result);
    }

    protected function askQuestionUsingMenu(array $options, string $question) /*dont specify a return type!*/
    {
        (object) $question = $this->weather->radio($question, $options);

        return array_flip($options)[$question->prompt()];
    }
    
    protected function formatQuestion(string $propertyName, string $question) : string
    {
        return "($propertyName) - {$question}";
    }
    
}