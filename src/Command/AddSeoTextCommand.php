<?php

namespace App\Command;

use App\Contracts\AddTextInterface;
use App\Entity\SeoText;
use App\Entity\SubService;
use App\Repository\ServiceRepository;
use App\Repository\SubServiceRepository;
use App\Service\TextHandlerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:add:seo-text',
    description: 'Add seo text',
)]
class AddSeoTextCommand extends Command
{
    public function __construct(
        private AddTextInterface $addText,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dir = getcwd() . '/articles';
        $files = array_diff(scandir($dir), array('..', '.'));

        foreach ($files as $file) {
            $this->addText->add($file);
        }

        $io->success('Статьи успешно добавлены');

        return Command::SUCCESS;
    }
}
