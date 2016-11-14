<?php
namespace Library;

class FrontController implements FrontControllerInterface
{
    
    const DEFAULT_CONTROLLER = "IndexController";
    const DEFAULT_ACTION     = "index";
    
    protected $controller    = self::DEFAULT_CONTROLLER;
    protected $action        = self::DEFAULT_ACTION;
    protected $params        = [];
    protected $basePath      = "MediaPlatform";
    
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            $this->parseUri();
        }
        else {
            if (isset($options["controller"])) {
                $this->setController($options["controller"]);
            }
            
            if (isset($options["action"])) {
                $this->setAction($options["action"]);
            }
            
            if (isset($options["params"])) {
                $this->setParams($options["params"]);
            }
        }
    }
    
    protected function parseUri()
    {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        //$path = preg_replace('/[^a-zA-z0-9]/', "", $path);
        
        if (strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }
        $path = trim($path, "/");;
        @list($controller, $action, $params) = explode("/", $path, 3);
        
        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams(explode("_", $params));
        }
    }
    
    public function setController($controller)
    {
        $controller = 'MediaPlatform\\Controller\\' . ucfirst(strtolower($controller)) . "Controller";
        
        if (!class_exists($controller)) {
            throw new \InvalidArgumentException(
                "The action controller '$controller' has not been defined.");
        }
        $this->controller = $controller;
        return $this;
    }
    
    public function setAction($action)
    {
        $reflector = new \ReflectionClass($this->controller);
        
        if (!$reflector->hasMethod($action)) {
            throw new \InvalidArgumentException(
                "The controller action '$action' has been not defined!");
        }
        $this->action = $action;
        return $this;
    }
    
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
    
    public function run()
    {
        call_user_func_array(array(new $this->controller, $this->action), $this->params);
    }
    
}

