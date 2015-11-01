<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Crypt;

/**
 * Class GDriveService
 * @package App
 */
class GDriveService
{
    /**
     * @var \Google_Client
     */
    private $client;

    /**
     * @var \Google_Service_Drive
     */
    private $gdrive;

    public function __construct(\Google_Client $client, Guard $auth)
    {
        $client->setAccessToken(Crypt::decrypt($auth->user()->token));

        $this->client = $client;

        $this->gdrive = new \Google_Service_Drive($client);
    }

    public function getCommentsByFileId($id)
    {
        $options = [
            'maxResults' => 100,
        ];

        $gdriveComments = $this->gdrive->comments->listComments($id);

        $items = $gdriveComments->getItems();

        $fileTitle = null;

        $selfLink = $gdriveComments->getSelfLink();

        $comments = [];

        foreach ($items as $item) {

            if (! $fileTitle) {
                $fileTitle = $item['fileTitle'];
            }

            $modelData = $item['modelData'];

            $comments[] = [
                'createdDate' => $item['createdDate'],
                'author' => $modelData['author'],
                'status' => $item['status'],
                'htmlContent' => $item['htmlContent'],
                'replies' => $modelData['replies'],
                'context' => $modelData['context']['value'],
                'selfLink' => $selfLink . '#' . $item['anchor'],
            ];

        }

        return $this->castToObject([
            'title' => $fileTitle,
            'comments' => $comments,
        ]);
    }

    private function castToObject(array $array)
    {
        return json_decode(json_encode($array));
    }


}
