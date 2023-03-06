<?php
    
    // Bắt buộc phải tạo được app, oa, composer là phải có để thục hiện sdk zalo
    // Sau khi tạo được app, oa thực hiện bước 1

    // Bước 1: mời người quan tâm oa https://oa.zalo.me/manage/fans
    
    // bắt buộc người đó phải đồng ý 

    // Bước 2: Vào api explorer chọn oa và lấy accesstoken
    
    // Bước 3: Chọn api -> oa api -> v2 -> lấy danh sách người quan tâm -> submit

    // Bước 4: lấy userid 

    // Bước 5: thực hiện code dưới đây

    require_once __DIR__ . '/vendor/autoload.php';
    // require_once 'config.php';

    use Zalo\Zalo;
    use Zalo\ZaloEndpoint;  
    use Zalo\Builder\MessageBuilder;  
    
    $config = array(
        'app_id' => '1970748527039140398',
        'app_secret' => 'WLBDvlnI3T37P9KCUfo8',
        // callback_url là đường dẫn tới file này cần đăng ký trên webhook trong app của bạn
        'callback_url' => 'https://4866b9925356.ngrok.io/apizalo/'
    );

    $zalo = new Zalo($config);

    $accessToken = '7jiSV0CUKY8HtXb_2nXP91NT4tS71ZffJwjkUIqA8YKtcmW6TXefNsscONqg6LnJUAGTToWTD2ndk2iGA0SUBKRVLZSzJqOKRibj93PsGZT5qtni1cv9I4hvQcOaTIC-QF0G9J544tfkr58Z04uVF7lzLIHXQsuM6EywEGPp438PnImtONSA1ohK9rbuHYW62FmWGNCa4tzlaWPa7n0CEsIH11Sf32yhPv5XDZamTZPRydmr8MGe6c2WDZe-42OTUw0wD6OR3nWJXpKTQ1KsJYEXDcev6nrNAlLvQWS0L2y';
  
    $msgBuilder = new MessageBuilder('text');
    $msgBuilder->withUserId("7906720282889070766");
    $msgBuilder->withText('Em Long gửi');

    $msgText = $msgBuilder->build();
    // send request
    $response = $zalo->post(ZaloEndpoint::API_OA_SEND_MESSAGE, $accessToken, $msgText);
    $result = $response->getDecodedBody(); // result


    http_response_code(200);



?>


