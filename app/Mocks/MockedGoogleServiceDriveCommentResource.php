<?php

namespace App\Mocks;

/**
 * Class MockedGoogleServiceDriveCommentResource
 * @package App\Mocks
 */
class MockedGoogleServiceDriveCommentResource
{
    public function listComments($fileId, $options)
    {
        return new MockedGoogleServiceDriveCommentList();
    }

}
