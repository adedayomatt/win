<?php
namespace App\Matto;
use Session;

class FileUpload{
    public $files = array();
    public $totalSuccess = 0;
    public $report = 'Something went wrong';
    public $allowed_photo = ['jpeg','png','jpg','JPG','gif','svg'];
    public $allowed_video = ['mp4'];
    private $request;
    private $name;
    private $title;
    private $path;
    
    public function __construct($request,$name = 'file',$title = '',$path = 'public/images'){
        $this->request = $request;
        $this->name = $name;
        $this->title = ($title == '' ? 'file-'.time() : $title);
        $this->path = $path;

        if(is_array($request->$name)){
            $files = $request->$name;
            for($i = 0; $i<count($files); $i++){
               if($this->upload($files[$i],str_slug($this->title.'-'.$i.'-'.time()))){
                    $this->totalSuccess++;
               }
            }
        }
        else{
            if($this->upload($request->$name,str_slug($this->title))){
                $this->totalSuccess = 1;
             }
        }
            
        $this->report =  $this->totalSuccess.' files uploaded';;
         }

    private function upload($filebag,$nameToStore){
            $uploaded = false;
            $allowed = array_merge($this->allowed_photo, $this->allowed_video);
            if($filebag !== null){
                //Get file with the extension_loaded
                $fileNameWithExt = $filebag->getClientOriginalName();
                //Get just filename
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //Get Extension
                $fileExt = $filebag->getClientOriginalExtension();
                //Filenames to store
                $slug = $nameToStore.".$fileExt";
            
                if(in_array($fileExt,$allowed)){
                    //Upload file
                    $fileType = in_array($fileExt, $this->allowed_photo) ? 'photo' : (in_array($fileExt, $this->allowed_video) ? 'video' : null);
                    if($filebag->storeAs($this->path,$slug)){
                        array_push($this->files, ['slug' => $slug, 'type' => $fileType]);
                        $uploaded = true;
                    }
                }
                
            }
                return $uploaded;

    }
        
}
?>