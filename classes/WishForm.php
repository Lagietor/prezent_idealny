<?php

class WishForm
{
    public function getInCartProductsIds(Cart $cart): ?array
    {
        $products = $cart->getProducts();
        $productsIds = [];

        foreach ($products as $p) {
            $productsIds[] = $p['id_product'];
        }

        return $productsIds;
    }

    public function addProductsWithNoOptions(array $productsIds, array $productsOptions): ?array
    {
        if (count($productsIds) > count($productsOptions)) {
            $diff = count($productsIds) - count($productsOptions);

            for ($i = 0; $i < $diff; $i++) {
                $productsOptions[] = [
                    'registered_email' => '0',
                    'other_email' => '0',
                    'sms' => '0'
                ];
            }
        }

        return $productsOptions;
    }

    public function getDuplicatedValues(array $productsOptions): ?array
    {
        if (count($productsOptions) > 1) {
            $productsOptions = call_user_func_array('array_intersect_assoc', $productsOptions);
        } else {
            $productsOptions = $productsOptions[0];
        }

        return $productsOptions;
    }
}
