<?php

namespace App\Mocks;

/**
 * Class MockedGoogleServiceDrive
 * @package App\Mocks
 */
class MockedGoogleServiceDrive extends \Google_Service_Drive
{
    /**
     * @var \App\Mocks\MockedGoogleServiceDriveCommentResource
     */
    public $comments;

    public function __construct($client = null)
    {
        $this->comments = new MockedGoogleServiceDriveCommentResource();
    }

}
