<?php

/**
 * @author Monei Team
 * @copyright Copyright © Monei (https://monei.com)
 */

declare(strict_types=1);

namespace Monei\MoneiPayment\Controller\Payment;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect as MagentoRedirect;
use Magento\Framework\Message\ManagerInterface;
use Magento\Sales\Api\Data\OrderInterfaceFactory;
use Monei\MoneiPayment\Api\Service\SetOrderStatusAndStateInterface;

/**
 * Monei payment fail insite controller
 */
class FailLastOrderByStatus extends Fail
{
    public function __construct(
        private readonly Context $context,
        private readonly Session $checkoutSession,
        OrderInterfaceFactory $orderFactory,
        SetOrderStatusAndStateInterface $setOrderStatusAndStateService,
        ManagerInterface $messageManager,
        MagentoRedirect $resultRedirectFactory
    ) {
        parent::__construct($context, $checkoutSession, $orderFactory, $setOrderStatusAndStateService, $messageManager, $resultRedirectFactory);

    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $order = $this->checkoutSession->getLastRealOrder();

        $request = $this->context->getRequest();
        $params = $request->getParams();
        $params['orderId'] = $order->getIncrementId();
        $request->setParams($params);

        return parent::execute();
    }
}
