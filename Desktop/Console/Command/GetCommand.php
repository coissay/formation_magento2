<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Training\Seller\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Class GetCommand
 */
class GetCommand extends Command
{
    /**
     * Id argument
     */
    const ID_OPTION = 'id';

    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * Constructor.
     *
     * @param SellerRepositoryInterface $sellerRepository
     *
     * @throws LogicException When the command name is empty
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository
    ) {
        $this->sellerRepository = $sellerRepository;
        parent::__construct(null);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('training:seller:get')
            ->setDescription('Display seller infos')
            ->setDefinition([
                new InputOption(
                    self::ID_OPTION,
                    '-i',
                    InputOption::VALUE_REQUIRED,
                    'Seller id'
                ),

            ]);
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $identifier = $input->getOption(self::ID_OPTION);

        if (is_null($identifier)) {
            throw new \InvalidArgumentException('Argument ' . self::ID_OPTION . ' is missing.');
        }

        $seller = $this->sellerRepository->getById($identifier);
        $output->writeln('<info>' .  $seller->getName() . '</info>');
    }
}
