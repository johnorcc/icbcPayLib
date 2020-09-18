<?php

namespace icbc;

class IcbcSignature
{
    /**
     * @param $strToSign
     * @param $signType
     * @param $privateKey
     * @param $charset
     * @param $password
     * @return mixed|string
     * @throws \Exception
     */
    public static function sign($strToSign, $signType, $privateKey, $charset = 'UTF-8', $password)
    {
        if (IcbcConstants::$SIGN_TYPE_CA == $signType) {
            return IcbcCa::sign($strToSign, $privateKey, $password);
        } elseif (IcbcConstants::$SIGN_TYPE_RSA == $signType) {
            return RSA::sign($strToSign, $privateKey, IcbcConstants::$SIGN_SHA1RSA_ALGORITHMS);
        } elseif (IcbcConstants::$SIGN_TYPE_RSA2 == $signType) {
            return RSA::sign($strToSign, $privateKey, IcbcConstants::$SIGN_SHA256RSA_ALGORITHMS);
        } else {
            throw new \Exception("Only support CA\RSA signature!");
        }
    }


    /**
     * @param $strToSign
     * @param $signType
     * @param $publicKey
     * @param $charset
     * @param $signedStr
     * @param $password
     * @return int
     * @throws \Exception
     */
    public static function verify($strToSign, $signType, $publicKey, $charset = 'UTF-8', $signedStr, $password='')
    {

        if (IcbcConstants::$SIGN_TYPE_CA == $signType) {
            return IcbcCa::verify($strToSign, $publicKey, $password);
        } elseif (IcbcConstants::$SIGN_TYPE_RSA == $signType) {
            return RSA::verify($strToSign, $signedStr, $publicKey, IcbcConstants::$SIGN_SHA1RSA_ALGORITHMS);
        } elseif (IcbcConstants::$SIGN_TYPE_RSA2 == $signType) {
            return RSA::verify($strToSign, $signedStr, $publicKey, IcbcConstants::$SIGN_SHA256RSA_ALGORITHMS);
        } else {
            throw new \Exception("Only support CA or RSA signature verify!");
        }
    }
}