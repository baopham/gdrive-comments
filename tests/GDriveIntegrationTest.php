<?php

use App\GDriveFile;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;

/**
 * Class GDriveIntegrationTest
 */
class GDriveIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    const SEED_FILE_ID = 'foobar';

    public function test_it_can_save_a_file()
    {
        $this->login();

        $fileName = 'Test File';

        $fileId = 'y6FrWhMsitFCitPCTE2rM';

        $this->visit('/gdrive')
            ->type($fileId, 'fileId')
            ->check('save')
            ->type($fileName, 'fileName')
            ->press('Get comments');

        $this->seeInDatabase('gdrive_files', [
            'name' => $fileName,
            'id' => $fileId,
            'user_id' => $this->user->id
        ]);
    }

    public function test_it_can_see_a_list_of_saved_files()
    {
        $this->login();

        $this->seedSavedFiles();

        $this->visit('gdrive')
            ->see('All saved files')
            ->see('Seed file');
    }

    public function test_it_can_edit_a_saved_file()
    {
        $this->login();

        $this->seedSavedFiles();

        $this->visit('gdrive/files/' . static::SEED_FILE_ID . '/edit')
            ->type('New name', 'fileName')
            ->press('Save')
            ->see('File has been updated')
            ->see('New name')
            ->seeInDatabase('gdrive_files', [
                'user_id' => $this->user->id,
                'name' => 'New name',
                'id' => static::SEED_FILE_ID,
            ]);
    }

    public function test_it_can_see_a_link_to_edit_a_saved_file()
    {
        $this->login();

        $this->seedSavedFiles();

        $this->visit('gdrive')
            ->see('Seed file')
            ->click(static::SEED_FILE_ID . '-edit')
            ->see('Save');
    }

    public function test_it_can_delete_a_saved_file()
    {
        Session::start();

        $this->login();

        $this->seedSavedFiles();

        $this->delete('gdrive/files/' . static::SEED_FILE_ID, ['_token' => csrf_token()])
            ->notSeeInDatabase('gdrive_files', [
                'id' => static::SEED_FILE_ID,
            ]);
    }

    private function login()
    {
        $this->user = User::create([
            'email' => 'test@test.com',
        ]);

        $this->be($this->user);
    }

    private function seedSavedFiles()
    {
        $file = new GDriveFile;

        $file->id = static::SEED_FILE_ID;

        $file->name = 'Seed file';

        $file->user_id = $this->user->id;

        $file->save();
    }
}
