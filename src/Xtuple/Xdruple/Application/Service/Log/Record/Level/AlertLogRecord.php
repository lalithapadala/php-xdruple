<?php declare(strict_types=1);

namespace Xtuple\Xdruple\Application\Service\Log\Record\Level;

use Xtuple\Util\Type\String\Message\Message\Collection\Sequence\ArrayListMessage;
use Xtuple\Util\Type\String\Message\Message\Message;
use Xtuple\Xdruple\Application\Service\Log\Level\LogLevel;
use Xtuple\Xdruple\Application\Service\Log\Record\AbstractLogRecord;
use Xtuple\Xdruple\Application\Service\Log\Record\Details\LogRecordDetails;
use Xtuple\Xdruple\Application\Service\Log\Record\LogRecordStruct;

final class AlertLogRecord
  extends AbstractLogRecord {
  public function __construct(string $type, Message $log, ?LogRecordDetails $details = null,
                              ?Message $notification = null) {
    /** @noinspection PhpUnhandledExceptionInspection - $messages types are verified */
    $notifications = $notification ? new ArrayListMessage([$notification]) : null;
    parent::__construct(new LogRecordStruct($type, LogLevel::ALERT(), $log, $details, $notifications));
  }
}
