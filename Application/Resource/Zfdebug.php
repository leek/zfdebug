<?php

class ZFDebug_Application_Resource_Zfdebug extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return void
     */
    public function init()
    {
        $options = $this->getOptions();

        // Cache
        if ($this->getBootstrap()->hasPluginResource('Cache')) {
            $this->getBootstrap()->bootstrap('Cache');
            $cacheResource = $this->getBootstrap()->getPluginResource('Cache');
            foreach ($options['plugins'] as $key => $plugin) {
                if (empty($plugin)) {
                    $plugin = $key;
                }
                if (strtolower($plugin) == 'cache') {
                    $options['plugins']['Cache'] = array('backend' => $cacheResource->getCacheObject()->getBackend());
                }
            }
        }

        // Db
        if ($this->getBootstrap()->hasPluginResource('Db')) {
            $this->getBootstrap()->bootstrap('Db');
        }

        // MultiDb
        if ($this->getBootstrap()->hasPluginResource('Multidb')) {
            $this->getBootstrap()->bootstrap('Multidb');
            /* @var $multiDbResource Zend_Application_Resource_Multidb */
            $multiDbResource = $this->getBootstrap()->getPluginResource('Multidb');
            foreach ($options['plugins'] as $key => $plugin) {
                if (empty($plugin)) {
                    $plugin = $key;
                }               
                if (is_string($plugin) && strtolower($plugin) == 'database') {
                    $dbArray = array();
                    foreach ($multiDbResource->getOptions() as $dbKey => $dbOptions) {
                        $dbArray[] = $multiDbResource->getDb($dbKey);
                    }
                    $options['plugins']['Database'] = array('adapter' => $dbArray);
                }
            }
        }

        // Fix plugins
        $options['plugins'] = $this->_fixPluginsArray($options['plugins']);

        // Load plugin
        $this->getFrontController()->registerPlugin(
            new ZFDebug_Controller_Plugin_Debug($options)
        );
    }

    /**
     * Some plugins need an array sent to the constructor
     * Fix the ones that don't
     *
     * @param array $plugins
     * @return array
     */
    private function _fixPluginsArray(array $plugins = array())
    {
        $needArray = array(
            'cache',
            'database',
            'file',
        );

        foreach ($plugins as $pluginKey => &$pluginValue) {
            if (in_array(strtolower($pluginKey), $needArray) && !is_array($pluginValue)) {
                $pluginValue = array();
            }
        }

        return $plugins;
    }

    /**
     * Retrieve front controller instance
     *
     * @return Zend_Controller_Front
     */
    public function getFrontController()
    {
        if (null === $this->_front) {
            $this->_front = Zend_Controller_Front::getInstance();
        }
        return $this->_front;
    }
}
