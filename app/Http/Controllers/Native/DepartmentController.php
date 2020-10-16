<?php

namespace App\Http\Controllers\Native;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use MongoDB\Client;

class DepartmentController extends Controller
{
    public $mongoClient;

    public $collection;

    public function __construct()
    {
        $this->client = new Client("mongodb://127.0.0.1:27017");

        $this->collection = $this->client->mongophp->departments;
    }

    public function index()
    {
        $result = $this->collection->find([], []);

        $departments = [];
        foreach ($result as $department) {
            array_push($departments, $department);
        }
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        try {
            $result =  $this->collection->insertOne([
                'title' => $request->title,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
        return response()->json($result->getInsertedId());
    }

    public function update(Request $request, string $id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        try {
            $updateResult = $this->collection->updateOne(
                ['_id' => $id],
                ['$set' => $request->all()]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['efectedRows' => $updateResult->getMatchedCount(), 'efectedCount' => $updateResult->getModifiedCount(), 'isChanged' => $updateResult->isAcknowledged()]);
    }

    public function show(string $id) 
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $result = $this->collection->findOne(['_id' => $id]);
        return response()->json($result->jsonSerialize());
    }

    public function destroy(string $id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $deleteResult = $this->collection->deleteOne(['_id' => $id]);

        return response()->json(['deletedCount' => $deleteResult->getDeletedCount()]);
    }
}
