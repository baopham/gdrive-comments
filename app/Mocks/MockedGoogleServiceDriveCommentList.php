<?php

namespace App\Mocks;

/**
 * Class MockedGoogleServiceDriveCommentList
 * @package App\Mocks
 */
class MockedGoogleServiceDriveCommentList extends \Google_Service_Drive_CommentList
{

    public function getItems()
    {
        $json = file_get_contents(__DIR__ . '/comment-items.json');

        return json_decode($json, true);
    }

    public function getSelfLink()
    {
        return 'https://google.com';
    }

}
