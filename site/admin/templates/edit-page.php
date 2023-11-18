<?php

namespace App\Controllers;

use App\Helpers\Helpers;

Helpers::urlSecurityAudit();
echo $this->get_header();
if (!isset($_SESSION)) {
  session_start();
}
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Page Creation Form</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Advanced Form</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content   section div start -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
          <!-- general form elements -->
          <!-- /.card -->
          <!-- Horizontal Form -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Page creation Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <!-- <form class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Menu Name:<span style='color:red'>*</span></label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="menu_name" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Menu Link : <span style='color:red'>*</span></label>
                      <div class="col-sm-10">
                        <input class="form-control" type="text" name="menu_link" required>
                      </div>
                    </div>
                    <input type="hidden" value="<?= $user->id ?>" name="id">
                  </div>
                  <!-- /.card-body 
                <div class="card-footer">
                  <input type="submit" class="btn btn-info" name="add_main_menu" value="submit">
                </div>
                <!-- /.card-footer 
                </form> -->
            <form class="form-horizontal" method="post" enctype="multipart/form-data" id="edit_page_form">
              <div class="card-body">
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Title <span style='color:red'>*</span></label>
                  <div class="col-sm-10">
                    <input class="form-control" type="text" name="title" id="title" required value="<?php echo $current_page['title']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label"> Page Content <span style='color:red'>*</span></label>
                  <div class="col-sm-10">
                    <textarea class="form-control" type="text" name="page_content" id="page_content" required><?php echo $current_page['page_content']; ?>
                    </textarea>
                    <script src="<?php echo $this->theme_url; ?>/dist/js/jquery.min.js"></script>
                    <script src="<?php echo $this->theme_url; ?>/dist/ckeditor/ckeditor.js" type="text/javascript"></script>
                    <script type="text/javascript">
                      CKEDITOR.replace('page_content', {
                        filebrowserUploadUrl: '<?php echo $list_ckeditor_link_file; ?>',
                        filebrowserImageUploadUrl: '<?php echo $list_ckeditor_link_image; ?>',
                        filebrowserUploadMethod: 'form',
                      });
                    </script>
                  </div>
                </div>
                <div class="form-group row" style="display:none">
                  <label for="inputEmail3" class="col-sm-2 col-form-label"> Category : <span style='color:red'>*</span></label>
                  <div class="col-sm-10">
                    <select name="category_id" class="form-control">
                      <?php foreach ([1 => 'Root'] as $key => $value) :
                        $selected = "";
                        if ($current_page['category_id'] == $key) {
                          $selected = "selected=\"selected\"";
                        }
                      ?>
                        <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                          <?php echo $value; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <!--<input class="form-control" type="text" name="category_id" required value="<?php echo $current_page['category_id']; ?>">-->
                  </div>
                </div>
                <div class="form-group row" style="display:none">
                  <label for="inputEmail3" class="col-sm-2 col-form-label"> Language Code:<span style='color:red'>*</span></label>
                  <div class="col-sm-10">
                    <select name="language_code" class="form-control">
                      <?php foreach (['en' => 'English', 'hi' => 'Hindi'] as $key => $value) :
                        $selected = "";
                        if ($current_page['language_code'] == $key) {
                          $selected = "selected=\"selected\"";
                        }
                      ?>
                        <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                          <?php echo $value; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <!-- <input class="form-control" type="text" name="language_code" required value="<?php // echo $current_page['language_code']; 
                                                                                                      ?>">-->
                  </div>
                </div>
                <div class="form-group row" style="display:none">
                  <label for="inputEmail3" class="col-sm-2 col-form-label"> Status:<span style='color:red'>*</span></label>
                  <div class="col-sm-10">
                    <select name="status" class="form-control">
                      <?php foreach ([0 => 'Unpublished', 1 => 'Published'] as $key => $value) :
                        $selected = "";
                        if ($current_page['status'] == $key) {
                          $selected = "selected=\"selected\"";
                        }
                      ?>
                        <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                          <?php echo $value; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <!-- <input class="form-control" type="text" name="language_code" required value="<? php // echo $current_page['language_code']; 
                                                                                                      ?>">-->
                  </div>
                </div>
                <!-- <div class="form-group row article-container">
                  <label for="inputEmail3" class="col-sm-2 col-form-label"> Article </label>
                  <div class="col-sm-10">
                    <select name="menu_type" class="form-control">
                      <option value="">Select Menu type</option>
                      <?php foreach ([1 => 'Pag1', 'pagw2', 'Page3'] as $key => $value) :
                        $selected = "";
                        if ($current_page['m_menu_article_id'] == $key) {
                          $selected = "selected=\"selected\"";
                        }
                      ?>
                        <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div> -->
                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
                <script>
                  jQuery(document).ready(function() {
                    jQuery("input[name='menu_type']").on('change', function() {
                      if (jQuery(this).val() == 1) {
                        jQuery(".article-container").show();
                      } else {
                        jQuery(".article-container").hide();
                      }
                    });
                    jQuery("input[name='menu_type']").trigger('change');
                  });
                </script>
                <input type="hidden" value="<?php echo $current_page['page_id']; ?>" name="page_id">
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="submit" class="btn btn-info" name="save-page" value="Submit" style="margin: 0px 0px 0px -160px;">
                <input type="button" class="btn btn-default float-right" onclick="history.back();" value="Cancel" style="float: left !important; margin: 0px 0px 0px 310px;">
              </div>
              <!-- /.card-footer -->
            </form>
            <!-- <button class="btn btn-default float-right" onclick="goBack()">Cancel</button> -->
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- Main content section div end -->
</div>

<?php echo $this->get_footer(); ?>
<script src="<?php echo $this->theme_url; ?>/dist/js/jquery.validate.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo $this->theme_url; ?>/dist/js/sweetalert.min.js"></script>
    <link href="<?php echo $this->theme_url; ?>/dist/css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo $this->theme_url; ?>/dist/js/jquery-ui.js"></script>
    <script>

    $(document).ready(function () {

//page


    $("#edit_page_form").validate({
      ignore: [],
        rules: {
            title: {
                required: true,
                restrictedChars: true
            },
            page_content: {
                required: function(textarea) {
                  CKEDITOR.instances[textarea.id].updateElement();
                  var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                  return editorcontent.length === 0;
                 }
               }
            // Add rules for other fields here
        },
        messages: {
            title: {
                required: "Please enter a title",
                restrictedChars: "Special characters are not allowed."
            },
              page_content: {
                required: "Please enter page content"
              }
            // Add messages for other fields here
        },
        errorPlacement: function (error, element) {
        if (element.attr("id") === "page_content") {
            // Assuming you want to display CKEditor errors below the CKEditor field
            error.insertAfter("#cke_page_content");
        } else {
            // For other fields, display errors as usual
            error.insertAfter(element);
        }
    },
        submitHandler: function (form) {
            form.submit(); // Submit the form if it passes validation
        }

        // Manually trigger validation when CKEditor content changes
    
    });
    $.validator.addMethod("restrictedChars", function (value, element) {
  // Define the restricted characters
  var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
  return !restrictedChars.test(value);
}, "Special characters are not allowed.");
  
});

    </script>
