<?php

namespace VictorYoalli\LaravelCodeGenerator;

class Helper
{
    const PHP_SOL = '<?php';
    // const AMPER_DOUBLE_CURLY_OPEN = '@{{';
    const DOUBLE_CURLY_OPEN = '{{';
    const DOUBLE_CURLY_CLOSE = '}}';
    // const ACC_OPEN = self::AMPER_DOUBLE_CURLY_OPEN;
    const CC_OPEN = self::DOUBLE_CURLY_OPEN;
    const CC_CLOSE = self::DOUBLE_CURLY_CLOSE;

    public function PHPSOL()
    {
        return self::PHP_SOL;
    }
    public function doubleCurlyOpen()
    {
        return self::CC_OPEN;
    }

    public function doubleCurlyClose()
    {
        return self::CC_CLOSE;
    }

    public function tag($text)
    {
        return '<'.$text.'>';
    }
}
