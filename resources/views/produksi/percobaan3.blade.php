public function edit($id)
    { 
        //Menampilkan Form Edit
        $bstudi = BidangStudi::find($id);
        if (!$bstudi) return redirect()->route('bidstudi.index')->with('error_message', 'bidang studi dengan id = '.$id.' tidak ditemukan');
        return view('bidangstudi.edit', [ 
        'bdstudi' => $bstudi
        ]);
    } 
 public function update(Request $request, $id)
    { 
        //Mengedit Data Bidang Studi
        $request->validate([
        'bidangstudi' =>
        'required|unique:bidangstudi,bidangstudi,'.$id
        ]);
        $bstudi = BidangStudi::find($id);
        $bstudi->bidangstudi = $request->bidangstudi;
        $bstudi->save();
        return redirect()->route('bidstudi.index')->with('success_message', 'Berhasil mengubah bidang studi');
    }