<?php
include_once 'aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';
//include_once 'vendor/autoload.php';
use Airec\Request\V20181012 as Airec;
// 1.创建 Profile。
// 生成 IClientProfile 的对象 profile，该对象存放 AccessKeyID 和 AccessKeySecret
// 和默认的地域信息, 如这里的 cn-beijing
$accessKeyID = "xxx";
$accessSecret = "xxx";
$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $accessKeyID, $accessSecret);
// 2.设置 Endpoint。
// 调用 DefaultProfile 的 addEndpoint 方法，
// 传入 endpointName、regionId、product 名称、服务接入地址。
DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Airec", "airec.cn-hangzhou.aliyuncs.com");
// 3.创建 Client。
$client = new DefaultAcsClient($iClientProfile);
// 4.创建 Request
// 创建一个对应方法的 Request，类的命名规则一般为 API 的方法名加上 Request。
// 如获取实例详情的 API 方法名为 CreateInstance，那么对应的请求类名就是 CreateInstanceRequest
$request = new Airec\RecommendRequest();
$request->setReturnCount(10);
$request->setInstanceId('airec-cn-45913115o001');
$request->setIp('191.168.0.1');
$request->setSceneId(1);
$request->setImei(1);
$request->setUserId(1);
// 5.设置 Request的参数。
// 设置 Request 的参数。请求类生成好之后需要通过 Request 类的 setXxx 方法设置必要的信息，即 API 参数中必须要提供的信息。
$content = "{\"chargeType\":\"PrePaid\",\"type\":\"Standard\",\"quota\":{\"userCount\":1000000,\"qps\":20,\"itemCount\":1000000},\"paymentInfo\":{\"duration\":1,\"pricingCycle\":\"Month\",\"autoRenew\":true}}";
$request->setContent($content);
echo $request->$HTTP_RAW_POST_DATA;
echo $request->$_REQUEST;
echo '\n';
echo '\n';
// 6.使用 Client 对应的方法传入 Request，获得 Response。
$response = $client->getAcsResponse($request);
// 7.查看 Response 结果
echo json_encode($response);