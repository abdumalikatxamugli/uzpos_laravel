<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedErrorException;
use App\Http\Validators\ItemResourceValidator;
use App\Models\Item;
use App\Models\User;
use App\Responses\CustomPaginatedResponse;
use App\Responses\ErrorMessageResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = new CustomPaginatedResponse( Item::paginate(10) );
        return $paginator->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user)
    {
        $validated = $this->validate_store();
        try{
            $item = Item::createFromArrayWithUser($validated, $user);
            return $item;
        }catch(Exception $e){
            throw $e;
            throw new UnexpectedErrorException();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            return Item::findOrFail($id);
        }catch(ModelNotFoundException $e){
            throw new NotFoundException();
        }catch(Exception $e){
            throw new UnexpectedErrorException();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, User $user)
    {
        $validated = $this->validate_update();
        try{
            $item = Item::updateFromArrayWithUser($validated, $id, $user);
            return $item;
        }catch(ModelNotFoundException $e){
            throw new NotFoundException();
        }catch(Exception $e){
            // throw $e;
            throw new UnexpectedErrorException();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $item = Item::findOrFail($id);
            $item->delete();
            return ErrorMessageResponse::send(0, "success");
        }catch(ModelNotFoundException $e){
            throw new NotFoundException();
        }catch(Exception $e){
            throw new UnexpectedErrorException();
        }
    }
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new ItemResourceValidator, $method]);
    }
}

?>