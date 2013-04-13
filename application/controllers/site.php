<?php

/**
 * Base controller
 *
 * @author Korri
 * @property qqFileUploader $qqfileuploader File Uploader
 */
class Site extends CI_Controller {

    const CHUNKS_DIR = 'assets/chunks/';
    const TEMP_DIR = 'assets/uploads/';
    const GENERATE_DIR = 'assets/generated/';

    public function index() {
        $this->smartyparser->parse('index.tpl');
    }
    
    public function cron() {
        $allowed_ips = array('127.0.0.1', $this->input->server('SERVER_ADDR'));
        if(in_array($this->input->server('REMOTE_ADDR'), $allowed_ips)) {
            //Remove all old generated file (1 hour)
            if (($handle = opendir(self::GENERATE_DIR))) {
                while (false !== ($file = readdir($handle))) {
                    if(substr($file, 0, 1) == '.') continue;
                    if (filectime(self::GENERATE_DIR . $file) <= time() * 60 * 60) {
                        unlink(self::GENERATE_DIR . $file);
                    }
                }
                closedir($handle);
            }
            die('ok');
        }else {
            show_404();
        }
    }
    
    public function upload() {

        $this->load->library('qqfileuploader');

        $this->qqfileuploader->allowedExtensions = array();
        $this->qqfileuploader->sizeLimit = 10 * 1024; //10ko
        $this->qqfileuploader->inputName = 'qqfile';
        $this->qqfileuploader->chunksFolder = self::CHUNKS_DIR;
        $results = $this->qqfileuploader->handleUpload(self::TEMP_DIR);

        if (isset($results['success'])) {

            $this->load->library('deckconvertor');
            $content = $this->deckconvertor->convert(self::TEMP_DIR . $this->qqfileuploader->getUploadName());
            unlink(self::TEMP_DIR . $this->qqfileuploader->getUploadName());

            $newnames = $this->save($this->qqfileuploader->getName(), $content);

            $results['name'] = $newnames;
        }

        $this->output
                ->set_content_type('application/json')
                ->append_output(json_encode($results));
    }

    private function save($filename, $content) {
        $pathinfo = pathinfo($filename);
        $newname = $pathinfo['filename'];
        $newname = $this->_clean_name($newname);
        $cnt = 1;
        while (file_exists(self::GENERATE_DIR . $newname . '.txt')) {
            $newname = $this->_clean_name($pathinfo['filename'] . $cnt++);
        }
        $newname = $newname . '.txt';
        file_put_contents(self::GENERATE_DIR . $newname, $content);
        return array(
            'newname' => $pathinfo['filename'] . '.txt',
            'realname' => $newname
        );
    }

    public function download($realname, $newname) {
        //Just in case
        $realname = $this->_clean_name($realname);

        if (!file_exists(self::GENERATE_DIR . $realname)) {
            show_404();
        }

        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$newname\"");

        readfile(self::GENERATE_DIR . $realname);
        exit();
    }

    public function download_all($card_ = false) {
        $zipfilename = tempnam(self::TEMP_DIR, 'ZIP');

        //We don't want the zip file to stay here
        ignore_user_abort(true);
        $zip = new ZipArchive();
        $zip->open($zipfilename, ZipArchive::CREATE);

        $cards = $this->input->post('cards');


        if (count($cards) > 100) {
            show_error('Sorry, you can only download 100 files at a time');
        } else if (empty($cards)) {
            show_404();
        }
        $filenames = array();
        foreach ($cards as $card) {
            list($realname, $newname) = explode(':', $card, 2);
            //Just in case
            $realname = $this->_clean_name($realname);

            //We want unique names only
            $k = 1;
            $pathinfo = pathinfo($newname);
            while (isset($filenames[$newname])) {
                $newname = $pathinfo['filename'] . $k++ . '.' . $pathinfo['extension'];
            }
            $filenames[$newname] = true;

            //Add file to zip
            if (file_exists(self::GENERATE_DIR . $realname)) {
                $zip->addFile(self::GENERATE_DIR . $realname, $newname);
            }
        }
        $zip->close();

        header("Content-Description: File Transfer");
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=\"decks.zip\"");
        header('Content-Length: ' . filesize($zipfilename));

        ob_clean();
        flush();

        readfile($zipfilename);
        unlink($zipfilename);
        exit();
    }

    private function _clean_name($filename) {
        $pathinfo = pathinfo(urldecode($filename));
        $ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
        return url_title($pathinfo['filename']) . ( $ext ? '.' . $ext : '');
    }

}
