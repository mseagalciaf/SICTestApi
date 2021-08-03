<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware(['auth:sanctum','role:user|admin'])->only(['index','show']);
        $this->middleware(['auth:sanctum','role:admin'])->only(['store','update','destroy']);
    }

    public function index() {
        $products = Product::all();
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),$this->rulesProduct());

        if($validator->fails()){
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{

            $product = new Product($request->all());

            $product->save();
            
            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_agregado'],200);
        }
    }

    public function show($id){
        $product = Product::find($id);

        if(isset($product)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$product],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
        }
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(),$this->rulesProduct());

        if ($validator->fails()) {

            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{

            $product=Product::find($id);

            if (isset($product)) {

                $product->name=$request->name;
                $product->price=$request->price;

                //Guarda el registro
                $product->save();
            
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
            }
        }
    }

    public function destroy($id) {

        $product = Product::find($id);
        if (isset($product)) {

            $product->delete();

            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_eliminado'],200);
        }else{
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_inexistente'],200);
        }
    }

    public function rulesProduct()
    {
        return [
            'name'=>'required|min:3',
            'price'=>'required|integer|min:1'
        ];
    }
}
