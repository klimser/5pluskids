<?php
namespace common\components\helpers;

class Calendar
{
    public static $weekDays = [
        'Воскресенье',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
    ];
    public static $weekDaysShort = [
        'ВС',
        'ПН',
        'ВТ',
        'СР',
        'ЧТ',
        'ПТ',
        'СБ',
    ];
    public static $monthNames = [
        '',
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь',
    ];

    /**
     * @return \DateTime
     */
    public static function getNextMonth()
    {
        $nowDate = new \DateTime();
        $nowDate = new \DateTime($nowDate->format('Y-m') . '-01 00:00:00');
        $nowDate->add(new \DateInterval('P1M'));
        return $nowDate;
    }
}