<?php


namespace MyStore2\Entities;
use MyStore2\Http\Request;

class Queue
{
    private $request;
    public $visit_id = null;

    public function __construct($request)
    {
        $this->request = $request;
    }

    private function setVisitID($visit_id)
    {
        $this->visit_id = $visit_id;
    }

    public function getQueueItem()
    {

        $cl_opts = getopt('v:');

        if(array_key_exists('v', $cl_opts)){
            $this->setVisitID(intval($cl_opts['v']));
        }else{
            $queue_item = $this->request->postCRM($_ENV['API2_CRM_URL'], [
                'action' => 'MyStore/getVisitFromQueue'
            ]);
            print_r($queue_item);
            if(count($queue_item) > 0)
                $this->setVisitID($queue_item[0]['visit_id']);
        }

    }

}