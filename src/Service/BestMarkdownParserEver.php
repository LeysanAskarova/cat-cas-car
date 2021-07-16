<?php
namespace App\Service;

use Demontpx\ParsedownBundle\Parsedown as ParsedownBundleParsedown;

class BestMarkdownParserEver extends ParsedownBundleParsedown
{
    public function text($text)
    {
        return 'Я лучший парсер <b>markdown</b>';
    }
}
