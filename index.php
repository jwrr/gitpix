<?php

class GitPix
{

    private function get_files($filter="*.jpg") {
        print($filter);
        $files = glob($filter);
        return $files;
    }
    
    private function get_all_files($preg_filter="/.*/") {
        $all_files = [];
        $path = "*";
        $files = glob($path);
        while (!empty($files)) {
            $all_files = array_merge($all_files, $files);
            $path .= "/*";
            $files = glob($path);
        }
        $matching_files = preg_grep ($preg_filter, $all_files);
        return $matching_files;
    }
    
    
    private function list_files($preg_filter="/.*/") {
        $files = $this->get_all_files($preg_filter);
        $html = "";
        if (!empty($files)) {
            $html .= "<ul>\n";
            foreach ($files as $file) {
                $html .= "  <li>" . "<a href='$file'>$file</a>\n";
            }
            $html .= "</ul>\n";
        }
        return $html;
    }
    
    
    public function list_jpg() {
      return $this->list_files("/jpg$/");
    }
    
    public function list_mp4() {
      return $this->list_files("/mp4$/");
    }
    

    function __construct() {
    }
}

$gp = new GitPix();

$html = "";
$html .= $gp->list_jpg();
$html .= $gp->list_mp4();
echo($html);
