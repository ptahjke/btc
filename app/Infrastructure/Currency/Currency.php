<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency;

use Currency\InvalidCurrencyException;

class Currency implements \JsonSerializable
{
    public const CURRENCY_BTC = 'BTC';

    private string $code;
    private int $numericCode;
    private int $minorUnit;
    private bool $isBTC = false;
    private int $precision = 2;

    public function __construct($currencyCode, $customMinorUnit = null)
    {
        if (preg_match('/^[a-zA-Z0-9]+$/', $currencyCode) !== 1) {
            throw new InvalidCurrencyException('The currency code must be alphanumeric and non empty.');
        }

        if (false === array_key_exists($currencyCode, self::CURRENCIES)) {
            throw new InvalidCurrencyException('Undefined currency code.');
        }

        if ($customMinorUnit < 0) {
            throw new InvalidCurrencyException('customMinorUnit cannot be less than zero.');
        }

        if (self::CURRENCY_BTC === $currencyCode) {
            $this->isBTC = true;
            $this->precision = 10;
        }

        $this->code = $currencyCode;
        $this->numericCode = self::CURRENCIES[$currencyCode]['numericCode'];
        $this->minorUnit = null !== $customMinorUnit
            ? $customMinorUnit
            : self::CURRENCIES[$currencyCode]['minorUnit'];
    }

    public static function create($currencyCode, $customMinorUnit = null)
    {
        return new self($currencyCode,$customMinorUnit);
    }

