<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeApiResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:apiResource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create api resource controller with create, store, index, destroy methods';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $dir = getcwd();
        $controllerName = ucfirst($name)."Controller";
        $modelName = ucfirst($name);
        $validatorName = ucfirst($name)."ResourceValidator";
        $f = fopen("$dir\app\Http\Controllers\CRUD\\$controllerName.php", "w");
        fwrite($f, '<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnexpectedErrorException;
use App\Http\Validators\\'.$validatorName.';
use App\Models\\'.$modelName.';
use App\Models\User;
use App\Responses\CustomPaginatedResponse;
use App\Responses\ErrorMessageResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

class '.$controllerName.' extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = new CustomPaginatedResponse( '.$modelName.'::paginate(10) );
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
            $'.$name.' = '.$modelName.'::createFromArrayWithUser($validated, $user);
            return $'.$name.';
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
            return '.$modelName.'::findOrFail($id);
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
            $'.$name.' = '.$modelName.'::updateFromArrayWithUser($validated, $id, $user);
            return $'.$name.';
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
            $'.$name.' = '.$modelName.'::findOrFail($id);
            $'.$name.'->delete();
            return ErrorMessageResponse::send(0, "success");
        }catch(ModelNotFoundException $e){
            throw new NotFoundException();
        }catch(Exception $e){
            throw new UnexpectedErrorException();
        }
    }
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new '.$validatorName.', $method]);
    }
}

?>');
        return 0;
    }
}
