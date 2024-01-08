<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceException;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\Response as ResponseResource;
use App\Http\Resources\Service as ServiceResource;
use App\Http\Resources\ServiceCollection;
use App\Utils\Messages;
use App\Utils\ValidationMessages;
use App\Utils\Validations;
use Exception;
use App\Http\Utils\HttpStatusCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    private static $rules = Validations::SERVICE_RULES;
    private static $messages = ValidationMessages::SERVICE_MESSAGES;

    public function servicesList()
    {
        try {
            $services = Service::all();
            if ($services->isEmpty()) {
                throw new ResourceException(Messages::$NO_EXISTEN_DATOS);
            } else {
                $data = new ServiceCollection($services);
                return new ResponseResource($data);
            }
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::OK);
        }
    }

    public function getService($id)
    {
        try {
            $service = Service::findOrFail($id);
            $data = new ServiceResource($service);
            return response()->json(new ResponseResource($data), HttpStatusCode::OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(new ResponseResource(null, Messages::$SERVICIO_NO_EXISTE), HttpStatusCode::NOT_FOUND);
        }
    }

    public function saveService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), self::$rules, self::$messages);
            if ($validator->fails()) {
                throw new ResourceException($validator->errors()->first());
            }
            $service = Service::create($request->all());
            $data = new ServiceResource($service);
            return response()->json(new ResponseResource($data, Messages::$DATOS_GUARDADOS_CORRECTAMENTE), HttpStatusCode::CREATED);
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(new ResponseResource(null, Messages::$ERROR_AL_GUARDAR_DATOS), HttpStatusCode::INTERNAL_ERROR_SERVER);
        }
    }

    public function updateService(Request $request)
    {
        try {
            $id = $request->id;
            $service = Service::findOrFail($id);
            $rules = array_merge([], self::$rules);
            $rules['sku'] = 'required|unique:services,sku,' . $id . '|size:10';
            $validator = Validator::make($request->all(), $rules, self::$messages);
            if ($validator->fails()) {
                throw new ResourceException($validator->errors()->first());
            }
            $service->update($request->all());
            $data = new ServiceResource($service);
            return response()->json(new ResponseResource($data, Messages::$DATOS_GUARDADOS_CORRECTAMENTE), HttpStatusCode::OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(new ResponseResource(null, Messages::$SERVICIO_NO_EXISTE), HttpStatusCode::NOT_FOUND);
        } catch (ResourceException $e) {
            return response()->json(new ResponseResource(null, $e->getMessage()), HttpStatusCode::BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(new ResponseResource(null, Messages::$ERROR_AL_GUARDAR_DATOS), HttpStatusCode::INTERNAL_ERROR_SERVER);
        }
    }

    public function deleteService(Service $service)
    {
        $service->delete();
        return response()->json(null, HttpStatusCode::NO_CONTENT);
    }
}
