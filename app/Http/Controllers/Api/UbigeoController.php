<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PeruDepartment;
use App\Models\PeruDistrict;
use App\Models\PeruProvince;
use Illuminate\Http\JsonResponse;

class UbigeoController extends Controller
{
	public function departments(): JsonResponse
	{
		$data = PeruDepartment::query()
			->select(['id', 'name'])
			->pluck('name', 'id');

		return response()->json($data);
	}

	public function department(string $id): JsonResponse
	{
		$data = PeruDepartment::query()
			->select(['id', 'name'])
			->find($id);

		return response()->json(['id' => $id, 'name' => $data->name]);
	}

	public function provinces(string $departmentId): JsonResponse
	{
		$data = PeruProvince::query()
			->select(['id', 'name'])
			->where('department_id', $departmentId)
			->pluck('name', 'id');

		return response()->json($data);
	}

	public function province(string $id): JsonResponse
	{
		$data = PeruProvince::query()
			->select(['id', 'name'])
			->find($id);

		return response()->json(['id' => $id, 'name' => $data->name]);
	}

	public function districts(string $provinceId): JsonResponse
	{
		$data = PeruDistrict::query()
			->select(['id', 'name'])
			->where('province_id', $provinceId)
			->pluck('name', 'id');

		return response()->json($data);
	}

	public function district(string $id): JsonResponse
	{
		$data = PeruDistrict::query()
			->select(['id', 'name'])
			->find($id);

		return response()->json(['id' => $id, 'name' => $data->name]);
	}
}
