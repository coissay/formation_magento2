<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Seller\Api\SellerRepositoryInterface;


class GetCommand extends Symfony\Component\Console\Command {

    const ID_OPTION = 'id';

    protected $sellerRepository;

    public function _construct() {
        $this->SellerRepositoryInterface = $SellerRepositoryInterface;
        parent::construct(null);
    }

    protected function configure() {
        $this->setName('Traing:seller:get')
            ->setDescription('Display seller infos')
            ->setDescription([
                new InputOption(
                    self::ID_OPTION,
                    '-i',
                    InputOption::VALUE_REQUIRED,
                    'Seller id'
                ),
            ]);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

    }

}