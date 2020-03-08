<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\View\Helper;

use DateInterval;
use DateTime;
use IntlDateFormatter;
use Laminas\I18n\View\Helper\Translate;
use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Helper\AbstractHelper;

class HumanDate extends AbstractHelper
{
    /**
     * Converts time to fuzzy time strings
     *
     * @param null|string|int|DateTime|array $time
     */
    public function __invoke($time = null): string
    {
        if ($time === null) {
            throw new InvalidArgumentException('Expected parameter $time was not provided.');
        }

        if (! $time instanceof DateTime) {
            $dateTime = new DateTime();
            $dateTime->setTimestamp($time);
            $time = $dateTime;
        }

        $now = new DateTime('now');
        $now->setTimezone($time->getTimezone());
        $ymd = $time->format('Ymd');

        if ($ymd === $now->format('Ymd')) {
            return $this->view->translate('today');
        }

        $now = new DateTime('now');
        $now->sub(new DateInterval('P1D'));
        if ($ymd === $now->format('Ymd')) {
            return $this->view->translate('yesterday');
        }

        $now = new DateTime('now');
        $now->add(new DateInterval('P1D'));
        if ($ymd === $now->format('Ymd')) {
            return $this->view->translate('tomorrow');
        }

        $language = $this->view->plugin(Translate::class)->getTranslator()->getLocale();

        $dateFormatter = new IntlDateFormatter($language, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $dateFormatter->setTimezone($time->getTimezone());
        return $dateFormatter->format($time);
    }
}
