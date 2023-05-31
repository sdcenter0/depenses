<?php

namespace App\Controllers;

use App\Core\Attributes\Delete;
use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\Attributes\Put;
use App\Models\Depense;
use App\Models\Supplier;

class DepenseController extends Controller
{
  #[Get]
  public function index()
  {
    $depenses = Depense::query()->join('suppliers', 'depenses.supplier_id', '=', 'suppliers.id')
      ->get([
        'depenses.*',
        'suppliers.id as supplier_id',
        'suppliers.name as supplier_name',
      ]);

    $ids = array_map(fn($depense) => $depense->id, $depenses);

    $depenseDetails = Depense::query()
      ->join('depense_details', 'depenses.id', '=', 'depense_details.depense_id')
      ->whereIn('depenses.id', $ids)
      ->get([
        'depenses.id as depense_id',
        'depense_details.*',
      ]);

    $depenses = array_map(function ($depense) use ($depenseDetails) {
      $depense->depense_details = array_filter($depenseDetails, fn($depenseDetail) => $depenseDetail->depense_id === $depense->id);

      return $depense;
    }, $depenses);

    return $this->render('depense/index', compact('depenses'));
  }

  #[Get]
  public function create()
  {
    $suppliers = Supplier::all();

    return $this->render('depense/create', compact('suppliers'));
  }

  #[Post]
  public function store(): void
  {
    $this->validate([
      'supplier' => [
        'required',
        'exists:suppliers,id'
      ],

      'name' => 'required',

      'amount' => 'required',

      'depense_date' => 'required',

      'invoice' => 'required',

      'nature' => 'required',

      'type' => 'required',
    ]);

    Depense::create([
      'supplier_id' => $this->request['supplier'],
      'name' => $this->request['name'],
      'amount' => $this->request['amount'],
      'depense_date' => $this->request['depense_date'],
      'invoice' => $this->request['invoice'],
      'nature' => $this->request['nature'],
      'type' => $this->request['type'],
    ]);

    $this->redirect('depense/index');
  }

  #[Get]
  public function edit($id)
  {
    $depense = Depense::find($id);

    $suppliers = Supplier::all(['id', 'name']);

    return $this->render('depense/edit', compact('depense', 'suppliers'));
  }

  #[Put]
  public function update($id): void
  {
    if (!$id) {
      $this->redirect('index');
    }

    $this->validate([
      'supplier' => [
        'required',
        'exists:suppliers,id'
      ],

      'name' => 'required',

      'amount' => 'required',

      'depense_date' => 'required',

      'invoice' => 'required',

      'nature' => 'required',

      'type' => 'required',
    ]);

    $depense = Depense::find($id);

    $depense->update([
      'supplier_id' => $this->request['supplier'],
      'name' => $this->request['name'],
      'amount' => $this->request['amount'],
      'depense_date' => $this->request['depense_date'],
      'invoice' => $this->request['invoice'],
      'nature' => $this->request['nature'],
      'type' => $this->request['type'],
    ]);

    $this->redirect('depense/index');
  }

  #[Delete]
  public function delete($id)
  {
    $depense = Depense::query()
      ->where('depenses.id', '=', $id)
      ->join('depense_details', 'depenses.id', '=', 'depense_details.depense_id')
      ->groupBy('depenses.id')
      ->first([
        'depenses.id',
        'count(depense_details.id) as depense_details_count',
      ]);

    if ($depense->depense_details_count === 0) {
      $depense->delete();
      session_set('success', 'Depense deleted successfully');
    } else {
      session_set('error', 'You can\'t delete this depense because it has depense details');
    }

    $this->redirect('/depense/index');
  }
}