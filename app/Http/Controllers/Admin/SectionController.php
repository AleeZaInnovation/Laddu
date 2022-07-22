<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Section;
use Session;
use App\Models\Category;


class SectionController extends Controller
{
    //
    public function section(){
        Session::put('page','sections');
        $sections = Section::get()->toArray();
        //dd($sections);
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Section::where('id',$data['item_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'item_id'=>$data['item_id']]);
        }
    }

    public function deleteSection($id){
        Section::where('id',$id)->delete();
        $message = "Section has been deleted successfully .";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditSection(Request $request,$id=null){
        Session::put('page','sections');
        if($id==""){
            $title = "Add Section";
            $section = new Section;
            $message = "Section has been added.";
        }else{
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section has been updated.";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customesMessages = [
                'section_name.required' => 'Section name is required !',
                'section_name.regex' => 'Valid section name is required !',
            ];

            $this->validate($request,$rules,$customesMessages);

            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();

            return redirect('admin/sections')->with('success_message',$message);
        }
        return view('admin.sections.add_edit_section')->with(compact('title','section'));
    }

    
}
