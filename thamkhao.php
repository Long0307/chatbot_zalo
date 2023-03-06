
<?php

namespace App\SocialiteConnector\Zalo;

use App\SocialiteConnector\Connector as SocialiteConnectorConnector;
use GuzzleHttp\Client as HttpClient;

class ZaloConnector implements SocialiteConnectorConnector
{
    private $httpClient;

    public function getAccessToken()
    {
        return env('ZALO_TOKEN', 'grEmCKVUf6IWLBWuHD-XOQDTj3fEoV4ZgoIT9nQptYkFJRvtOv3qKy1fb7rNWl8ZpM2E8ZI9-GRLHwmkLQxaU-vayNW9kRKZXtF02pwJeYExKyuc69gRE8j5mJqGieffh5trIWYuWN-MGzrDTx_6MErLhMTcgDavn72j1dQThIwLKBW808325gDYjJenlyq4rcQBK6I5p5c6NA9m6jV6RA4Zh6H1h-XGtNELHN2woHdrHQWQMxRIBk1biGT1gQfU_bpAIHlKgKQk3V5AFVIMIz4_x15nrBejRKp7h6K');
    }

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getProfile($user)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://openapi.zalo.me/v2.0/oa/getprofile',
            [
                'query' => [
                    'access_token' => $this->getAccessToken(),
                    'data' => json_encode([
                        'user_id' => $user
                    ], true)
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );
        $responseText = $response->getBody()->getContents();
        $data = json_decode($responseText, true);
        if ($data['error'] != 0) {
            throw new ZaloException($responseText);
        }
        return $data;
    }

    public function getUserId($user)
    {
        $user = $this->getProfile($user);
        return $user['data']['user_id'];
    }



    public function sendMessage($user, $message, $imageUrl = null, $link = null)
    {
        if (!$imageUrl && !$link) {
            $message = [
                'text' => $message
            ];
        }
        if ($imageUrl && !$link) {
            $message = [
                'text' => $message,
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'media',
                        'elements' => [
                            [
                                'media_type' => 'image',
                                'url' => $imageUrl
                            ]
                        ]
                    ]
                ]
            ];
        }
        if (!$imageUrl && $link) {
            $message = [
                'text' => $message,
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'buttons' => [
                            [
                                'title' => 'Xem chi tiết',
                                'payload' => [
                                    'url' => $link
                                ],
                                'type' => 'oa.open.url'
]
                        ]
                    ]
                ]
            ];
        }
        if ($imageUrl && $link) {
            $message = [
                'text' => $message,
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'media',
                        'elements' => [
                            [
                                'media_type' => 'image',
                                'url' => $imageUrl
                            ]
                        ],
                        'buttons' => [
                            [
                                'title' => 'Xem chi tiết',
                                'payload' => [
                                    'url' => $link
                                ],
                                'type' => 'oa.open.url'
                            ]
                        ]
                    ]
                ]
            ];
        }
        $response = $this->httpClient->request(
            'POST','https://openapi.zalo.me/v2.0/oa/message',
            [
                'query' => [
                    'access_token' => $this->getAccessToken()
                ],
                'json' => [
                    'recipient' => [
                        'user_id' => $user
                    ],
                    'message' => $message
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]
        );
        $responseText = $response->getBody()->getContents();
        $data = json_decode($responseText, true);
        if ($data['error'] != 0) {
            throw new ZaloException($responseText);
        }
        return $data;
    }
}