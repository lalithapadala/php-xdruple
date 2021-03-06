<?php declare(strict_types=1);

namespace Xtuple\Xdruple\Application\Service\Log;

use Xtuple\Util\Type\String\Message\Type\String\StringMessage;
use Xtuple\Xdruple\Application\Service\Log\Level\NotificationTypeFromLogLevel;
use Xtuple\Xdruple\Application\Service\Log\Record\LogRecord;
use Xtuple\Xdruple\Application\Service\Log\Watchdog\Record\WatchdogLogRecord;
use Xtuple\Xdruple\Application\Service\Session\Notification\NotificationStruct;
use Xtuple\Xdruple\Application\Service\Session\Session;
use Xtuple\Xdruple\Application\Service\URL\URI\URIStruct;
use Xtuple\Xdruple\Application\Service\URL\URL;

/**
 * @codeCoverageIgnore Drupal
 */
final class DrupalLog
  implements Log {
  /** @var URL */
  private $url;
  /** @var Session */
  private $session;

  public function __construct(URL $url, Session $session) {
    $this->url = $url;
    $this->session = $session;
  }

  public function log(LogRecord $record): void {
    $link = null;
    if (($details = $record->details())
      && ($referrer = $details->link())) {
      $link = $this->url->l(
        new StringMessage($referrer->title()),
        new URIStruct($referrer->path(), $referrer->options())
      );
    }
    foreach ($record->notifications() as $notification) {
      $this->session->notifications()->add(new NotificationStruct(
        (new NotificationTypeFromLogLevel($record->level()))->type(),
        $notification
      ));
    }
    $watchdog = new WatchdogLogRecord($record);
    watchdog($watchdog->type(), $watchdog->message(), $watchdog->variables(), $watchdog->severity(), $link);
  }
}
