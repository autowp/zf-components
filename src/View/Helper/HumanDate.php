<?php

namespace Autowp\ZFComponents\View\Helper;

use Zend\View\Helper\AbstractHelper;

use DateInterval;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;

class HumanDate extends AbstractHelper
{
    /**
     * Converts time to fuzzy time strings
     *
     * @param string|integer|DateTime|array $time
     */
    public function __invoke($time = null)
    {
        if ($time === null) {
            throw new \Zend\View\Exception\InvalidArgumentException('Expected parameter $time was not provided.');
        }

        if (! $time instanceof DateTime) {
            $dateTime = new DateTime();
            $dateTime->setTimestamp($time);
            $time = $dateTime;
        }

        $now = new DateTime('now');
        $now->setTimezone($time->getTimezone());
        $ymd = $time->format('Ymd');

        if ($ymd == $now->format('Ymd')) {
            return $this->view->translate('today');
        }

        $now->sub(new DateInterval('P1D'));
        if ($ymd == $now->format('Ymd')) {
            return $this->view->translate('yesterday');
        }

        $language = $this->view->plugin(\Zend\I18n\View\Helper\Translate::class)->getTranslator()->getLocale();

        $dateFormatter = new IntlDateFormatter($language, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $dateFormatter->setTimezone($time->getTimezone());
        return $dateFormatter->format($time);
    }
}
