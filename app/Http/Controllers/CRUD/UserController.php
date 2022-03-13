<?php

namespace App\Http\Controllers\CRUD;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedErrorException;
use App\Http\Controllers\Controller;
use App\Http\Validators\UserResourceValidator;
use App\Models\User;
use App\Responses\CustomPaginatedResponse;
use App\Responses\ErrorMessageResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = new CustomPaginatedResponse( User::paginate(10) );
        return $paginator->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate_store();
        try{
            $user = User::createFromArray($validated);
            return $user;
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
            return User::findOrFail($id);
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
    public function update(Request $request, $id)
    {
        $validated = $this->validate_update();
        try{
            $user = User::updateFromArray($validated, $id);
            return $user;
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
            $user = User::findOrFail($id);
            $user->delete();
            return ErrorMessageResponse::send(0, 'success');
        }catch(ModelNotFoundException $e){
            throw new NotFoundException();
        }catch(Exception $e){
            throw new UnexpectedErrorException();
        }
    }
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new UserResourceValidator, $method]);
    }
}
