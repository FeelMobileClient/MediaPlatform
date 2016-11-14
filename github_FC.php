<?php
namespace Framework;

/**
 * Front controller - routes all request and dispatch it to modules.
 * (MVC pattern)
 * @package FrameWork
 * @subpackage FrontController
 * @author Tomislav Biscan
 * @version 0.1
 */
class FrontController
{
    protected $namespace = "";
    
    public function __construct($namespace = "")
    {
        $this->namespace = $namespace . "\\Controller\\";
    }
    	
    /**
     * Front controller loader
     */
    public function load()
    {
        //$this->fetchGetMethod();
        $controller = $this->routeFrontToController();
        if(isset($controller)) return $this->dispatch($controller);
        else return '404 - router has nothing';
    }
	
    /**
     * Method for routing request with controller
     * @return array controller specs
     */
    protected function routeFrontToController()
    {
        $urlArray = $this->parseUrlRequest();
        $urlBuilder = $this->urlBuilder();
        if(!$urlArray && isset($urlBuilder['']))
        {
            return $this->compareControllerWithUrl(array('frontcontroller' => array(
            'url' => '',
            'controller' => 'Home',
            'action' => 'view'
            )), '');
        }
        elseif(isset($urlBuilder[$urlArray['controller']]))
        {
            return $this->compareControllerWithUrl($urlBuilder[$urlArray['controller']], $urlArray['params']);
        }
            elseif(isset($urlBuilder['*']) && !isset($urlArray['params']))
        {
            return array(
                'url' => '',
                'controller' => 'Content',
                'action' => 'view',
                'params' => array('contentUrl' => $urlArray['controller'])
            );
        }
        else
        {
            return array(
                'url' => ':contentUrl',
                'controller' => 'Error404',
                'action' => 'view',
                'params' => array('requestedUrl' => '404')
            );
        }
    }

    /**
     * Parsing request to parameter array
     * @return array $front
     */
    protected function parseUrlRequest()
    {
        $url = '';
        if(isset($_REQUEST['rewrite'])) $url = $_REQUEST['rewrite'];

        $config = Registry::fetch('config');
        $multiLanguage = $config->multiLanguage();
        $session = Registry::fetch('session');

        if($url == '') 
        {
            if($multiLanguage) $session->language = $config->defaultLanguage;
            return false;
        }

        if(substr($url, -1, 1) == '/') StatusCodes::permanentRedirect('/' . substr($url, 0, strlen($url)-1));
        $url = explode('/', $url);
        $front = array();
        $count = count($url);
        
        /**
         * Multilangauge site begins with language name
         */
        if($multiLanguage)
        {
            if(!in_array(strtolower($url[0]), $multiLanguage))
                return array('url' => ':contentUrl', 'controller' => 'Error404', 'action' => 'view', 'params' => array('requestedUrl' =>'Error404'));
            Registry::fetch('session')->language = strtolower($url[0]);
            if($count == 1 && $url[0] == $config->defaultLanguage) StatusCodes::permanentRedirect('/');
            if(!isset($url[1])) return false;
            $front['controller'] = $url[1];
            if($count > 2)
            {
            $front['params'] = array();
            for($i = 2; $i < $count; ++$i) $front['params'][] = $url[$i];
            }
        }
        else
        {
            $front['controller'] = $url[0];
            if($count > 1)
            {
            $front['params'] = array();
            for($i = 1; $i < $count; ++$i) $front['params'][] = $url[$i];
            }
        }
        
        return $front;
    }
    
    /**
     * Compares url array and controller array and returns
     * matched controller array with url parameters 
     * @param array $module
     * @param array $url
     * @return array controller details and url params
     */
    protected function compareControllerWithUrl($controller, $url)
    {
        if($url == '')
        {
            foreach($controller as $key => $value) if($value['url'] == '') return $controller[$key];
            /**
             * If controller version without url params does not exists - show 404
             */
            return array('url' => ':contentUrl', 'controller' => 'Error404', 'action' => 'View');
        }
        
        $count = count($url);
        
        foreach($controller as $key => $value)
        {	
            $match = 0;
            $controller[$key]['params'] = isset($value['params']) ? $value['params'] : null;
            $controllerParam = explode('/', $value['url']);
            if($count == count($controllerParam) && $value['url'] != '')
            {
                foreach($controllerParam as $controllerKey => $controllerValue)
                {
                    if($controllerValue{0} == '*')
                    {
                        ++$match;
                        continue;
                    }
                    if($controllerValue{0} == ':')
                    {
                        $controller[$key]['params'][substr($controllerValue, 1)] = $url[$controllerKey];
                        ++$match;
                        continue;
                    }				
                    if($controllerValue == $url[$controllerKey]) ++$match;
                    else break;
                }
            }
            
            if($match == $count) return $controller[$key];
        }
        
        /**
         * 404 behavior if none matched
         */
        return array('url' => ':contentUrl', 'controller' => 'Error404', 'action' => 'view');
    }
    
    /**
     * Dispatch parameters to module
     * @param array $params
     */
    protected function dispatch($params)
    {
        $config = Registry::fetch('config');
        $controllerName = $this->namespace . $params['controller'];
        $controllerObject = new $controllerName($params['action'], isset($params['params']) ? $params['params'] : false);
        
        Registry::fetch('session')->saveSession();
    }
    
    /* URL Builder
     * controller, action, parameters syntax:
     * url:
     * abc - any string for matching
     * :abc - param name
     * * - wildcard (ignore field)
     * @return array url list
     * @todo put this method as abstract - each site need to
     * have it's own implementation
     *
     * protected function urlBuilder()
     * {
     *return array('vijesti' => array(
     *array('url' => 'arhiva/kategorija/:categoryId/*',
     * 'controller' => 'news',
     * 'action' => 'view'),
     *array('url' => 'kategorija/:categoryId/*', 'module' => 'news', 'controller' => 'category', 'action' => 'view'),
     * array('url' => 'stranica/:controller',
     * 'controller' => 'news',
     * 'action' => 'view'),
     * array('url' => 'uredi/:controllerId',
     * 'controller' => 'news',
     *	 'action' => 'edit'),
     * array('url' => 'uredi',
     *	 'controller' => 'news',
     * 'action' => 'read'),
     *	 array('url' => 'tguz/:someId',
     *	 'controller' => 'news',
     *	 'action' => 'edit'),
     *	 array('url' => '',
     * 'controller' => 'news',
     *	 'action' => 'view')),
     *	'oglas' => array(
     *	array('url' => '', 'controller' => 'classifieds', 'action' => 'view'),
     *	array('url' => 'kategorija/:categoryId/* /:controller/:sort', 'controller' => 'classifieds', 'action' => 'view'))
     *	);
     *  } 
     */
    
    protected function urlBuilder()
    {
        return Registry::fetch('config')->urlBuilder();
    }
    
    /**
     * Set's the missing rewrite $_GET variables into $_REQUEST
     */
    /*protected function fetchGetMethod()
    {
    $uri = $_SERVER['REQUEST_URI'];
    $pos = strpos($uri, '?');
    if($pos !== false)
    {
    $uri = substr($uri, ($pos+1));
    $getAll = explode("&", $uri);
    foreach($getAll as $key => $singleGet)
    {
    list($variable, $value) = explode("=", $singleGet);
    if($variable && $value)
    {
    $_REQUEST[$variable] = $value;
    $_GET[$variable] = $value;
    }
    }
    }
    }*/


}
