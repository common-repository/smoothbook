<?php
if (!defined('ABSPATH')) { exit;}

class SbOptions {
    const EMAIL = "smoothbook_email";
    const OPTIONS = "smoothbook_options";

    public static $options;

    public static function getOptions()
    {
        if (empty(self::$options)) {
            $options = get_option(self::OPTIONS);
            self::$options = (!empty($options)) ?
                json_decode($options, true) :
                array(
                    'email' => '',
                    'orgs' => array()
                );
        }
        return self::$options;
    }

    public static function setOptions($options)
    {
        self::$options = $options;
        update_option(self::OPTIONS, json_encode(self::$options));
    }

    public static function getEmail()
    {
        $options = self::getOptions();
        return $options['email'];
    }

    public static function getOrgs()
    {
        $options = self::getOptions();
        return $options['orgs'];
    }

    public static function getOrgId()
    {
        $options = self::getOptions();
        return isset($options['orgs'][0]) ? $options['orgs'][0]['orgid'] : '';
    }

    public static function getOrgName()
    {
        $options = self::getOptions();
        return isset($options['orgs'][0]) ? $options['orgs'][0]['orgname'] : '';
    }

    public static function save($form)
    {
        $email = isset($form[self::EMAIL]) ? trim($form[self::EMAIL]): '';

        self::$options = array(
            'email' => $email,
            'orgs'  => array()
        );

        if (is_email($email)) {
            // read orgs from API
            try {
                $json = file_get_contents('https://api.smoothbook.co/api/v1/user/email?email=' . urlencode($email));
                $data = json_decode($json, true);
                if (isset($data['success']) && $data['success'] == true) {
                    if (isset($data['orgs']) && is_array($data['orgs']) && count($data['orgs'])) {
                        self::setOptions(array('email' => $email, 'orgs' => $data['orgs']));
                        return;
                    } else {
                        return 'There no active organizations under your account on smoothbook.com';
                    }
                } else {
                    return (isset($data['msg'])) ? $data['msg'] : 'Please, contact plugin developer about that error.';
                }
            } catch (Exception $e) {
                return 'email address not found';
            }
        } else {
            return 'email address not found';
        }
    }
}
