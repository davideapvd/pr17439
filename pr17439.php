<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Pr17439 extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'pr17439';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'drc';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Pr17439');
        $this->description = $this->l('pr17439 test use case hook');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionMailAlterMessageBeforeSend');
    }

    public function hookActionMailAlterMessageBeforeSend($params)
    {
        /**
         * @var Swift_Message $message
         */
        $message = &$params['message'];
        $subject = $message->getSubject();
        $shop_name = '[' . Tools::safeOutput(Configuration::get('PS_SHOP_NAME')) . '] ';
        if (substr($subject, 0, strlen($shop_name)) == $shop_name) {
            $message->setSubject(substr_replace($subject, '', 0, strlen($shop_name)));
        }
    }
}
