

###工商银行支付API Sdk封装

本类库为开发对接工行扫码付，根据工行原商户文档sdkDemo及自己修改之后的类库，[原文档地址](https://open.icbc.com.cn/icbc/apip/api_detail.html?apiId=10000000000000107000&baseUrl=%2Fmybank%2Fpay%2Fqrcode%2Fscanned&resUrl=%2Fpay&version=V1&apiName=%E4%BA%8C%E7%BB%B4%E7%A0%81%E8%A2%AB%E6%89%AB%E6%94%AF%E4%BB%98&serviceId=P0039&resourceId=10000000000000008020)

原demo无命名空间支持，且不符合个人使用习惯，本类库对原代码进行修改符合个人使用习惯和composer支持，如遇到使用困难或无法使用可参考下载[官方demo](https://open.icbc.com.cn/icbc/apip/attach/icbc-api-sdk-cop-php_v2_20200610.zip)

调用二维码被扫支付的大致代码如下：

    <?php
    
    require __DIR__ . '/vendor/autoload.php';
    use icbc\IcbcConstants;
    $appId = '100000000000011000000';
    $privateKeyPath = "private.pem";
    
    if(file_exists($privateKeyPath)) {
        $privateKey = file_get_contents($privateKeyPath);
    }else{
        echo "读取私钥失败";
        die;
    }
    //请注意网关公钥需符合公钥格式
    $icbcPublicKeyPath = 'API_GATEWAY_REAL.pub';
    
    if(file_exists($icbcPublicKeyPath)) {
        $icbcPublicKey = file_get_contents($icbcPublicKeyPath);
    }else{
        echo "读取网关公钥失败";
        die;
    }
    //以下构造函数第1个参数为appid，第2个参数为RSA密钥对中私钥，第6个参数为API平台网关公钥
    $icbcClient = new \icbc\DefaultIcbcClient($appId, $privateKey, IcbcConstants::$SIGN_TYPE_RSA2, IcbcConstants::$CHARSET_UTF8, IcbcConstants::$FORMAT_JSON, $icbcPublicKey, '', '', '', '');
    $request = array(
        "serviceUrl" => 'https://gw.open.icbc.com.cn/api/mybank/pay/qrcode/scanned/pay/V2',
        "method" => 'POST',
        "isNeedEncrypt" => false,
        "biz_content" => array(
            "qr_code" => "125001231467799129",
            "mer_id" => "230851010088",
            "out_trade_no" => "X000000009",
            "order_amt" => "1",
            "attach" => "商户附加消息",
            "trade_date" => "20200918",
            "trade_time" => "113535"
        )
    );
    
    try {
        //执行调用;msgId消息通讯唯一编号，要求每次调用独立生成，APP级唯一
        $resp = $icbcClient->execute($request, 'msgId1', '');
    } catch (Exception $e) {
        var_dump($e);die;
    }
    $respObj = json_decode($resp, true);
    if ($respObj["return_code"] == 0) {
        echo $respObj["return_msg"];
    } else {
        echo $respObj["return_msg"];
    }
