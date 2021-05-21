<?php

namespace MyStore2;
use MyStore2\Http\Request;
use MyStore2\Entities\Queue;
use MyStore2\Entities\Visit;
use MyStore2\Entities\Order;


class App
{
    private Request $request;
    private Queue $queue;
    //private Visit $visit;
    //private Order $order;

    public function __construct()
    {
        $this->request = new Request();
        $this->queue = new Queue($this->request);
        //$this->visit = new Visit($this->request);
        //$this->order = new Order($this->request);
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $this->queue->getQueueItem();
        $visit = new Visit($this->request, $this->queue->visit_id);
        $order = new Order($this->request, $visit);
        $order->setOrderFields();
        $result = $order->add();
        $order->saveOrder($result);
    }
}