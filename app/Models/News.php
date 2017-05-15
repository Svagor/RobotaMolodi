<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class News extends Model
{
    const NOT_PICTURE = 'Not picture';
    const NEWS_ON_MAIN_PAGE=10;
    private $imagePath = 'image/uploads/news/';
    private $errorsMessages;

    private $rules = array(
        'name' => 'required|max:150',
        'description' => 'required',
        'image' => 'sometimes|image|max:10240',
    );
    protected $fillable = [
        'name',
        'description',
        'img',
        'created_at',
        'updated_at',
    ];

    public static function saveImg($news){
        if(Input::file('image')) {
            $file = Input::file('image');
            $filename = time() . '-' . $file->getClientOriginalName();
            Storage::makeDirectory($news->imagePath);
            $file->move($news->imagePath, $filename);
            $news->img = $filename;
        }
    }
    
    public function deletePicture()
    {
        $exists = Storage::disk('local')->has($this->getImage());
        if ($exists)
            Storage::delete($this->getImage());

    }

    public function deleteNews()
    {
        $this->deletePicture();
        $this->delete();
    }

    public function validateForm($news)
    {
        $validatorCity = Validator::make($news, $this->rules);
        if ($validatorCity->fails()) {
            $this->errorsMessages = $validatorCity->getMessageBag()->all();
            return false;
        }
        return true;
    }

    public function getPath()
    {
        return $this->imagePath;
    }

    public function getErrorsMessages()
    {
        return $this->errorsMessages;
    }

    private function getImage()
    {
        return $this->getPath() . $this->img;
    }
    public function getNewsForMainPage()
    {
        $news = $this->latest('id')->limit(self::NEWS_ON_MAIN_PAGE)->get();
        return $news;
    }


}