    public static function __callStatic($currencyCode, $params = [])
    {
        $customMinorUnit = isset($params[0]) ? $params[0] : null;
        return self::create($currencyCode, $customMinorUnit);
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'numeric_code' => $this->numericCode,
            'minor_unit' => $this->minorUnit,
        ];
    }

    public function __toString()
    {
        return $this->code;
    }

    /**
     * Returns currency code.
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Returns minor unit.
     * @return int
     */
    public function getMinorUnit() {
        return $this->minorUnit;
    }

    /**
     * @return bool
     */
    public function isBTC(): bool
    {
        return $this->isBTC;
    }

    /**
     * @return int
     */
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * Returns whether this Currency is equal to the given currency.
     * @param Currency $currency
     * @return bool
     */
    public function is(Currency $currency) {
        return $this->code === $currency->getCode();
    }

    const CURRENCIES = [
        'AFN' => ['numericCode' => 971, 'minorUnit' => 2],
        'EUR' => ['numericCode' => 978, 'minorUnit' => 2],
        'ALL' => ['numericCode' => 8, 'minorUnit' => 2],
        'DZD' => ['numericCode' => 12, 'minorUnit' => 2],
        'USD' => ['numericCode' => 840, 'minorUnit' => 2],
        'AOA' => ['numericCode' => 973, 'minorUnit' => 2],
        'XCD' => ['numericCode' => 951, 'minorUnit' => 2],
        'ARS' => ['numericCode' => 32, 'minorUnit' => 2],
        'AMD' => ['numericCode' => 51, 'minorUnit' => 2],
        'AWG' => ['numericCode' => 533, 'minorUnit' => 2],
        'AUD' => ['numericCode' => 36, 'minorUnit' => 2],
        'AZN' => ['numericCode' => 944, 'minorUnit' => 2],
        'BSD' => ['numericCode' => 44, 'minorUnit' => 2],
        'BHD' => ['numericCode' => 48, 'minorUnit' => 3],
        'BDT' => ['numericCode' => 50, 'minorUnit' => 2],
        'BBD' => ['numericCode' => 52, 'minorUnit' => 2],
        'BYN' => ['numericCode' => 933, 'minorUnit' => 2],
        'BZD' => ['numericCode' => 84, 'minorUnit' => 2],
        'XOF' => ['numericCode' => 952, 'minorUnit' => 0],
        'BMD' => ['numericCode' => 60, 'minorUnit' => 2],
        'INR' => ['numericCode' => 356, 'minorUnit' => 2],
        'BTN' => ['numericCode' => 64, 'minorUnit' => 2],
        'BOB' => ['numericCode' => 68, 'minorUnit' => 2],
        'BOV' => ['numericCode' => 984, 'minorUnit' => 2],
        'BAM' => ['numericCode' => 977, 'minorUnit' => 2],
        'BWP' => ['numericCode' => 72, 'minorUnit' => 2],
        'NOK' => ['numericCode' => 578, 'minorUnit' => 2],
        'BRL' => ['numericCode' => 986, 'minorUnit' => 2],
        'BND' => ['numericCode' => 96, 'minorUnit' => 2],
        'BGN' => ['numericCode' => 975, 'minorUnit' => 2],
        'BIF' => ['numericCode' => 108, 'minorUnit' => 0],
        'CVE' => ['numericCode' => 132, 'minorUnit' => 2],
        'KHR' => ['numericCode' => 116, 'minorUnit' => 2],
        'XAF' => ['numericCode' => 950, 'minorUnit' => 0],
        'CAD' => ['numericCode' => 124, 'minorUnit' => 2],
        'KYD' => ['numericCode' => 136, 'minorUnit' => 2],
        'CLP' => ['numericCode' => 152, 'minorUnit' => 0],
        'CLF' => ['numericCode' => 990, 'minorUnit' => 4],
        'CNY' => ['numericCode' => 156, 'minorUnit' => 2],
        'COP' => ['numericCode' => 170, 'minorUnit' => 2],
        'COU' => ['numericCode' => 970, 'minorUnit' => 2],
        'KMF' => ['numericCode' => 174, 'minorUnit' => 0],
        'CDF' => ['numericCode' => 976, 'minorUnit' => 2],
        'NZD' => ['numericCode' => 554, 'minorUnit' => 2],
        'CRC' => ['numericCode' => 188, 'minorUnit' => 2],
        'HRK' => ['numericCode' => 191, 'minorUnit' => 2],
        'CUP' => ['numericCode' => 192, 'minorUnit' => 2],
        'CUC' => ['numericCode' => 931, 'minorUnit' => 2],
        'ANG' => ['numericCode' => 532, 'minorUnit' => 2],
        'CZK' => ['numericCode' => 203, 'minorUnit' => 2],
        'DKK' => ['numericCode' => 208, 'minorUnit' => 2],
        'DJF' => ['numericCode' => 262, 'minorUnit' => 0],
        'DOP' => ['numericCode' => 214, 'minorUnit' => 2],
        'EGP' => ['numericCode' => 818, 'minorUnit' => 2],
        'SVC' => ['numericCode' => 222, 'minorUnit' => 2],
        'ERN' => ['numericCode' => 232, 'minorUnit' => 2],
        'ETB' => ['numericCode' => 230, 'minorUnit' => 2],
        'FKP' => ['numericCode' => 238, 'minorUnit' => 2],
        'FJD' => ['numericCode' => 242, 'minorUnit' => 2],
        'XPF' => ['numericCode' => 953, 'minorUnit' => 0],
        'GMD' => ['numericCode' => 270, 'minorUnit' => 2],
        'GEL' => ['numericCode' => 981, 'minorUnit' => 2],
        'GHS' => ['numericCode' => 936, 'minorUnit' => 2],
        'GIP' => ['numericCode' => 292, 'minorUnit' => 2],
        'GTQ' => ['numericCode' => 320, 'minorUnit' => 2],
        'GBP' => ['numericCode' => 826, 'minorUnit' => 2],
        'GNF' => ['numericCode' => 324, 'minorUnit' => 0],
        'GYD' => ['numericCode' => 328, 'minorUnit' => 2],
        'HTG' => ['numericCode' => 332, 'minorUnit' => 2],
        'HNL' => ['numericCode' => 340, 'minorUnit' => 2],
        'HKD' => ['numericCode' => 344, 'minorUnit' => 2],
        'HUF' => ['numericCode' => 348, 'minorUnit' => 2],
        'ISK' => ['numericCode' => 352, 'minorUnit' => 0],
        'IDR' => ['numericCode' => 360, 'minorUnit' => 2],
        'XDR' => ['numericCode' => 960, 'minorUnit' => 0],
        'IRR' => ['numericCode' => 364, 'minorUnit' => 2],
        'IQD' => ['numericCode' => 368, 'minorUnit' => 3],
        'ILS' => ['numericCode' => 376, 'minorUnit' => 2],
        'JMD' => ['numericCode' => 388, 'minorUnit' => 2],
        'JPY' => ['numericCode' => 392, 'minorUnit' => 0],
        'JOD' => ['numericCode' => 400, 'minorUnit' => 3],
        'KZT' => ['numericCode' => 398, 'minorUnit' => 2],
        'KES' => ['numericCode' => 404, 'minorUnit' => 2],
        'KPW' => ['numericCode' => 408, 'minorUnit' => 2],
        'KRW' => ['numericCode' => 410, 'minorUnit' => 0],
        'KWD' => ['numericCode' => 414, 'minorUnit' => 3],
        'KGS' => ['numericCode' => 417, 'minorUnit' => 2],
        'LAK' => ['numericCode' => 418, 'minorUnit' => 2],
        'LBP' => ['numericCode' => 422, 'minorUnit' => 2],
        'LSL' => ['numericCode' => 426, 'minorUnit' => 2],
        'ZAR' => ['numericCode' => 710, 'minorUnit' => 2],
        'LRD' => ['numericCode' => 430, 'minorUnit' => 2],
        'LYD' => ['numericCode' => 434, 'minorUnit' => 3],
        'CHF' => ['numericCode' => 756, 'minorUnit' => 2],
        'MOP' => ['numericCode' => 446, 'minorUnit' => 2],
        'MKD' => ['numericCode' => 807, 'minorUnit' => 2],
        'MGA' => ['numericCode' => 969, 'minorUnit' => 2],
        'MWK' => ['numericCode' => 454, 'minorUnit' => 2],
        'MYR' => ['numericCode' => 458, 'minorUnit' => 2],
        'MVR' => ['numericCode' => 462, 'minorUnit' => 2],
        'MRO' => ['numericCode' => 478, 'minorUnit' => 2],
        'MUR' => ['numericCode' => 480, 'minorUnit' => 2],
        'XUA' => ['numericCode' => 965, 'minorUnit' => 0],
        'MXN' => ['numericCode' => 484, 'minorUnit' => 2],
        'MXV' => ['numericCode' => 979, 'minorUnit' => 2],
        'MDL' => ['numericCode' => 498, 'minorUnit' => 2],
        'MNT' => ['numericCode' => 496, 'minorUnit' => 2],
        'MAD' => ['numericCode' => 504, 'minorUnit' => 2],
        'MZN' => ['numericCode' => 943, 'minorUnit' => 2],
        'MMK' => ['numericCode' => 104, 'minorUnit' => 2],
        'NAD' => ['numericCode' => 516, 'minorUnit' => 2],
        'NPR' => ['numericCode' => 524, 'minorUnit' => 2],
        'NIO' => ['numericCode' => 558, 'minorUnit' => 2],
        'NGN' => ['numericCode' => 566, 'minorUnit' => 2],
        'OMR' => ['numericCode' => 512, 'minorUnit' => 3],
        'PKR' => ['numericCode' => 586, 'minorUnit' => 2],
        'PAB' => ['numericCode' => 590, 'minorUnit' => 2],
        'PGK' => ['numericCode' => 598, 'minorUnit' => 2],
        'PYG' => ['numericCode' => 600, 'minorUnit' => 0],
        'PEN' => ['numericCode' => 604, 'minorUnit' => 2],
        'PHP' => ['numericCode' => 608, 'minorUnit' => 2],
        'PLN' => ['numericCode' => 985, 'minorUnit' => 2],
        'QAR' => ['numericCode' => 634, 'minorUnit' => 2],
        'RON' => ['numericCode' => 946, 'minorUnit' => 2],
        'RUB' => ['numericCode' => 643, 'minorUnit' => 2],
        'RWF' => ['numericCode' => 646, 'minorUnit' => 0],
        'SHP' => ['numericCode' => 654, 'minorUnit' => 2],
        'WST' => ['numericCode' => 882, 'minorUnit' => 2],
        'STD' => ['numericCode' => 678, 'minorUnit' => 2],
        'SAR' => ['numericCode' => 682, 'minorUnit' => 2],
        'RSD' => ['numericCode' => 941, 'minorUnit' => 2],
        'SCR' => ['numericCode' => 690, 'minorUnit' => 2],
        'SLL' => ['numericCode' => 694, 'minorUnit' => 2],
        'SGD' => ['numericCode' => 702, 'minorUnit' => 2],
        'XSU' => ['numericCode' => 994, 'minorUnit' => 0],
        'SBD' => ['numericCode' => 90, 'minorUnit' => 2],
        'SOS' => ['numericCode' => 706, 'minorUnit' => 2],
        'SSP' => ['numericCode' => 728, 'minorUnit' => 2],
        'LKR' => ['numericCode' => 144, 'minorUnit' => 2],
        'SDG' => ['numericCode' => 938, 'minorUnit' => 2],
        'SRD' => ['numericCode' => 968, 'minorUnit' => 2],
        'SZL' => ['numericCode' => 748, 'minorUnit' => 2],
        'SEK' => ['numericCode' => 752, 'minorUnit' => 2],
        'CHE' => ['numericCode' => 947, 'minorUnit' => 2],
        'CHW' => ['numericCode' => 948, 'minorUnit' => 2],
        'SYP' => ['numericCode' => 760, 'minorUnit' => 2],
        'TWD' => ['numericCode' => 901, 'minorUnit' => 2],
        'TJS' => ['numericCode' => 972, 'minorUnit' => 2],
        'TZS' => ['numericCode' => 834, 'minorUnit' => 2],
        'THB' => ['numericCode' => 764, 'minorUnit' => 2],
        'TOP' => ['numericCode' => 776, 'minorUnit' => 2],
        'TTD' => ['numericCode' => 780, 'minorUnit' => 2],
        'TND' => ['numericCode' => 788, 'minorUnit' => 3],
        'TRY' => ['numericCode' => 949, 'minorUnit' => 2],
        'TMT' => ['numericCode' => 934, 'minorUnit' => 2],
        'UGX' => ['numericCode' => 800, 'minorUnit' => 0],
        'UAH' => ['numericCode' => 980, 'minorUnit' => 2],
        'AED' => ['numericCode' => 784, 'minorUnit' => 2],
        'USN' => ['numericCode' => 997, 'minorUnit' => 2],
        'UYU' => ['numericCode' => 858, 'minorUnit' => 2],
        'UYI' => ['numericCode' => 940, 'minorUnit' => 0],
        'UZS' => ['numericCode' => 860, 'minorUnit' => 2],
        'VUV' => ['numericCode' => 548, 'minorUnit' => 0],
        'VEF' => ['numericCode' => 937, 'minorUnit' => 2],
        'VND' => ['numericCode' => 704, 'minorUnit' => 0],
        'YER' => ['numericCode' => 886, 'minorUnit' => 2],
        'ZMW' => ['numericCode' => 967, 'minorUnit' => 2],
        'ZWL' => ['numericCode' => 932, 'minorUnit' => 2],
        'XBA' => ['numericCode' => 955, 'minorUnit' => 0],
        'XBB' => ['numericCode' => 956, 'minorUnit' => 0],
        'XBC' => ['numericCode' => 957, 'minorUnit' => 0],
        'XBD' => ['numericCode' => 958, 'minorUnit' => 0],
        'XTS' => ['numericCode' => 963, 'minorUnit' => 0],
        'XXX' => ['numericCode' => 999, 'minorUnit' => 0],
        'XAU' => ['numericCode' => 959, 'minorUnit' => 0],
        'XPD' => ['numericCode' => 964, 'minorUnit' => 0],
        'XPT' => ['numericCode' => 962, 'minorUnit' => 0],
        'XAG' => ['numericCode' => 961, 'minorUnit' => 0],
        // хак для быстрого решения
        self::CURRENCY_BTC => ['numericCode' => 888, 'minorUnit' => 0],
    ];

}
