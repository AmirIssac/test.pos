<?php
namespace App\Encoding;

use InvalidArgumentException;

class Encode
{

    protected $sellerName;
    protected $vatRegistrationNumber;
    protected $timestamp;
    protected $totalWithVat;
    protected $vatTotal;
    protected $invoiceStatus;

    public function sellerName(string $value): self
    {
        $this->sellerName = new Tag(1, $value);
        return $this;
    }

    public function vatRegistrationNumber(string $value): self
    {
        /*
        if (strlen($value) != 15) {
            throw new InvalidArgumentException('Vat Registration Number must be 15 number');
        }
        */

        $this->vatRegistrationNumber = new Tag(2, $value);
        return $this;
    }
    public function timestamp(string $value): self
        {
            $this->timestamp = new Tag(3, date("Y-m-d\TH:i:s\Z", strtotime($value)));
            return $this;
        }
    public function totalWithVat($value): self
    {
        $this->totalWithVat = new Tag(4, $value);
        return $this;
    }
    public function vatTotal($value): self
    {
        $this->vatTotal = new Tag(5, $value);
        return $this;
    }

    public function invoiceStatus(string $value): self
    {
        $this->invoiceStatus = new Tag(6, $value);
        return $this;
    }

     /**
     * Representing the encoded TLV data structure.
     *
     * @return string 
     */
    public function toTLV(): string
    {
        return implode('', array_map(function ($tag) {
            return (string) $tag;
        }, $this->toArray()));
    }
     /**
     * Encodes an TLV as base64
     *
     * @return string 
     */
    public function toBase64(): string
    {
        return base64_encode($this->toTLV());
    }
    public function toArray()
    {
        $data = array_filter([
            $this->sellerName,
            $this->vatRegistrationNumber,
            $this->timestamp,
            $this->totalWithVat,
            $this->vatTotal,
            $this->invoiceStatus
        ]);

        if (count($data) < 5) {
            throw new InvalidArgumentException('Malformed data structure');
        }
        return $data;
    }




     /*
 * QR Encoding Functions
 */

public static function __getLength($value) {
    return strlen($value);
}


public static function __toHex($value) {
    return pack("H*", sprintf("%02X", $value));
}


/*
public function __toHex($value) {
    //return pack("H*", sprintf("%02X", $value));
    return bin2hex($value);
}
*/

public static function __toStringFun($__tag, $__value, $__length) {
    $value = (string) $__value;
    return self::__toHex($__tag) . self::__toHex($__length) . $value;
}

public static function __getTLV($dataToEncode) {
    $__TLVS = '';
    for ($i = 0; $i < count($dataToEncode); $i++) {
        $__tag = $dataToEncode[$i][0];
        $__value = $dataToEncode[$i][1];
        $__length = self::__getLength($__value);
        $__TLVS .= self::__toStringFun($__tag, $__value, $__length);
    }

    return $__TLVS;
}
}