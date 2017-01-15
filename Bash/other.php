#!/usr/bin/php -q
<?php
/**
 * Created by PhpStorm.
 * User: lio
 * Date: 16/8/23
 * Time: 上午11:11
 */

set_time_limit(0);
//error_reporting(0);
define("INC_ROOT_PATH", dirname(dirname(__DIR__)));
$includePath = get_include_path();
set_include_path($includePath . ':' . INC_ROOT_PATH);

define('SLEEP_TIME',10);
class Search {
    public $config = [
        'parent_arr'=> array(),
        'kong'=>'',
        'exist' => false
    ];
    public function listDir_html($dir){
        if(is_dir($dir))
        {
            if ($dh = opendir($dir))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
                    {
                        echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
                        $this->listDir($dir."/".$file."/");
                    }
                    else
                    {
                        if($file!="." && $file!="..")
                        {
                            echo $file."<br>";
                        }
                    }
                }
                closedir($dh);
            }
        }
    }
    public function listDir($dir){
        if(is_dir($dir))
        {
            if ($dh = opendir($dir))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
                    {
                        echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
                        $this->listDir($dir."/".$file."/");
                    }
                    else
                    {
                        if($file!="." && $file!="..")
                        {
                            echo $file."<br>";
                        }
                    }
                }
                closedir($dh);
            }
        }
    }
    public function tree_html($directory){
        $mydir = dir($directory);
        echo "<ul>\n";
        while($file = $mydir->read())
        {
            if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
            {
                echo "<li><font color=\"#ff00cc\"><b>$file</b></font></li>\n";
                $this->tree("$directory/$file");
            }
            else
                echo "<li>$file</li>\n";
        }
        echo "</ul>\n";
        $mydir->close();
    }

    public function tree($directory){
        $mydir = dir($directory);
        if($this->config['exist']){
            echo "<ul>\n";
        }else{
            echo "<ul id='zhushi'>\n";
            $this->config['exist'] = true;
        }
        while($file = $mydir->read())
        {
            if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
            {
                echo "<li><font color=\"#ff00cc\"><b>{$file}文件夹下有</b></font></li>\n";
                $this->tree("$directory/$file");
            } elseif(($file!=".") AND ($file!="..") AND (explode('.',$file)[1] == 'sh') AND (count(explode('.',$file)) == 3)){
                //echo "<li>{$file}文件</li>\n";
                $content = file_get_contents("$directory/$file");
                $pattern = '/\/\*{2}\s*[\s\S]+?(\s*\*{1}\/)/';
                $result = array();
                $zhushi = preg_match($pattern,$content,$result);
                if(false !== $zhushi){
                    $arr = explode('*',json_encode($result,JSON_UNESCAPED_UNICODE));
                    //echo "<li>{$file}文件注释为:<br>".json_encode($result,JSON_UNESCAPED_UNICODE)."</li>\n";
                    $li = "<li class='zhushi'>{$file}文件注释为:<br>";
                    for($i=0;$i<count($arr);$i++){
                        if(!in_array($i,[0,1,2,count($arr)-1,count($arr)-2])){
                            $li.="<p style='display: none'>".preg_replace('/\//','',$arr[$i])."</p>";
                        }
                    }
                    $li.="</li>";
                    echo $li;
                }else{
                    echo "<li>{$file}文件no match hah</li>\n";
                }
            }
        }
        echo "</ul>\n";
        $mydir->close();
    }
}

$search = new Search();
while(true){
    echo "目录为粉红色\n";
    $search->tree('/Users/lio/workspace/huxintong_admin/include/crontab');
//    $search->listDir('./php_zhushi');
    sleep(SLEEP_TIME);
}