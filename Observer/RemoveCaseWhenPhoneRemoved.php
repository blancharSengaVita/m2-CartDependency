<?php

namespace Produweb\CartDependency\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class RemoveCaseWhenPhoneRemoved implements ObserverInterface
{
    protected $checkoutSession;

    public function __construct(CheckoutSession $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(Observer $observer)
    {
        $skuCoque = 'CharPhone case'; // Remplace par ton SKU de coque
        $skuPhone = 'charphone_s25'; // Remplace par ton SKU de téléphone

        $quote = $this->checkoutSession->getQuote();
        $items = $quote->getAllVisibleItems();

        $hasPhone = false;
        foreach ($items as $item) {
            if ($item->getSku() === $skuPhone) {
                $hasPhone = true;
                break;
            }
        }

        if (!$hasPhone) {
            foreach ($items as $item) {
                if ($item->getSku() === $skuCoque) {
                    $quote->removeItem($item->getId());
                }
            }
            $quote->save();
        }
    }
}
