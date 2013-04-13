<?php

/**
 * Base controller
 *
 * @author Korri
 * @property qqFileUploader $qqfileuploader File Uploader
 */
class Site extends CI_Controller {

    const CHUNKS_DIR = 'assets/chunks/';
    const UPLOAD_DIR = 'assets/uploads/';
    const GENERATE_DIR = 'assets/generated/';

    public function index() {
        $this->smartyparser->parse('index.tpl');
    }

    public function upload() {
        $tempfilepath = tempnam(sys_get_temp_dir(), '');

        $this->load->library('qqfileuploader');

        $this->qqfileuploader->allowedExtensions = array();
        $this->qqfileuploader->sizeLimit = 10 * 1024; //10ko
        $this->qqfileuploader->inputName = 'qqfile';
        $this->qqfileuploader->chunksFolder = self::CHUNKS_DIR;
        $results = $this->qqfileuploader->handleUpload(self::UPLOAD_DIR);

        if (isset($results['success'])) {
            
            $this->load->library('deckconvertor');
            $content = $this->deckconvertor->convert(self::UPLOAD_DIR.$this->qqfileuploader->getUploadName());

            $this->save($this->qqfileuploader->getName(), $content);
        }

        $this->output
                ->set_content_type('application/json')
                ->append_output(json_encode($results));
    }

    private function save($filename, $content) {
        $pathinfo = pathinfo($filename);
        $newname = $pathinfo['filename'];
        $cnt = 1;
        while (file_exists(self::GENERATE_DIR . $newname . '.txt')) {
            $newname = $pathinfo['filename'] . $cnt++;
        }
        $newname = $newname . '.txt';
        file_put_contents(self::GENERATE_DIR . $newname, $content);
        return $newname;
    }

}

?>
