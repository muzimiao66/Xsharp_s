<?php
/**
 * lgsec1.0
 * @author lgs
 * @time 2018/8/2
 */


//app 目录地址 
if(!define('APP_DIR')){
    define('APP_DIR', ROOT_DIR.'/app');
}
//public 目录地址
if(!define('PUBLIC_DIR')){
    define('PUBLIC_DIR',ROOT_DIR.'/public');
}
//预留了 ecae_mode 变量预定义
error_reporting(E_ALL ^ E_NOTICE);

//ego version 加密文件
if(file_exists(ROOT_DIR.'/app/base/ego/ego.php')){
    require_once (ROOT_DIR.'/app/base/ego/ego.php');
}

//定义系统常量 配置
define('LOG_SYS_EMERG',0);
define('LOG_SYS_ALERT', 1);
define('LOG_SYS_CRIT', 2);
define('LOG_SYS_ERR', 3);
define('LOG_SYS_WARNING', 4);
define('LOG_SYS_NOTICE',5);
define('LOG_SYS_INFO', 6);
define('LOG_SYS_DEBUG', 7);

class kernel
{  
    static $base_url = null;
    static $url_app_map = array();
    static $app_url_map = array();
    static $console_output = FALSE;
    static private $__online = NULL;
    static private $__router = NULL;
    static private $__db_instance = NULL;
    static private $__request_instance = NULL;
    static private $__single_apps = array();
    static private $__service_list = array();
    static private $__base_url = array();
    static private $__language = NULL;
    static private $__service = array();
    static private $__require_config = NULL;
    static private $__host_mirrors = NULL;
    static private $__host_mirrors_count = NULL;
    
    //核心路由处理函数
    static function boot(){
//         set_error_handler(array('kernel','exception_error_handler'));
        echo '这是boot';
//         try {
//             if(!self::register_au){
                
//             }
//         }catch (){
            
//         }
    }
    
    static function exception_error_handler($errno,$errstr,$errfile,$errfile,$errline){
        
    }
    
    static function router(){
        
    }
    
    static function openapi_url(){
        
    }
    
    static function request(){
        
    }
    
    static function url_prefix(){
        
    }
    
    static function this_url(){
        
    }
    
    static private function get_host_mirror(){
        
    }
    
    static function get_themes_host_url(){
        
    }
    
    static function get_app_statics_host_url(){
        
    }
    
    static function base_url($full){
        
    }
    
    static function set_online($mode){
        
    }
    
    static function is_online(){
        
    }
    
    static function single($class_name,$arg=null){
        
    }
    
    static function database(){
        
    }
    
    static function service($srv_name,$filter=null){
        return self::servicelist($srv_name,$filter)->cuttnet();
    }
    
    static function servicelist($srv_name,$filter=null){
//         if(){
            
        
//         }

    }
    
    static function strip_magic_quotes(&$var){
        
    }
    
    //注册类自动加载函数
    static function register_autoload($load=array('kernel','autoload')){
        if (function_exists('spl_autoload_register')){
            return spl_autoload_register($load);
        }else {
            return false;
        }
    }
    
    //取消注册 类自动加载函数
    static function unregister_autoload($load=array('kernel', 'autoload')){
        if (function_exists('spl_autoload_register')){
            return spl_autoload_unregister($load);
        }else {
            return false;
        }
    }
    
    static function autoload($class_name)
    {
        //$p b2c_ctl_wap_brand
        //$p b2c_mdl_cart
        //b2c_order_cancel
        $p = strpos($class_name,'_');
        if($p){
            $owner = substr($class_name,0,$p);
            $class_name = substr($class_name,$p+1);
            $tick = substr($class_name,0,4);
            switch ($tick){
                case 'ctl_':
                    if (define('CUSTOM_CORE_DIR') && file_exists(CUSTOM_CORE_DIR.'/'.$owner.'/controller/'.
                    str_replace('_','/',substr($class_name, 4).'.php'))){
                        $path = CUSTOM_CORE_DIR.'/'.$owner.'/controller/'.str_replace('_','/', substr(
                        $class_name, 4)).'.php';
                    }else {
                        $path = APP_DIR.'/'.$owner.'/controller/'.str_replace('_','/',substr($class_name, 4)).
                        '.php';
                    }
                    if(file_exists($path)){
                        return require_once $path;
                    }else{
                        throw new Exception('Don\'t find controller file');
                        exit;
                    }
                case 'mdl_':
                    if(defined('CUSTOM_CORE_DIR') && file_exists(CUSTOM_CORE_DIR.'/'.$owner.'/model/'.
                    str_replace('_', '/', substr($class_name, 4)).'.php')){
                        $path = CUSTOM_CORE_DIR.'/'.owner.'/model/'.str_replace('_', '/',substr($class_name, 4)).'.php';
                    }else {
                        $path = APP_DIR.'/'.$owner.'/model/'.str_replace('_', '/', substr($class_name, 4)).'.php';
                    }
                    if(file_exists($path)){
                        return require_once $path;
                    }elseif (file_exists(APP_DIR.'/'.$owner.'/dbschema/'.substr($class_name, 4).'.php') || 
                        file_exists(CUSTOM_CORE_DIR.'/'.$owner.'/dbschema/'.substr($class_name, 4).'.php')){
                        
                    }
                default:
                    if(defined('CUSTOM_CORE_DIR') && file_exists(CUSTOM_CORE_DIR.'/'.$owner.'/lib/'.
                    str_replace('_', '/', $class_name).'.php')){
                        $path = CUSTOM_CORE_DIR.'/'.$owner.'/lib/'.str_replace('_', '/', $class_name).
                        '.php';
                    }else{
                        $path = APP_DIR.'/'.$owner.'/lib/'.str_replace('_', '/',$class_name).'.php';
                    }
                    if(file_exists($path)){
                        return require_once $path;
                    }else {
                        throw new Exception('Don\'t find lib file "'.$owner.'_'.$class_name.'"');
                        return false;
                    }
            }
        }elseif (file_exists($path = APP_DIR.'/base/lib/static/'.$class_name.'.php')){
            if(defined('CUSTOM_CORE_DIR') && file_exists(CUSTOM_CORE_DIR.'/base/lib/static/'.
                $class_name.'.php')){
                $path = CUSTOM_CORE_DIR.'/base/lib/static/'.$class_name.'.php';
            }
            return require_once $path;
        }else {
            throw new Exception('Don\'t find static file "'.$class_name.'"');
            return false;
        }
        
    }
    //设置平台语言
    static public function set_lang($language){
        self::$__language = trim($language);
    }
    
    //获取平台展示语言
    static public function get_lang()
    {
        return self::$__language ? self::$__language : ((define('LANF')&&constant('LANG'))?LANG:'zh_CN');
    }
    
}

//未知gettext.inc 文件作用
if(!function_exists('gettext')){
    require_once(APP_DIR.'/base/lib/static/gettext.inc');
}

//加载“__”函数
if(!function_exists('__')){
    function __($str){
        return $str;
    }
}
