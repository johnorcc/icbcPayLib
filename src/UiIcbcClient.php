<?php

namespace icbc;


class UiIcbcClient extends DefaultIcbcClient
{
    function __construct($appId, $privateKey, $signType, $charset, $format, $icbcPulicKey, $encryptKey, $encryptType, $ca, $password){
        parent::__construct($appId, $privateKey, $signType, $charset, $format, $icbcPulicKey,$encryptKey, $encryptType, $ca, $password);
    }

    /**
     * @param $request
     * @param $msgId
     * @param null $appAuthToken
     * @return string
     * @throws \Exception
     */
    function buildPostForm($request, $msgId, $appAuthToken = null)
    {
        $params = $this->prepareParams($request, $msgId, $appAuthToken);

        $urlQueryParams = $this->buildUrlQueryParams($params);

        $url = WebUtils::buildGetUrl($request["serviceUrl"], $urlQueryParams, $this->charset);

        return WebUtils::buildForm($url, $this->buildBodyParams($params));
    }

    function buildUrlQueryParams($params)
    {
        $apiParamNames[] = IcbcConstants::$SIGN;
        $apiParamNames[] = IcbcConstants::$APP_ID;
        $apiParamNames[] = IcbcConstants::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstants::$CHARSET;
        $apiParamNames[] = IcbcConstants::$FORMAT;
        $apiParamNames[] = IcbcConstants::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstants::$TIMESTAMP;
        $apiParamNames[] = IcbcConstants::$MSG_ID;

        $urlQueryParams = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $apiParamNames)) {
                $urlQueryParams[$key] = $value;
            }
        }
        return $urlQueryParams;
    }

    function buildBodyParams($params)
    {
        $apiParamNames[] = IcbcConstants::$SIGN;
        $apiParamNames[] = IcbcConstants::$APP_ID;
        $apiParamNames[] = IcbcConstants::$SIGN_TYPE;
        $apiParamNames[] = IcbcConstants::$CHARSET;
        $apiParamNames[] = IcbcConstants::$FORMAT;
        $apiParamNames[] = IcbcConstants::$ENCRYPT_TYPE;
        $apiParamNames[] = IcbcConstants::$TIMESTAMP;
        $apiParamNames[] = IcbcConstants::$MSG_ID;

        $urlQueryParams = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $apiParamNames)) {
                continue;
            }
            $urlQueryParams[$key] = $value;
        }

        return $urlQueryParams;
    }

}
