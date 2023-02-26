<?php

class DbProductOptionsManagement
{
    private const TABLE_NAME = _DB_PREFIX_ . 'wishdeliveryselection_product_options';

    /**
     * @var integer
     */
    private $id_product;

    public function __construct(int $id_product = null)
    {
        $this->id_product = $id_product;
    }

    public function getOptions(): array
    {
        $query = new DbQuery();
        $query->select('*')
            ->from(self::TABLE_NAME)
            ->where('id_product = ' . $this->id_product);

        return Db::getInstance()->executeS($query);
    }

    public function setOptions(bool $registeredEmail, bool $otherEmail, bool $sms): void
    {
        $query = 'REPLACE INTO `' . _DB_PREFIX_ . 'wishdeliveryselection_product_options`(
            `id_product`, `registered_email`, `other_email`, `sms`) VALUES (
            ' . $this->id_product . ', ' . $registeredEmail . ', ' . $otherEmail . ', ' . $sms . ')';

        // dump($this->id_product);

        Db::getInstance()->executeS($query);
    }
}
