<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use MongoDB\Client;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $mongoClient;

    public $collection;

    public function __construct()
    {
        $this->client = new Client("mongodb://127.0.0.1:27017");
        
        $this->collection = $this->client->mongophp->users;

    }

    public function add()
    {
        $result = $this->collection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);
        dd($result->getInsertedCount(), $result->getInsertedId());
    }

    public function addMultiple()
    {
        $result = $this->collection->insertMany([
            [
                'username' => 'user',
                'email' => 'admin@example.com',
                'name' => 'Admin User',
            ],
            [
                'username' => 'admin',
                'email' => 'test@example.com',
                'name' => 'Test User',
            ],
        ]);

        dd($result->getInsertedCount(), $result->getInsertedIds());
    }

    public function getUser($id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $result = $this->collection->findOne(['_id' => $id]);
        dd($result);
    }

    public function getMultipleUsers()
    {
        $users = [];
        $result = $this->collection->find(['username' => 'admin']);
        foreach ($result as $user) {
            array_push($users, $user);
        }
        dd($users);
    }

    public function all()
    {
        $allUsers = [];

        $result = $this->collection->find(
            [],
            [
                'limit' => 5,
                'sort' => ['pop' => -1],
            ]
        );

        foreach ($result as $user) {
            array_push($allUsers, $user);
        }
        dd($allUsers);
    }

    public function regex()
    {
        $result = $this->collection->find([
            'username' => new  \MongoDB\BSON\Regex('^admin', 'i'),
        ]);
        $users = [];
        foreach ($result as $user) {
            array_push($users, $user);
        }

        dd($users);
    }

    public function updateUser(Request $request, $id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $updateResult = $this->collection->updateOne(
            ['_id' => $id],
            ['$set' => [
                'email' => $request->email
            ]]
        );

        dd($updateResult);
    }

    public function updateAll(Request $request)
    {
        $result = $this->collection->updateMany(
            [],
            ['$set' => ['username' => 'updatedAllSecond']]
        );

        dd($result->getMatchedCount(), $result->getModifiedCount());
    }

    public function replace($id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $updateResult = $this->collection->replaceOne(
            ['_id' => $id],
            ['username' => 'Replaced man', 'email' => 'replaced@gmail.com', 'name' => 'Replaced Name']
        );

        dd($updateResult->getMatchedCount(), $updateResult->getModifiedCount());
    }

    //Upsert check if it exist if it is not add it if it exiast update
    public function upsert()
    {
        $updateResult = $this->collection->updateOne(
            ['username' => 'Replaced manasdasds'],
            ['$set' => ['name' => 'Upsert name']],
            ['upsert' => true]
        );

        printf("Matched %d document(s)\n", $updateResult->getMatchedCount());
        printf("Modified %d document(s)\n", $updateResult->getModifiedCount());
        printf("Upserted %d document(s)\n", $updateResult->getUpsertedCount());

        $upsertedDocument = $this->collection->findOne([
            '_id' => $updateResult->getUpsertedId(),
        ]);

        var_dump($upsertedDocument);
    }

    public function delete($id)
    {
        $id = new \MongoDB\BSON\ObjectId($id);

        $deleteResult = $this->collection->deleteOne(['_id' => $id]);

        dd($deleteResult->getDeletedCount());
    }

    public function deleteAll()
    {
        $deleteResult = $this->collection->deleteMany([]);

        dd($deleteResult->getDeletedCount());
    }
}
