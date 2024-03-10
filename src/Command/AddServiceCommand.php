<?php

namespace App\Command;

use App\Entity\Service;
use App\Entity\SubService;
use App\Repository\ServiceRepository;
use App\Repository\SubServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:add:service',
    description: 'Импорт услуг',
)]
class AddServiceCommand extends Command
{
    public function __construct(
        private ServiceRepository $serviceRepository,
        private EntityManagerInterface $entityManager,
        private SubServiceRepository $subServiceRepository,
        private SluggerInterface $slugger,
        private ContainerBagInterface $containerBag
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $appDir = $this->containerBag->get('kernel.project_dir');

        $sourceFile = $appDir . \DIRECTORY_SEPARATOR . 'services.csv';

        $services = $this->services($sourceFile);

        foreach ($services as $nameService => $subServices) {
            $io->writeln($nameService);

            $categoryService = $this->serviceRepository->findOneBy(['slug' => $this->slugger($nameService)]);

            if ($categoryService !== null) {
                foreach ($subServices as $service) {
                    $subServiceEntity = $this->subServiceRepository->findOneBy(['slug' => $service[1]]);

                    if ($subServiceEntity === null) {
                        $subServiceEntity = new SubService();
                        $subServiceEntity->setService($categoryService);
                        $subServiceEntity->setName($service[0]);
                        $subServiceEntity->setSlug($service[1]);
                        $subServiceEntity->setHours($service[2]);

                        $this->entityManager->persist($subServiceEntity);
                    }
                }

                $this->entityManager->flush();
            } else {
                $this->entityManager->persist(
                    (new Service())
                        ->setName($nameService)
                        ->setSlug($this->slugger($nameService))
                        ->setIsDomain(false)
                );

                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }

    private function services(string $filename): array
    {
        $reader = function (string $filename) {
            $fp = fopen($filename, 'r');

            try {
                while (($row = fgetcsv($fp)) !== false) {
                    yield $row;
                }
            } finally {
                fclose($fp);
            }
        };

        $services = [];
        $serviceCategory = '';

        $iterator = $reader($filename);
        $iterator = new \LimitIterator($iterator, 2);

        foreach ($iterator as $row) {
            [$serviceName, $serviceSlug, $serviceHour] = $row;

            if (empty($serviceName)) {
                continue;
            }

            // Категория
            if (empty($serviceSlug)) {
//                $serviceCategory = $this->slugger($serviceName);
                $serviceCategory = $serviceName;

                continue;
            }

            $services[$serviceCategory][] = [$serviceName, $serviceSlug . '/', $this->strToFloat($serviceHour)];
        }

        return $services;
    }

    private function slugger(string $value): string
    {
        return (string)$this->slugger->slug($value)->lower();
    }

    private function strToFloat(string $value): float
    {
        $value = str_replace(',', '.', $value);

        return (float)$value;
    }
}
