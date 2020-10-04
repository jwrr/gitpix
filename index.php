<?php

class GitPix
{

    private $base = "./";
    
    
    public function set_base($base) {
      $base = preg_replace("/\/*$/", "", $base);
      $this->base = $base . "\/";
    }
    

    private function get_files($filter="*.jpg") {
        $files = glob($filter);
        return $files;
    }


    private function get_all_files($preg_filter="/.*/") {
        $all_files = [];
        $path = $this->base . "*";
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
                $thumb = preg_replace("/.jpg$/", "_thumb.gif", $file);
                $html .= "  <li><img src='$thumb'>" . "<a href='$file'>$file</a></li>\n";
            }
            $html .= "</ul>\n";
        }
        return $html;
    }


    private function show_files($preg_filter="/.*/") {
        $files = $this->get_all_files($preg_filter);
        $html = "";
        if (!empty($files)) {
            $html .= "\n";
            foreach ($files as $file) {
                $pos = strpos($file, "x1024");
                if ($pos === false) continue;
                $thumb = preg_replace("/x1024.jpg$/", "x256.jpg", $file);
                $large = preg_replace("/x1024.jpg$/", "x1024.jpg", $file);
                $alt = preg_replace("/x1024.jpg$/", "", $file);
                $alt = preg_replace("/^.*\//", "", $alt);
                $alt = preg_replace("/\-(\D)/", " $1", $alt);
                $alt = preg_replace("/[_\/]/", " ", $alt);
                $alt = trim($alt);
                $html .= "  <a href='$large'><img src='$thumb' alt='$alt'></a>\n";
            }
            $html .= "\n";
        }
        return $html;
    }


    private function show_files2($preg_filter="/.*/") {
        $files = $this->get_all_files($preg_filter);
        $html = "";
        if (!empty($files)) {
            $html .= "\n";
            foreach ($files as $file) {
                $thumb = preg_replace("/.mp4$/", "_x256.jpg", $file);
                $large = $file;
                $alt = preg_replace("/.mp4$/", "", $file);
                $alt = preg_replace("/^.*\//", "", $alt);
                $alt = preg_replace("/\-(\D)/", " $1", $alt);
                $alt = preg_replace("/[_\/]/", " ", $alt);
                $alt = trim($alt);
                $html .= "  <a href='$large'><img src='$thumb' alt='$alt'></a>\n";
            }
            $html .= "\n";
        }
        return $html;
    }


    public function list_jpg() {
        return $this->list_files("/jpg$/");
    }


    public function list_mp4() {
      return $this->list_files("/mp4$/");
    }


    public function show_all_jpg() {
        return $this->show_files("/_x1024.jpg$/");
    }


    public function show_all_mp4() {
        return $this->show_files2("/mp4$/");
    }


public function echo_header() {
return <<<HEREDOC
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>xiPix</title>
  <style type="text/css">
  img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    height: 100px;
  }

  img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
  }

  h1 {
  color: maroon;
  margin-left: 40px;
  }
  </style>

</head>
<body>
HEREDOC;
} // echo_header


public function echo_footer() {
return "
</body>
</html>
";
} // echo_footer


    function __construct($base="./") {
      $base = preg_replace("/\/*$/", "", $base);
      $this->base = $base . "\/";
    }
} # class GitPix


// ============================================================================
// ============================================================================

$gp = new GitPix("./content");

$html = $gp->echo_header();
$html .= "<h2>Pictures</h2>";
$html .= $gp->show_all_jpg();
$html .= "<h2>Videos</h2>";
$html .= $gp->show_all_mp4();
echo($html);

