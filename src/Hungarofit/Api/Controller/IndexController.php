<?php

namespace Hungarofit\Api\Controller;


use SimpleXMLElement;

class IndexController extends BaseController
{
    public function versionAction()
    {
        $r = [];
        $r['php'] = phpversion();
        $extensions = ['phalcon'];
        foreach ($extensions as $extension) {
            $r[$extension] = phpversion($extension);
        }
        return $r;
    }

    public function indexAction()
    {
        return [];
    }

    public function rssAction()
    {
        $limit = $this->request->getQuery('limit', 'int', 3);
        $rss = [];
        $xml = new SimpleXMLElement(file_get_contents(
            'https://hungarofit.hu/feed',
            false,
            stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        ));
        foreach($xml->channel->item as $i) {
            if(count($rss) >= $limit) {
                break;
            }
            $rss[] = [
                'title' => (string)$i->title,
                'link' => (string)$i->link,
                'date' => (string)$i->pubDate,
            ];
        }
        return $rss;
    }


    public function fooAction()
    {
        return [
            'foo' => 'bar',
        ];
    }

}