<?php

namespace admin\components;

use Yii;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @var string the text to be displayed when formatting a `null` value.
     */
    public $nullDisplay = '-';

    /**
     * 将分显示成元
     */
    public function asCent($value)
    {
        return '<div class="text-right">' . sprintf('￥%.2f', $value / 100) . '</div>';
    }

    /**
     * 转换成元
     * @param $value
     * @return string
     */
    public function asYuan($value) {
        return '<div class="text-center">' . sprintf('%.2f', $value / 100) . '</div>';
    }

    /**
     * 右侧显示数字
     */
    public function asTimes($value)
    {
        return '<div class="text-right">' . $value . '</div>';
    }

    /**
     * 将日期转换成 Y-m-d
     * @param $value
     * @return string
     */
    public function asYearDate($value) {
        return date('Y-m-d', strtotime($value));
    }

    /**
     * @param \DateTime|int|string $value
     * @param null $format
     * @return string
     */
    public function asDatetime($value, $format = null)
    {
        if (empty($value)) {
            return '-';
        }
        return parent::asDatetime($value, $format); // TODO: Change the autogenerated stub
    }


}
