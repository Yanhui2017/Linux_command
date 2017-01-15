#!/usr/bin/php -q
<?php
/**
 * 一定要在这里加注释哦
 * Created by PhpStorm.
 * User: lio
 * Date: 16/8/23
 * Time: 上午11:11
 */

set_time_limit(0);
error_reporting(0);
define("INC_ROOT_PATH", dirname(dirname(dirname(__DIR__))));
$includePath = get_include_path();
set_include_path($includePath . ':' . INC_ROOT_PATH);

define('SLEEP_TIME',10);


include_once('config/config.inc.php');
include_once('lib/functions.php');
include_once('config/autoload.inc.php');
include_once('lib/Hxservice/autoload.php');

date_default_timezone_set(System::get('timezone'));

//有借款订单抓取理财债权，建议每天执行一次

class payStatus extends BrdBase{
    public $db;

    //构造/初始化数据库对象
    public function __construct()
    {
        $this->db = self::__instance();
    }

    //生产者
    public function getItems(){
        $db = $this->db;
        $condition = [
            "AND"=>[
                'brd_qb_pay_req.status' => 9,
                'brd_qb_loan.status' => 4
            ]
        ];
        $fields = [
            'brd_qb_pay_req.order_no'
        ];
        $join = [
            "[>]brd_qb_loan" => [
                "order_no"=>"loan_no"
            ]
        ];
        $items = $db->select('brd_qb_pay_req',$join,$fields,$condition);
        return $items;
    }

    //消费者
    public function setItme(){
        $db = $this->db;
        $loans = array_column(self::getItems(),'order_no');
        if(!empty($loans)){
            $condition = [
                'loan_no' => $loans
            ];
            $set = [
                'pay_status' => 2
            ];
            $db->update('brd_zq',$set,$condition);
        }
    }
}

$pat_status = new PayStatus();

while(true){
    $pat_status->setItme();
    sleep(SLEEP_TIME);
}