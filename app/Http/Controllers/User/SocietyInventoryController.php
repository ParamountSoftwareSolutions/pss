<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Category;
use App\Models\PaymentPlan;
use App\Models\Premium;
use App\Models\Size;
use App\Models\Society;
use App\Models\SocietyInventory;
use App\Models\SocietyInventoryFile;
use App\Models\Type;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocietyInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($society_id, $block_id)
    {
        $society_inventory = SocietyInventory::with('project', 'block', 'category', 'payment_plan', 'nature', 'size', 'premium', 'file')->where(['society_id' =>
            $society_id, 'block_id' => $block_id])->latest()->get();
        $block = Block::findOrFail($block_id);
        return view('user.society_inventory.index', compact('society_inventory', 'society_id', 'block_id', 'block'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($society_id, $block_id)
    {
        $society = Society::with('project')->findOrFail($society_id);
        $payment_plan = PaymentPlan::whereHas('type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $category = Category::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $premium = Premium::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $bed = Size::where('unit', 'bed')->whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $bath = Size::where('unit', 'bath')->whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $plot_size = Size::whereIn('unit', ['marla', 'kanal'])->get();
        $nature = Type::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        return view('user.society_inventory.create', compact('society_id', 'block_id', 'society', 'payment_plan', 'category', 'premium', 'bed', 'bath', 'plot_size', 'nature'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $society_id, $block_id)
    {
        $request->validate([
            'category_id' => 'required',
        ]);
        $request->validate([
            'bulk_unit_no' => 'required',
            'start_unit_no' => 'required',
            'end_unit_no' => 'required',
        ], [
            'end_unit_no' => 'Bulk Fields is required'
        ]);
        $society = Society::with('project')->findOrFail($society_id);

        try {
            foreach ($request->bulk_unit_no as $key => $data) {
                $length = $request->end_unit_no[$key] - $request->start_unit_no[$key];
                for ($i = 0; $i <= $length; $i++) {
                    $unit_no = $request->start_unit_no[$key] + $i;
                    $unit = $request->bulk_unit_no[$key] . $unit_no;
                    //print_r($unit. "<br>");
                    $inventory = new SocietyInventory();
                    $inventory->project_id = $society->project->id;
                    $inventory->society_id = $society_id;
                    $inventory->block_id = $block_id;
                    $inventory->category_id = $request->category_id[$key];
                    $inventory->unit_id = $unit;
                    $inventory->size_id = $request->plot_size[$key];
                    $inventory->payment_plan_id = $request->payment_plan_id[$key];
                    $inventory->premium_id = $request->premium_id[$key];
                    $inventory->type_id = $request->nature_id[$key];
                    $inventory->bed_id = $request->bed[$key];
                    $inventory->bath_id = $request->bath[$key];
                    $inventory->created_by = Auth::id();
                    $inventory->status = 'available';
                    $inventory->save();

                    SocietyInventoryFile::Create(
                        [
                            'society_inventory_id' => $inventory->id,
                            'file' => 'images/society/plot.jpg',
                            'type' => 'image',
                        ]);
                }
            }
            return redirect()->route('society.block.society_inventory.index', ['RolePrefix' => RolePrefix(), 'society' => $society_id, 'block' => $block_id])->with
            ($this->message('Society inventory created successfully', 'success'));
        } catch (Exception $e) {
            return redirect()->back()->with($this->message($e->getMessage(), 'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($society_id, $block_id, $id)
    {
        $society = Society::with('project')->findOrFail($society_id);
        $society_inventory = SocietyInventory::findOrFail($id);
        $payment_plan = PaymentPlan::whereHas('type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $category = Category::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $premium = Premium::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $bed = Size::where('unit', 'bed')->whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $bath = Size::where('unit', 'bath')->whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $plot_size = Size::whereIn('unit', ['marla', 'kanal'])->get();
        $nature = Type::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        return view('user.society_inventory.edit', compact('society_id', 'block_id', 'society', 'society_inventory', 'payment_plan', 'category', 'premium', 'bed', 'bath',
        'plot_size', 'nature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $society_id, $block_id, $id)
    {
        $request->validate([
            'category_id' => 'required',
        ]);
        $society = Society::with('project')->findOrFail($society_id);

        $inventory = SocietyInventory::findOrFail($id);
        $inventory->project_id = $society->project->id;
        $inventory->society_id = $society_id;
        $inventory->block_id = $block_id;
        $inventory->category_id = $request->category_id;
        $inventory->unit_id = $request->simple_unit;
        $inventory->size_id = $request->plot_size;
        $inventory->payment_plan_id = $request->payment_plan_id;
        $inventory->premium_id = $request->premium_id;
        $inventory->type_id = $request->nature_id;
        $inventory->bed_id = $request->bed;
        $inventory->bath_id = $request->bath;
        $inventory->created_by = Auth::id();
        $inventory->status = 'available';
        $inventory->save();

        SocietyInventoryFile::Create(
            [
                'society_inventory_id' => $inventory->id,
                'file' => 'images/society/plot.jpg',
                'type' => 'image',
            ]);
        if ($inventory) {
            return redirect()->route('society.block.society_inventory.index', ['RolePrefix' => RolePrefix(), 'society' => $society_id, 'block' => $block_id])->with
            ($this->message('Society inventory created successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Society update error', 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($society_id, $block_id, $id)
    {
        $society_inventory = SocietyInventory::where(['society-id' => $society_id, 'block_id' => $block_id, 'id' => $id])->first();
        $society_inventory->delete();
        if ($society_inventory) {
            return redirect()->back()->with($this->message('Building inventory delete successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Building inventory delete error', 'error'));
        }
    }
}
