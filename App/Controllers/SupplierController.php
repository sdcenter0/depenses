<?php

namespace App\Controllers;

use App\Core\Attributes\Delete;
use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\Attributes\Put;
use App\Models\Supplier;

class SupplierController extends Controller
{
  #[Get]
  public function index()
  {
    $suppliers = Supplier::all();

    return $this->render('supplier/index', compact('suppliers'));
  }

  #[Get]
  public function create()
  {
    return $this->render('supplier/create');
  }

  #[Post]
  public function store(): void
  {
    $this->validate([
      'supplier_code' => [
        'required',
        'unique:suppliers'
      ],

      'name' => 'required',
    ]);

    Supplier::create([
      'supplier_code' => $this->request['supplier_code'],
      'name' => $this->request['name'],
    ]);

    $this->redirect('supplier/index');
  }

  #[Get]
  public function edit($id)
  {
    $supplier = Supplier::find($id);

    return $this->render('supplier/edit', compact('supplier'));
  }

  #[Put]
  public function update($id): void
  {
    $id = $this->request['id'] ?? null;

    if (!$id) {
      $this->redirect('index');
    }

    $this->validate([
      'supplier_code' => [
        'required',
        'unique:suppliers,supplier_code,' . $id . ',id'
      ],

      'name' => 'required',
    ]);

    $supplier = Supplier::find($id);

    $supplier->update([
      'supplier_code' => $this->request['supplier_code'],
      'name' => $this->request['name'],
    ]);

    $this->redirect('supplier/index');
  }

  #[Delete]
  public function delete($id)
  {
    $supplier = Supplier::query()
      ->where('suppliers.id', '=', $id)
      ->join('depenses', 'suppliers.id', '=', 'depenses.supplier_id')
      ->groupBy('suppliers.id')
      ->first([
        'suppliers.id',
        'count(depenses.id) as depenses_count',
      ]);

    if ($supplier->depenses_count === 0) {
      $supplier->delete();
      session_set('success', 'Supplier deleted successfully');
    } else {
      session_set('error', 'You can\'t delete this supplier because it has depenses');
    }

    $this->redirect('/supplier/index');
  }
}