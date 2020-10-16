<?php

namespace App\Http\Controllers\Native;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MongoDB\Client;
use App\Models\Native\User;

class UserController extends Controller
{
    public $mongoClient;

    public $collection;

    public function __construct()
    {
        $this->client = new Client("mongodb://127.0.0.1:27017");

        $this->collection = $this->client->mongophp->users;
    }

    public function index()
    {
        $result = $this->collection->find([], []);

        $users = [];
        foreach ($result as $user) {
            array_push($users, $user);
        }
        return response()->json($users);
    }

    public function store(Request $request)
    {
        try {
            $result =  $this->collection->insertOne([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
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
