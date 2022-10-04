<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author leos
 */
class Message {

    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';
    const TYPE_INFO = 'info';

    private static $_messages = array();
    private static $_modals = array();

    public static function modal($modal, $redirect = null) {
        self::setModal($modal);
        if (isset($redirect))
            self::redirect($redirect);
    }

    public static function success($message, $redirect = null) {
        self::setMessage($message, self::TYPE_SUCCESS);
        if (isset($redirect))
            self::redirect($redirect);
    }

    public static function error($message, $redirect = null) {
        self::setMessage($message, self::TYPE_ERROR);
        if (isset($redirect))
            self::redirect($redirect);
    }

    public static function info($message, $redirect = null) {
        self::setMessage($message, self::TYPE_INFO);
        if (isset($redirect))
            self::redirect($redirect);
    }

    public static function setMessage($message, $type) {
        self::$_messages = Session::get('flashMessages');
        self::$_messages[$type] = (array) $message;
        Session::set('flashMessages', self::$_messages);
    }

    public static function getMessages($type) {
        self::$_messages = Session::get('flashMessages');
        $messages = self::$_messages[$type];
        self::$_messages[$type] = '';
        Session::set('flashMessages', self::$_messages);
        return implode('<br/>', (array) $messages);
    }

    public static function setModal($modal) {
        self::$_modals = Session::get('flashModals');
        self::$_modals[] = $modal;
        Session::set('flashModals', self::$_modals);
    }

    public static function getModals() {
        self::$_modals = Session::get('flashModals');
        $modals = self::$_modals;
        self::$_modals = array();
        Session::set('flashModals', self::$_modals);
        return (array) $modals;
    }

    public static function redirect($url) {
        if (!$url)
            $url = $_SERVER['REQUEST_URI'];
        header('Location: ' . $url);
        exit();
    }

}

?>
