<?php

namespace App\Http\Controllers;
use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;





class AuthorController extends Controller
{
    use  ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

/**
 * Return the list of authors
* @return Illuminate\Http\Response
*/
public function index(){

$author=Author::all();
return $this->sucessResponse($author);


}


/**
 * Creates a new author
* @return Illuminate\Http\Response
*/ 

public function store(Request $request){
$rules=[
    'name'=>'required|max:255',
    'gender'=>'required|max:255|in:male,female',
    'country'=>'required|'
];
$this->validate($request, $rules);
$author=Author::create($request->all());
return $this->sucessResponse($author,Response::HTTP_CREATED);


}



/**
 * Obtains the record of a single author
* @return Illuminate\Http\Response
*/

public function show($author){
    $author=Author::findOrFail($author);
    return $this->sucessResponse($author);

}


/**
 * Updates a single author
* @return Illuminate\Http\Response
*/

public function update(Request $request, $author){
    $rules=[
        'name'=>'max:255',
        'gender'=>'max:255|in:male,female',
        'country'=>'max:255'
    ];
// Validate the rules set above
    $this->validate($request,$rules);
    // Finds the requested id of the author
    $author=Author::findOrFail($author);
    // Fill in the new data
    $author= new Author();
    $author->fill($request->all());
    // If entered data is the same as old data in the db
    if($author->isClean()){
        return $this->errorResponse('At least one value must change',Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    // else save the validated data
    $author->save();
// response
return $this->sucessResponse($author,Response::HTTP_CREATED);



}


/**
 * Deletes a single record of author
* @return Illuminate\Http\Response
*/

public function destroy($author){
    $author=Author::findOrFail($author);
$author->delete();
return $this->sucessResponse($author,'Deleted');

}


}
