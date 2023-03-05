<?php 

class DbDeliveryOptionsManagement
{
    private const TABLE_NAME = 'wishdeliveryselection_orders';

    public function setOptions(
        int $idOrder,
        string $email = null,
        string $wishMessage = null,
        string $phoneNumber = null,
        string $deliveryDate = null
    ) {
        Db::getInstance()->insert(self::TABLE_NAME, [
            'id_order' => $idOrder,
            'email' => "$email",
            'wish_message' => "$wishMessage",
            'phone_number' => "$phoneNumber",
            'delivery_date' => "$deliveryDate"
        ]);
    }
}
