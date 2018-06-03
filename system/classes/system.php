<?php

/**
 * @author Manuel Zarat
 */

class system extends core {
    
    /**
     * @todo Header Hotfix
     */
    private $current_item = false;    

    /**
     * Mit Hilfe von Hooks koennen zu bestimmten Punkten der Laufzeit - zuvor in theme/settings.php definierte - Funktionen aufgerufen werden.
     */
    private $hooks = false;
    
    /**
     * Main function
     */
    final function init() { 
        $this->setup_theme();
        if($this->has_action(__FUNCTION__)) { 
            $this->do_action(__FUNCTION__); 
        }   
        $this->theme->render();     
    }
    
    /**
     * Prueft, ob theme/functions.php vorhanden ist und wenn ja - includen
     */
    final function theme_functions() {
        if( is_file( $theme_functions = ABSPATH . 'content' . DS . 'themes' . DS . $this->settings('site_theme') . DS . 'functions.php' ) ) {
            include $theme_functions;
        }
    } 
    
    final function setup_theme() {
        if(is_file($custom_theme_file = ABSPATH . 'content' . DS . 'themes' . DS . $this->settings('site_theme') . DS . 'theme.php')) {
            include $custom_theme_file;      
            $custom_theme = $this->settings('site_theme');                       
            $this->theme = new $custom_theme;        
        } else {          
            $this->theme = new theme();                     
        } 
        $this->theme_functions();
        if($this->has_action(__FUNCTION__)) {     
            $this->do_action(__FUNCTION__);       
        }              
    }
    
    /**
     * Uebersetzt einen String aus der Sprachdatei ../system/lang/*
     */
    final function _t($str) {    
        include ABSPATH . 'system' . DS . 'lang' . DS . 'lang.php';
        if( is_file( $langfile = ABSPATH . 'system' . DS . 'lang' . DS . 'lang-' . $this->settings('site_language') . '.php' ) ) {
            include $langfile;    
        }    
        return isset($lang[$str]) ? $lang[$str] : "Error: Language file is missing or corrupt.";    
    }
    
    /**
     * @todo Priority
     */
    public final function add_action( $hook, $action ) {       
        $this->hooks[$hook][] = $action;      
    }
    
    /**
     * Prueft, ob Hooks fuer eine Funktion registriert wurden
     * 
     */
    final function has_action( $hook ) {
        return isset( $this->hooks[$hook] );
    }
    
    /**
     * @todo Priority
     */
    final function do_action( $hook ) {    
        if( isset( $this->hooks[$hook] ) ) { 
            if( is_array( $this->hooks[$hook][0] ) ) {  
                call_user_func_array( $this->hooks[$hook][0][0], array( $this->hooks[$hook][0][1] ) );  
            } else { 
                call_user_func( $this->hooks[$hook][0] );
            }                    
        }           
    }   
    
    function set_current_item($item) {
        $this->current_item = $item;
    }
    
    function get_current_item() {
        return $this->current_item;
    }

}

?>
