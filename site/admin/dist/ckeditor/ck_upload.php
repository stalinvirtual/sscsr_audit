<?php
// Define file upload path 
$upload_dir = array(
    'img' => 'uploads/',
);

// Allowed image properties  
$imgset = array(

    'type' => array('bmp', 'gif', 'jpg', 'jpeg', 'png', 'pdf'),
);


// If 0, will OVERWRITE the existing file 
define('RENAME_F', 1);
define('URLROOT', 'http://10.163.19.146/council/');

/** 
 * Set filename 
 * If the file exists, and RENAME_F is 1, set "img_name_1" 
 * 
 * $p = dir-path, $fn=filename to check, $ex=extension $i=index to rename 
 */
function setFName($p, $fn, $ex, $i)
{
    if (RENAME_F == 1 && file_exists($p . $fn . $ex)) {
        return setFName($p, F_NAME . '_' . ($i + 1), $ex, ($i + 1));
    } else {
        return $fn . $ex;
    }
}
$re = '';
if (isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
    define('F_NAME', preg_replace('/\.(.+?)$/i', '', basename($_FILES['upload']['name'])));
    // Get filename without extension 
    $sepext = explode('.', strtolower($_FILES['upload']['name']));
    $type = end($sepext);
    /** gets extension **/
    // Upload directory 
    $upload_dir = in_array($type, $imgset['type']) ? $upload_dir['img'] : $upload_dir['audio'];
    $upload_dir = trim($upload_dir, '/') . '/';
    // Validate file type 
    // File upload path 
    $f_name = setFName($_SERVER['DOCUMENT_ROOT'] . '/' . $upload_dir, F_NAME, ".$type", 0);
    $uploadpath = $upload_dir . $f_name;

    // If no errors, upload the image, else, output the errors 
    if ($re == '') {
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
            $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
            $url = URLROOT.'ckeditor/' . $upload_dir . $f_name;
            $re = in_array($type, $imgset['type']) ? "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>" : '<script>var cke_ob = window.parent.CKEDITOR; for(var ckid in cke_ob.instances) { if(cke_ob.instances[ckid].focusManager.hasFocus) break;} cke_ob.instances[ckid].insertHtml(\' \', \'unfiltered_html\'); alert("' . $msg . '"); var dialog = cke_ob.dialog.getCurrent();dialog.hide();</script>';
        } else {
            $re = '<script>alert("Unable to upload the file")</script>';
        }
    } else {
        $re = '<script>alert("' . $re . '")</script>';
    }
}

// Render HTML output 
@header('Content-type: text/html; charset=utf-8');
echo $re;
