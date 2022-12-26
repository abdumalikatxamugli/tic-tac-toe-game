<?php
namespace App\Controllers;

use App\View;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;

class UserController extends Controller
{
    public function photoUpload()
    {
        return View::make('photoUpload');
    }
    public function photoUploadSave()
    {
        
        $storage = new \Upload\Storage\FileSystem(__DIR__."/../../public/storage");
        $file = new \Upload\File('photo', $storage);

        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName($new_filename);

        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations(array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype('image/png'),

            //You can also add multi mimetype validation
            //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size('2M')
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        // Try to upload file
        try {
            // Success!
            $file->upload();
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
        }
        if( isset($errors) && count($errors) )
        {
            $data['errors'] = $errors;
            return View::make('photoUpload', $data);
        }
        $profile_photo_path = $file->getName().".".$file->getExtension();
        $user = user();
        $user->profile_photo_path = $profile_photo_path;
        $user->save();
        return $this->redirect("/");
    }
    public function createGroup()
    {
        $data['users'] = User::all();
        $data['groups'] = Group::all();
        return View::make('create_group', $data);
    }
    public function saveGroup()
    {
        $postedData = $_POST;
        if( Group::where('name', $postedData['name'])->first() )
        {
            $data['error'] = "Name is already in use. Please try another one";
            $data['users'] = User::all();
            $data['groups'] = Group::all();
            return View::make('create_group', $data);
        }
        $group = new Group();
        $group->name = $postedData['name'];
        $group->created_by = user()->id;
        $group->parent_group_id = $postedData['parent_group_id']??null;
        $group->save();
        if(isset($postedData['members']))
        {
            foreach($postedData['members'] as $user_id)
            {
                UserGroup::link($user_id, $group->id);
            }
        }
        return $this->redirect('/');
    }    
}