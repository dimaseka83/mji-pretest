<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    public function inventory()
    {
        $inventory = Inventory::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Inventory',
            'data' => $inventory
        ], 200);
    }

    public function addInventory(Request $request)
    {
        try {
            if(isset($request->id)){
                $inventory = Inventory::find($request->id);
                $inventory->update([
                    'name' => $request->name,
                    'harga' => $request->harga,
                    'stok' => $request->stok
                ]);
            }else{
                $inventory = Inventory::create([
                    'name' => $request->name,
                    'harga' => $request->harga,
                    'stok' => $request->stok
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menambahkan Data Inventory',
                'data' => $inventory
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deleteInventory($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return response()->json([
            'message' => 'Inventory deleted successfully',
            'inventory' => $inventory
        ], 200);
    }

    public function getTransaksi()
    {
        $transaksi = Transaksi::with('inventory')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Transaksi',
            'data' => $transaksi
        ], 200);
    }

    public function addTransaksi(Request $request)
    {
        try {
            $inventory = Inventory::find($request->inventory_id);
            if($request->tipe == 'penambahan'){
                $transaksi = Transaksi::create([
                    'inventory_id' => $request->inventory_id,
                    'tanggal' => $request->tanggal,
                    'nomor_transaksi' => $request->nomor_transaksi,
                    'jumlah' => $request->jumlah,
                    'tipe' => $request->tipe,
                    'total_stok' => $inventory->stok + $request->jumlah
                ]);
                $inventory->update([
                    'stok' => $inventory->stok + $request->jumlah
                ]);
                return response()->json(['success' => true, 'message' => 'Berhasil Menambahkan Data Transaksi', 'data' => $transaksi], 200);
            }else{
                $transaksi = Transaksi::create([
                    'inventory_id' => $request->inventory_id,
                    'tanggal' => $request->tanggal,
                    'nomor_transaksi' => $request->nomor_transaksi,
                    'jumlah' => $request->jumlah,
                    'tipe' => $request->tipe,
                    'total_stok' => $inventory->stok - $request->jumlah
                ]);
                $inventory->update([
                    'stok' => $inventory->stok - $request->jumlah
                ]);
                return response()->json(['success' => true, 'message' => 'Berhasil Menambahkan Data Transaksi', 'data' => $transaksi], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
