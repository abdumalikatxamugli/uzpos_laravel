<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateCrudStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crudstr {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate crud structure';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        /**
         *
         * controller
         * view
         * form request
         */
        $modelName = ucfirst($name);
        $controllerName = ucfirst($name)."ResourceController";
        $controllerText = '<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\\'.$modelName.'\StoreRequest;
use App\Http\Requests\\'.$modelName.'\UpdateRequest;
use App\Models\\'.$modelName.';
use App\Models\User;
use Illuminate\Http\Request;

class '.$controllerName.' extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $'.$name.'s = '.$modelName.'::paginate(10);
        return view("dashboard.'.$name.'.index")->with("'.$name.'s", $'.$name.'s);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.'.$name.'.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, User $user)
    {
        $validated = $request->validated();
        '.$modelName.'::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.'.$name.'.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\\'.$modelName.' $'.$name.'
     * @return \Illuminate\Http\Response
     */
    public function show('.$modelName.' $'.$name.')
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\\'.$modelName.' $'.$name.'
     * @return \Illuminate\Http\Response
     */
    public function edit('.$modelName.' $'.$name.')
    {
        return view("dashboard.'.$name.'.edit")->with("'.$name.'", $'.$name.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\\'.$modelName.'  $'.$name.'
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, '.$modelName.' $'.$name.')
    {
        $'.$name.'->updateFromArray($request->validated(), $'.$name.'->id);
        return redirect()->route("dashboard.'.$name.'.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\\'.$modelName.'  $'.$name.'
     * @return \Illuminate\Http\Response
     */
    public function destroy('.$modelName.' $'.$name.')
    {
        $'.$name.'->delete();
        return redirect()->route("dashboard.'.$name.'.index");
    }
}
        ';
        $dir = getcwd();
        $f = fopen("$dir\app\Http\Controllers\Dashboard\\$controllerName.php", "w");
        fwrite($f, $controllerText);
        fclose($f);

        $requestText = '<?php

namespace App\Http\Requests\\'.$modelName.';

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required"
        ];
    }
}

        ';
        $dir = getcwd();
        mkdir("$dir\app\Http\Requests\\$modelName", 0755);
        $f = fopen("$dir\app\Http\Requests\\$modelName\StoreRequest.php", "w");
        fwrite($f, $requestText);


        $requestText = '<?php

namespace App\Http\Requests\\'.$modelName.';

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required"
        ];
    }
}

        ';
        $dir = getcwd();
        $f = fopen("$dir\app\Http\Requests\\$modelName\UpdateRequest.php", "w");
        fwrite($f, $requestText);
        fclose($f);

        $path = "$dir\\resources\\views\\dashboard\\metric\\create.blade.php";
        $f = fopen($path, "r");
        $text = fread($f, filesize($path));
        fclose($f);

        mkdir("$dir\\resources\\views\\dashboard\\$name", 0755);

        $path = "$dir\\resources\\views\\dashboard\\$name\\create.blade.php";
        $f = fopen($path, "w");
        fwrite($f, $text);
        fclose($f);

        $path = "$dir\\resources\\views\\dashboard\\metric\\edit.blade.php";
        $f = fopen($path, "r");
        $text = fread($f, filesize($path));
        fclose($f);

        $path = "$dir\\resources\\views\\dashboard\\$name\\edit.blade.php";
        $f = fopen($path, "w");
        fwrite($f, $text);
        fclose($f);

        $path = "$dir\\resources\\views\\dashboard\\metric\\index.blade.php";
        $f = fopen($path, "r");
        $text = fread($f, filesize($path));
        fclose($f);

        $path = "$dir\\resources\\views\\dashboard\\$name\\index.blade.php";
        $f = fopen($path, "w");
        fwrite($f, $text);
        fclose($f);

        return 0;
    }
}
