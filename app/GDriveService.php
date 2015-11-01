<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;

/**
 * Class GDriveService
 * @package App
 */
class GDriveService
{

    /**
     * @var \Google_Service_Drive
     */
    private $gdrive;

    public function __construct(\Google_Service_Drive $gdrive, Guard $auth)
    {
        $this->gdrive = $gdrive;
    }

    public function getCommentsByFileId($id)
    {
        $options = [
            'maxResults' => 100,
        ];

        $gdriveComments = $this->gdrive->comments->listComments($id, $options);

        return $this->transformCommentList($gdriveComments);
    }

    private function transformCommentList(\Google_Service_Drive_CommentList $commentList)
    {
        $fileTitle = null;

        $selfLink = $commentList->getSelfLink();

        $comments = $this->transformCommentItems($commentList->getItems(), $fileTitle, $selfLink);

        return $this->castToObject([
            'title' => $fileTitle,
            'comments' => $comments,
        ]);
    }

    private function transformCommentItems(array $items, &$fileTitle, $selfLink)
    {
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

        return $comments;
    }

    private function castToObject(array $array)
    {
        return json_decode(json_encode($array));
    }


}
