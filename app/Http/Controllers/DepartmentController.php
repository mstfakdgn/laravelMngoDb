<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use MongoDB\Client;
use MongoDB\Operation\FindOneAndUpdate;


class DepartmentController extends BaseController
{
    public $mongoClient;

    public $collection;

    public function __construct()
    {
        $this->client = new Client("mongodb://127.0.0.1:27017");

        $this->collection = $this->client->mongophp->departments;

    }

    public function add(Request $request)
    {
        $result = $this->collection->insertOne([
            'name' => $request->name,
        ]);
        dd($result->getInsertedCount(), $result->getInsertedId());
    }

    public function find(string $name)
    {
        // $this->collection->createIndex(
        //     ['name' => 1],
        //     [
        //         'collation' => ['locale' => 'tr'],
        //         'unique' => true,
        //     ]
        // );

        $result = $this->collection->find(
            ['name' => $name],
            [
                'collation' => ['locale' => 'en_US', 'strength' => 2],
            ]
        );
        $contracts = [];
        foreach ($result as $contract) {
            array_push($contracts, $contract);
        }
        dd($contracts);
    }
}
