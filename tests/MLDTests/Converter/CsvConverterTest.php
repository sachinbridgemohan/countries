<?php

declare(strict_types=1);

namespace MLDTests\Converter;

use MLD\Converter\CsvConverter;
use PHPUnit\Framework\TestCase;

class CsvConverterTest extends TestCase
{

    /**
     * @var CsvConverter
     */
    private $converter;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->converter = new CsvConverter();
    }

    public function testConvertReturnsCsvData(): void
    {
        $country = [
            'name' => [
                'common' => 'Aruba',
                'official' => 'Aruba',
                'native' => [
                    'nld' => [
                        'official' => 'Aruba',
                        'common' => 'Aruba',
                    ],
                    'pap' => [
                        'official' => 'Aruba',
                        'common' => 'Aruba',
                    ],
                ],
            ],
            'tld' => ['.aw'],
            'cca2' => 'AW',
            'ccn3' => '533',
            'cca3' => 'ABW',
            'cioc' => 'ARU'
        ];

        $expectedCsv = <<<CSV
"name.common","name.official","name.native.nld.official","name.native.nld.common","name.native.pap.official","name.native.pap.common","tld","cca2","ccn3","cca3","cioc"
"Aruba","Aruba","Aruba","Aruba","Aruba","Aruba",".aw","AW","533","ABW","ARU"

CSV;

        $conversionResult = $this->converter->convert([$country]);

        $this->assertSame($expectedCsv, $conversionResult);
    }

    public function testConvertExtractsCurrencyCodes(): void
    {
        $country = [
            'currencies' => [
                'FOO' => 'hello',
                'BAR' => 'world'
            ]
        ];

        $expectedCsv = <<<CSV
"currencies"
"FOO,BAR"

CSV;

        $conversionResult = $this->converter->convert([$country]);

        $this->assertSame($expectedCsv, $conversionResult);
    }
}
