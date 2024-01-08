<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceException;
use App\Models\OperatingSystem;
use App\Models\Software;
use App\Http\Resources\Software as SoftwareResource;
use App\Http\Resources\Response as ResponseResource;
use App\Http\Resources\SoftwareCollection;
use App\Http\Utils\HttpStatusCode;
use App\Utils\Messages;
use App\Utils\ValidationMessages;
use App\Utils\Validations;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SoftwareController extends Controller
{
    private static $rules = Validations::LICENSE_RULES;
    private static $messages = ValidationMessages::LICENSE_MESSAGES;

    public function licenseList()
    {
        try {
            $licenses = Software::all();
            if ($licenses->isEmpty()) {
                throw new ResourceException(Messages::$NO_EXISTEN_DATOS);
            } else {
                $data = new SoftwareCollection($licenses);
                return new ResponseResource($data);
            }
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::OK);
        }
    }

    public function getLicense($id)
    {
        try {
            $license = Software::findOrFail($id);
            $data = new SoftwareResource($license);
            return response()->json(new ResponseResource($data), HttpStatusCode::OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(new ResponseResource(null, Messages::$LICENCIA_NO_EXISTE), HttpStatusCode::NOT_FOUND);
        }
    }

    public function saveLicense(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), self::$rules, self::$messages);
            if ($validator->fails()) {
                throw new ResourceException($validator->errors()->first());
            }
            $os = OperatingSystem::findOrFail($request->os);
            $license = Software::create([
                'sku' => $request->sku,
                'type' => $request->type,
                'serial' => Str::random(100),
            ]);
            $price = $request->price;
            $stock = $request->stock;
            $license->operatingSystems()->attach([$os->id => ['price' => $price, 'stock' => $stock]]);
            $data = new SoftwareResource($license);
            return response()->json(new ResponseResource($data, Messages::$DATOS_GUARDADOS_CORRECTAMENTE), HttpStatusCode::CREATED);
        } catch (ModelNotFoundException $e) {
            return response()->json(new ResponseResource(null, Messages::$SISTEMA_OPERATIVO_NO_EXISTE), HttpStatusCode::NOT_FOUND);
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(new ResponseResource(null, Messages::$ERROR_AL_GUARDAR_DATOS), HttpStatusCode::INTERNAL_ERROR_SERVER);
        }
    }

    public function updateLicense(Request $request)
    {
        try {
            $id = $request->id;
            $license = Software::findOrFail($id);
            $rules = array_merge([], self::$rules);
            $rules['sku'] = 'required|unique:software,sku,' . $id . '|size:10';
            $validator = Validator::make($request->all(), $rules, self::$messages);
            if ($validator->fails()) {
                throw new ResourceException($validator->errors()->first());
            }
            $os = OperatingSystem::findOrFail($request->os);
            $license->update([
                'sku' => $request->sku,
                'type' => $request->type,
            ]);
            $price = $request->price;
            $stock = $request->stock;
            $license->operatingSystems()->sync([$os->id => ['price' => $price, 'stock' => $stock]]);
            $data = new SoftwareResource($license);
            return response()->json(new ResponseResource($data, Messages::$DATOS_GUARDADOS_CORRECTAMENTE), HttpStatusCode::OK);
        } catch (ModelNotFoundException $e) {
            if ($e->getModel() === Software::class) {
                $message = Messages::$LICENCIA_NO_EXISTE;
            } elseif ($e->getModel() === OperatingSystem::class) {
                $message = Messages::$SISTEMA_OPERATIVO_NO_EXISTE;
            } else {
                $message = $e->getMessage();
            }
            return response()->json(new ResponseResource(null, $message), HttpStatusCode::NOT_FOUND);
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(new ResponseResource(null, Messages::$ERROR_AL_GUARDAR_DATOS), HttpStatusCode::INTERNAL_ERROR_SERVER);
        }
    }

    public function deleteLicense(Software $license)
    {
        $license->delete();
        return response()->json(null, HttpStatusCode::NO_CONTENT);
    }
}
