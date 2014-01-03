<?php
namespace Barany\GooglePlusToFacebook;

use Google_Service_Plus_Activity;

class Facebook {
    const ENDPOINT = 'https://graph.facebook.com/';

    private $config;

    public function __construct(FacebookConfig $config) {
        $this->config = $config;
    }

    public function postFromGooglePlus(array $posts) {
        /* @var $post Google_Service_Plus_Activity */
        foreach ($posts as $post) {
            $object = $post->getObject();
            if ($object['objectType'] != 'note') {
                continue;
            }

            $data = null;
            if (count($object['attachments']) > 0) {
                foreach ($object['attachments'] as $attachment) {
                    if ($attachment['objectType'] != 'article') {
                        continue;
                    }

                    $data = array(
                        'link' => $attachment['url'],
                    );
                    //Convert <br> to \n and strip html tags
                    $message = strip_tags(preg_replace('/<br(\s+)?\/?>/i', "\n", $object['content']));
                    if ($message != $attachment['url']) {
                        $data['message'] = $message;
                    }
                    $this->post($data);
                    break;
                }
            } else {
                $this->post(
                    array(
                        'message' => $object['content'],
                    )
                );
            }
        }
    }

    private function post(array $post_data) {
        $url = self::ENDPOINT . $this->config->getUserId() . '/feed';
        $post_fields = 'access_token=' . $this->config->getAppAccessToken();
        foreach ($post_data as $k => $v) {
            $post_fields .= '&' . $k . '=' . urlencode($v);
        }
        $this->doCurl($url, $post_fields);
    }

    private function doCurl($url, $post_fields) {
        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_POST, true);
        curl_setopt($s, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_exec($s);
        curl_close($s);
    }
}
