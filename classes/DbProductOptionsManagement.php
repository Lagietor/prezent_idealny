<?php

class DbProductOptionsManagement
{
    private const TABLE_NAME = 'wishdeliveryselection_product_options';

    public function getProductOptions(int $idProduct): array
    {
        $query = new DbQuery();
        $query->select('registered_email, other_email, sms')
            ->from(self::TABLE_NAME)
            ->where('id_product = ' . $idProduct);

        $result = (Db::getInstance()->getRow($query));

        if (!is_array($result)) {
            $result = [];
        }

        return $result;
    }

    public function getProductsOptions(array $idsProducts): array
    {
        $conditions = 'id_product = ' . implode(' || id_product = ', $idsProducts);
        // dump($conditions);
        // die;

        $query = new DbQuery();
        $query->select('registered_email, other_email, sms')
            ->from(self::TABLE_NAME)
            ->where($conditions);

        $result = Db::getInstance()->executeS($query);

        return $result;
    }

    public function setOptions(int $idProduct, bool $registeredEmail, bool $otherEmail, bool $sms): void
    {
        $query = 'REPLACE INTO `' . _DB_PREFIX_ . self::TABLE_NAME . '`(
            `id_product`, `registered_email`, `other_email`, `sms`) VALUES (
            ' . $idProduct . ', ' . (int)$registeredEmail . ', ' . (int)$otherEmail . ', ' . (int)$sms . ')';

        Db::getInstance()->executeS($query);
    }
}
