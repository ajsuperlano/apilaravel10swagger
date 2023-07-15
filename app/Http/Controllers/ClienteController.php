<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *             title="Aplis Clientes",
 *             version="1.0",
 *             description="Listados de Url's para el consumo de la API",
 * )
 *
 * @OA\Server(url="https://apilaravel10.test")
 */

class ClienteController extends Controller
{

    /**
     * Listados de todos los clientes
     * @OA\Get (
     *     path="/api/clientes",
     *     tags={"Cliente"},
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombres",
     *                         type="string",
     *                         example="Aderson Felix"
     *                     ),
     *                     @OA\Property(
     *                         property="apellidos",
     *                         type="string",
     *                         example="Jara Lazaro"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        dd($request->all());
        return Cliente::all();
    }

    /**
     * Registrar un nuevo cliente
     * @OA\Post (
     *     path="/api/clientes",
     *     tags={"Cliente"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombres", type="string"),
     *             @OA\Property(property="apellidos", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example=1),
     *             @OA\Property(property="nombres", type="string", example="Aderson Felix"),
     *             @OA\Property(property="apellidos", type="string", example="Jara Lazaro"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres'   => 'required',
            'apellidos' => 'required'
        ]);

        $cliente = new Cliente;
        $cliente->nombres   = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->save();

        return $cliente;
    }

    /**
     * Mostrar la información de un cliente
     * @OA\Get (
     *     path="/api/clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombres", type="string", example="Aderson Felix"),
     *              @OA\Property(property="apellidos", type="string", example="Jara Lazaro"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model."),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $cliente =  Cliente::find($id);

        if (is_null($cliente)) {
            return response()->json('No se pudo realizar correctamente la operación', 404);
        }

        return $cliente;
    }

    /**
     * Actualizar la información de un cliente
     * @OA\Put (
     *     path="/api/clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombres", type="string"),
     *             @OA\Property(property="apellidos", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example=1),
     *             @OA\Property(property="nombres", type="string", example="Aderson Felix"),
     *             @OA\Property(property="apellidos", type="string", example="Jara Lazaro"),
     *
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="NOT FOUND",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombres'   => 'required',
            'apellidos' => 'required'
        ]);

        $cliente->nombres   = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->update();

        return $cliente;
    }

    /**
     * Eliminar un cliente
     * @OA\Delete (
     *     path="/api/clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model.")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (is_null($cliente)) {
            return response()->json('No se pudo realizar correctamente la operación', 404);
        }

        $cliente->delete();
        return response()->noContent();
    }
}
