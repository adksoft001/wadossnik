<?php

namespace App\Command;

use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:edit:entity',
    description: 'Add a short description for your command',
)]
class EditEntityCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BrandRepository        $brandRepository,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $brands = $this->brandRepository->findAll();

        foreach ($brands as $brand) {
            $brand->setUrl(strtolower(str_replace(' ', '-', $brand->getName())));
            $brand->setHeader($brand->getName() .' '. $brand->getRusName());
        }
        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
