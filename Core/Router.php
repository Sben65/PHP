<?php

namespace Core;

class Router 
{
    /**
     * 
     * @var array
     */
    private $_routes = [];

    /**
     * 
     * @var array
     */
    private $_params = [];

    /**
     * Fonction permettant d'obtenir les information contenue dans
     * l'url
     * @return void
     */
    public function SetRoutes(){
        if (empty($_SESSION)) {
            // On démarre la session
            session_start();
        }

        if(isset($_GET['p'])){
            $this->_params = explode('/', filter_var($_GET['p'], FILTER_SANITIZE_URL));
            $this->_routes['controller'] = $this->_params[0];
            array_shift($this->_params);
        }else {
            $this->_routes['controller'] = 'home';
        }

        if (isset($this->_params[0])) {
            $this->_routes['action'] = $this->_params[0];
            array_shift($this->_params);
        } else {
            $this->_routes['action'] = 'index';
        }
    }

    /**
     * Fonction qui permetra d'appeler le bon controller selon l'url de l'utilisateur
     * et de passer les paramètres a l'action appellé
     * @return void
     */
    public function start(){

        $this->SetRoutes();

        $controller = $this->_routes['controller'];
        $controller = $this->convertToStudlyCaps($controller);
        $controller = $this->getNamespace() . $controller;

        if (class_exists($controller)) {
            $controller_object = new $controller();

            $action = $this->_routes['action'];
            $action = $this->convertToCamelCase($action);

            if (preg_match('/action$/i', $action) == 0) {
                $controller_object->$action($this->_params);
            } else {
                throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
            }
            
        } else {
            throw new \Exception("Controller class $controller not found");
        }
        
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->_params)) {
            $namespace .= $this->_params['namespace'] . '\\';
        }

        return $namespace;
    }
}
