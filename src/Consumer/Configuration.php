<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Consumer;

class Configuration extends \RdKafka\Conf
{
    /**
     * @param array<mixed> $configs
     */
    public function __construct(array $configs)
    {
        /** @scrutinizer ignore-call */
        parent::__construct();

        foreach ($configs as $name => $value) {
            $this->set($name, (string) $value);
        }
    }
}
