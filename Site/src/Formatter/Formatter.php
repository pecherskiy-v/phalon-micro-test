<?php

namespace App\Formatter;

use Phalcon\Logger\Formatter\AbstractFormatter;
use Phalcon\Logger\Item;
use DateTime;
use Exception;

class Formatter extends AbstractFormatter
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function format(Item $item)
    {
        $context = $item->getContext();
        $msg = $item->getMessage();
        if (!empty($context)) {
            $context = json_encode($context);
            $msg .= " | {$context}";
        }
        $name = $item->getName();

        return "[{$this->getFormattedDate()}][{$name}] - {$msg}";
    }
}
