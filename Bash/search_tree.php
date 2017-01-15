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
        'exist' => false,
        'path' => '/Users/lio/workspace/huxintong_admin/include/crontab'
    ];

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
    $search->tree($search->config['path']);
    sleep(SLEEP_TIME);
}