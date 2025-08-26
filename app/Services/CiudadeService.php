<?php

namespace App\Services;

use App\Models\Ciudade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CiudadeService
{
    public function getAllCiudades()
    {
        return Ciudade::latest()->get();
    }

    public function createCiudad(array $data)
    {
        try {
            DB::beginTransaction();
            
            $ciudad = Ciudade::create($data);
            
            DB::commit();
            return $ciudad;
            
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear ciudad", ['error' => $e]);
            throw $e;
        }
    }

    public function updateCiudad(Ciudade $ciudad, array $data)
    {
        try {
            DB::beginTransaction();
            
            $ciudad->update($data);
            
            DB::commit();
            return $ciudad;
            
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar ciudad", ['error' => $e]);
            throw $e;
        }
    }

    public function deleteCiudad(Ciudade $ciudad)
    {
        try {
            DB::beginTransaction();
            
            if ($ciudad->sedes()->exists()) {
                throw new \Exception('No se puede eliminar la ciudad porque tiene sedes asociadas.');
            }
            
            $ciudad->delete();
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar ciudad", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getCiudadesWithSedes()
    {
        return Ciudade::withCount('sedes')->get();
    }

    public function searchCiudades($searchTerm)
    {
        return Ciudade::where('nombre', 'like', "%{$searchTerm}%")
                     ->orWhere('region', 'like', "%{$searchTerm}%")
                     ->get();
    }
}