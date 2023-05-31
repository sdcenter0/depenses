<?php

namespace App\Controllers;

use App\Core\Attributes\Delete;
use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\Attributes\Put;
use App\Models\Depense;
use App\Models\DepenseDetails;

class DepenseDetailController extends Controller
{
  #[Get]
  public function index()
  {
    $depense = $this->request['depense'] ?? null;

    $query = DepenseDetails::query()
      ->join('depenses', 'depenses.id', '=', 'depense_details.depense_id');

    if ($depense) {
      $query->where('depense_id', '=', $depense);
    }

    $depenseDetails = $query->get([
      'depenses.name as depense_name',
      'depenses.id as depense_id',
      'depense_details.*',
    ]);

    return $this->render('depense-detail/index', compact('depenseDetails'));
  }

  #[Get]
  public function create()
  {
    $depenses = Depense::all(['id', 'name']);

    return $this->render('depense-detail/create', compact('depenses'));
  }

  #[Post]
  public function store(): void
  {
    $this->validate([
      'depense' => [
        'required',
        'exists:depenses,id'
      ],

      'amount' => 'required',

      'depense_detail_date' => 'required',
    ]);

    DepenseDetails::create([
      'depense_id' => $this->request['depense'],
      'amount' => $this->request['amount'],
      'depense_detail_date' => $this->request['depense_detail_date'],
    ]);

    $this->redirect('depense-detail/index');
  }

  #[Get]
  public function edit($id)
  {
    $depenseDetail = DepenseDetails::find($id);

    $depenses = Depense::all(['id', 'name']);

    return $this->render('depense-detail/edit', compact('depenseDetail', 'depenses'));
  }

  #[Put]
  public function update($id): void
  {
    if (!$id) {
      $this->redirect('index');
    }

    $this->validate([
      'depense' => [
        'required',
        'exists:depenses,id'
      ],

      'amount' => 'required',

      'depense_detail_date' => 'required',
    ]);

    $depenseDetail = DepenseDetails::find($id);

    $depenseDetail->update([
      'depense_id' => $this->request['depense'],
      'amount' => $this->request['amount'],
      'depense_detail_date' => $this->request['depense_detail_date'],
    ]);

    $this->redirect('depense-detail/index?depense=' . $depenseDetail->depense_id);
  }

  #[Delete]
  public function delete($id)
  {
    $depenseDetail = DepenseDetails::find($id);

    if ($depenseDetail) {
      $depenseDetail->delete();
    }

    $this->redirect('/depense-detail/index');
  }
}