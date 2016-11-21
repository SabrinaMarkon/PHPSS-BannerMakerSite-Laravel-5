<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use Validator;
use Response;
use File;
class BannersController extends Controller
{
    /**
     * Show all banners.
     *
     * @return Response
     */
    public function index() {
        // Get the user's saved images.
        $savedimages = Banner::where('userid', Session::get('user')->userid)->orderBy('id', 'asc')->get();
        // Get the image library tree.
        $directory = "images/editorimages";
        $foldertree = $this->folderTree($directory);
        // Get all the files in all the subdirectories recursively.
        // Build array and preload list.
        $filetree = File::allFiles($directory);
        $preloadimages = '';
        foreach ($filetree as $file)
        {
            $extension = File::extension($file);
            if ($extension === 'gif' || $extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {
                $preloadimages .= '<img src="' . (string)$file . '">';
            }
        }
        return view('pages.banners', compact('savedimages', 'foldertree', 'preloadimages'));
    }
    /**
     * Get any subfolders of the folder.
     *
     * @param $topdir  the top root directory.
     * @return $subdirs  The subdirectories of the topdir root directory.
     */
    public function getSubdirectories($topdir) {
        $subdirs = File::directories($topdir);
        return $subdirs;
    }
    /**
     * Build the list of directories for the image library folder select box.
     *
     * @param $directory  the top root directory.
     * @return $foldertree  the list of all directories in root with their subdirectories for the select box.
     */
    public function folderTree($directory) {
        $foldertree = '';
        $dirs = $this->getSubdirectories($directory);
        foreach ($dirs as $dir) {
            $show_dir_array = explode('editorimages/', $dir);
            $show_dir = $show_dir_array[1];
            $foldertree .= '<option value="' . $show_dir . '">' . $show_dir . '</option>';
//            // get any subdirs of dir:
//            $dirs2 = $this->getSubdirectories($dir);
//            foreach ($dirs2 as $dir2) {
//                $show_dir_array2 = explode('editorimages/', $dir2);
//                $show_dir2 = $show_dir_array2[1];
//                $foldertree .=  '<option value="' . $show_dir2 . '">' . $show_dir2 . '</option>';
//            }
        }
        return $foldertree;
    }
    /**
     * Get the list of files for the image library chooser depending on which category (folder) was chosen.
     *
     * @param $imagedirectory  the chosen image folder.
     * @return $filetree  the list of all files in the chosen directory.
     */
    public function fileTree(Request $request, $folder = null) {
        $folder = "images/editorimages/" . $folder;
        $filetree = '';
        $resize = '';
        $files = File::files($folder);
        foreach ($files as $file)
        {
            // make sure the file is an image.
            $extension = File::extension($file);
            if ($extension === 'gif' || $extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {
                $file_fullpath_array = explode("/", $file);
                $filename = end($file_fullpath_array);
                $filedata = getimagesize($file);
                $width = $filedata[0];
                $height = $filedata[1];
                if ($width > 200) {
                    $resize = ' previewshrink';
                }
                $filetree .= '<img  id="' . $filename . '" class="imagepreviewdiv ui-widget-content' . $resize . '" src="' . (string)$file . '"><br>';
            }
        }
        return $filetree;
    }
    /**
     * Save banner.
     *
     * @return Response
     */
    public function getbanner(Request $request) {
        //Get the base-64 string from data
        $img_val = $request->get('img_val');
        $filteredData = substr($img_val, strpos($img_val, ",")+1);
        //Decode the string
        $unencodedData = base64_decode($filteredData);
        //Save the image with a random filename.
        $dlfilelong = md5(rand(0,9999999));
        $dlfileshort = substr($dlfilelong, 0, 12);
        $today = date("YmdHis");
        $dlfile = $today . $dlfileshort . ".png";
        $dlfilepath = 'mybanners/' . $dlfile;
        // write the file to the server.
        file_put_contents('mybanners/' . $dlfile, $unencodedData);
        // get the background and border setting values from img_obj
        $img_obj = $request->get('img_obj');
        //var_dump(json_decode($img_obj));
        $img_obj = json_decode($img_obj);
        // save image into the banners database table.
        $banner = new Banner();
        $banner->userid = Session::get('user')->userid;
        // remove resize handles from htmlcode:
        $banner->htmlcode = trim($request->get('htmlcode'));
        $banner->filename = $dlfile;
        // save the fields in the object img_obj:
        $banner->width = $img_obj->width;
        $banner->height = $img_obj->height;
        $banner->bgcolor = $img_obj->bgcolor;
        $banner->bgimage = $img_obj->bgimage;
        $banner->bordercolor = $img_obj->bordercolor;
        $banner->borderwidth = $img_obj->borderwidth;
        $banner->borderstyle = $img_obj->borderstyle;
        $banner->save();
        Session::flash('message', 'Successfully saved your banner!');
        return Redirect::to('banners');
    }
    /**
     * Display the specified image.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        // get the page content for this id.
        $banner = Banner::find($id);
        return $banner;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $banner = Banner::find($id);
        return "update function";
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $banner = Banner::find($id);
        // delete the file:
        $filename = $banner->filename;
        $filepath = 'mybanners/' . $filename;
        File::delete($filepath);
        // delete the record:
        $banner->delete();
        return $banner;
    }
}
