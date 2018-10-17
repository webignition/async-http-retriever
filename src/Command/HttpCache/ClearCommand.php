<?php

namespace App\Command\HttpCache;

use App\Services\Http\HttpCache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends Command
{
    /**
     * @var HttpCache
     */
    private $httpCache;

    public function __construct(HttpCache $httpCache)
    {
        parent::__construct();
        $this->httpCache = $httpCache;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('web-resource-cache:httpcache:clear')
            ->setDescription('Clear memcache http cache')
            ->setHelp('Clear memcache http cache');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->httpCache->clear() ? 0 : 1;
    }
}