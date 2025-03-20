<?php

namespace Produweb\CartDependency\Plugin;

use Magento\Checkout\Model\Cart;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Quote\Model\Quote;

class PreventCaseWithoutPhone
{

    public function beforeAddProduct(Cart $subject, $productInfo, $requestInfo = null)
    {
        $skuCoque = 'CharPhone case'; // Remplace par ton SKU de coque
        $skuPhone = 'charphone_s25'; // Remplace par ton SKU de téléphone

        $productSku = is_object($productInfo) ? $productInfo->getSku() : $productInfo;

        if ($productSku === $skuCoque) {
            $items = $subject->getQuote()->getAllVisibleItems();
            $hasPhone = false;

            foreach ($items as $item) {
                if ($item->getSku() === $skuPhone) {
                    $hasPhone = true;
                    break;
                }
            }

            if (!$hasPhone) {
                throw new LocalizedException(__('Vous devez ajouter un téléphone avant d’ajouter une coque.'));
            }
        }
    }
}
