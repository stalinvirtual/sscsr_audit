
$(document).ready(function () {
  // menu
$("#menu_form").validate({
  rules: {
    is_footer_menu: {
      required: true
    },
    menu_type: {
      required: true
    },
    menu_link: {
      required: true
    },
    menu_name: {
      required: true,
      maxlength:30,
      restrictedChars: true
    }
    // Add more rules as needed
  },
  messages: {
    is_footer_menu: {
      required: "Please select an option"
    },
    menu_type: {
      required: "Please select an option"
    },
    menu_link: {
      required: "Please enter a link"
    },
    menu_name: {
      required: "Please enter a menu name",
      maxlength: "Menu Name should be maximum length of 30 characters",
      restrictedChars: "Special characters are not allowed."
    }
    // Add more messages as needed
  },
});
$.validator.addMethod("restrictedChars", function (value, element) {
  // Define the restricted characters
  var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
  return !restrictedChars.test(value);
}, "Special characters are not allowed.");
});
$(document).ready(function () {
// phase Master
$('#phase_master_form').validate({ // initialize the plugin
  rules: {
    phase_name: {
      required: true,
      maxlength: 256,
      restrictedChars: true
    },
    creation_date: "required",
  },
  // Specify validation error messages
  messages: {
    phase_name: {
      required: "Please Enter Phase Name",
      maxlength: "Your Phase Name must be maximum 256 characters long",
      restrictedChars: "Special characters are not allowed."
    },
    creation_date: "Please Enter  Date",
  },errorPlacement: function(error, element) {
    if (element.attr("name") === "creation_date") {
// Place the error message after the image tag
error.insertAfter(element.next("img.ui-datepicker-trigger"));
} else {
// Use the default error placement for other fields
error.insertAfter(element);
}
},
  // Make sure the form is submitted to the destination defined
  // in the "action" attribute of the form when valid
   submitHandler: function (form) {
    form.submit();
  }
});
$("#phase_master_form").on("submit", function(){
});
$.validator.addMethod("restrictedChars", function (value, element) {
  // Define the restricted characters
  var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
  return !restrictedChars.test(value);
}, "Special characters are not allowed.");
});

$(document).ready(function () {
//debarred_list
  $('#debarred_list_form').validate({ // initialize the plugin
      rules: {
        pdf_name: {
          required: true,
          maxlength: 256,
          restrictedChars: true // Use the custom validation rule 
        },
        effect_from_date: {
          required : true
        },
        attachment: "required",
      },
      // Specify validation error messages
      messages: {
        pdf_name: {
          required: "Please Enter Debarred List Name;;;;",
          maxlength: "Your Exam Name must be maximum 256 characters long",
          restrictedChars: "Special characters are not allowed."
        },
        effect_from_date:{
          required : "Please Enter  From Date",
        },
        attachment: "Please provide a Attachment.",
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") === "effect_from_date") {
    // Place the error message after the image tag
    error.insertAfter(element.next("img.ui-datepicker-trigger"));
    } else {
    // Use the default error placement for other fields
    error.insertAfter(element);
    }
    },
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
       submitHandler: function (form) {
        form.submit();
      }
    });
    $("#debarred_list_form").on("submit", function(){
    });
    $.validator.addMethod("restrictedChars", function (value, element) {
      // Define the restricted characters
      var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
      return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
    }); 
  /***************** Debarred List field validation below ****************/	
  // $('#pdf_name').on("cut copy paste",function(e) {
  //   e.preventDefault();
  // });
  $("#pdf_name").keypress(function (e) {
    var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
    var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
    if(!regex.test(key)){
    event.preventDefault();
    return false;
    }
     });
/***   Debarred List Page Validation    ***/

$(document).ready(function () {
$('#nomination_form').validate({ // initialize the plugin
  rules: {
    exam_name: {
      required: true,
      maxlength: 256,
      restrictedChars: true // Use the custom validation rule 
    },
    effect_from_date: "required",
    effect_to_date: {
      required: true,
      greaterNominationlist: "#effect_from_date"
    }, 
    'pdf_name[]': {
      required: true
  },
  'pdf_file[]': {
      required: true,
      extension: 'pdf'
  }
  },
  // Specify validation error messages
  messages: {
    exam_name: {
      required: "Please Enter Nomination  Name",
      maxlength: "Your Exam Name must be maximum 256 characters long",
      restrictedChars: "Special characters are not allowed."
    },
    effect_from_date: "Please Enter  From Date",
    effect_to_date:
    {
      required: "Please Enter To Date",
      greaterNominationlist: "Must be greater than From date"
    },
    'pdf_name[]': {
      required: "Please enter a PDF name"
  },
  'pdf_file[]': {
      required: "Please select a PDF file",
      extension: "Please upload a valid PDF file"
  }
  },
  errorPlacement: function(error, element) {
    if (element.attr("name") === "effect_from_date") {
// Place the error message after the image tag
error.insertAfter(element.next("img.ui-datepicker-trigger"));
} else if (element.attr("name") === "effect_to_date") {
// Place the error message after the Select2 element
error.insertAfter(element.next("img.ui-datepicker-trigger"));
} else {
// Use the default error placement for other fields
error.insertAfter(element);
}
},
  submitHandler: function (form) {
    form.submit();
  }
});

jQuery.validator.addMethod("greaterNominationlist", function (value, element, params) {
  var startDate = document.getElementById("effect_from_date").value;
    //Convert DD-MM-YYYY to YYYY-MM-DD format using Javascript
  var startDate = startDate.split("-").reverse().join("-");
  var endDate = document.getElementById("effect_to_date").value;
   //Convert DD-MM-YYYY to YYYY-MM-DD format using Javascript
  var endDate = endDate.split("-").reverse().join("-");
  var startDateParseData = Date.parse(startDate) ;
  var endDateParseData = Date.parse(endDate) ;
return this.optional(element) || endDateParseData >= startDateParseData;
}, 'Must be greater than start date.');
$("#nomination_form").on("submit", function(){
});
$.validator.addMethod("restrictedChars", function (value, element) {
  // Define the restricted characters
  var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
  return !restrictedChars.test(value);
}, "Special characters are not allowed.");
}); 

/***  Notice Validation    ***/
$(document).ready(function () {
  jQuery.validator.addMethod("maxfilesize", function(value, element, param) {
    if (element.files.length > 0) {
    return element.files[0].size <= param;
    }
    return true; // No file selected, so it's valid
}, "File size must be less than 5 MB");
  $('#notice_form').validate({ // initialize the plugin
    rules: {
      pdf_name: {
        required: true,
        maxlength: 256,
        restrictedChars: true // Use the custom validation rule 
      },
      effect_from_date: "required",
      effect_to_date: {
        required: true,
        //greaterNotice: "#effect_from_date"
      }, 
      attachment: {
        required: true,
        maxfilesize: 5242880,
        //greaterNotice: "#effect_from_date"
      },
    },
    // Specify validation error messages
     messages: {
      pdf_name: {
        required: "Please Enter Notice  Name",
        maxlength: "Your Exam Name must be maximum 256 characters long",
        restrictedChars: "Special characters are not allowed."
        
      },
      effect_from_date: "Please Enter  From Date",
      effect_to_date:
      {
        required: "Please Enter To Date",
        greaterNotice: "Must be greater than From date"
      },
      attachment: {
        required: "Please select a PDF file",
        //accept: "Only PDF files are allowed",
        maxfilesize: "File size must be less than 5 MB"
        }
    }, errorPlacement: function(error, element) {
      if (element.attr("name") === "effect_from_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else if (element.attr("name") === "effect_to_date") {
  // Place the error message after the Select2 element
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
     submitHandler: function (form) {
      form.submit();
    }
  });
  jQuery.validator.addMethod("greaterNotice", function (value, element, params) {
    //debugger;
      var startDate = document.getElementById("effect_from_date").value;
      var startDate = startDate.split("-").reverse().join("-");
      var endDate = document.getElementById("effect_to_date").value;
      var endDate = endDate.split("-").reverse().join("-");
      var startDateParseData = Date.parse(startDate) ;
      var endDateParseData = Date.parse(endDate) ;
    return this.optional(element) || endDateParseData >= startDateParseData;
  }, 'Must be greater than start date.');
  $("#notice_form").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 
/***************** Notice field validation below ****************/	
// $('#pdf_name').on("cut copy paste",function(e) {
//   e.preventDefault();
// });
$("#pdf_name").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/***   Notice Page Validation    ***/

/***  Tende Validation    ***/
$(document).ready(function () {
  jQuery.validator.addMethod("maxfilesize", function(value, element, param) {
    if (element.files.length > 0) {
    return element.files[0].size <= param;
    }
    return true; // No file selected, so it's valid
}, "File size must be less than 5 MB");
  $('#tenderForm').validate({ // initialize the plugin
      rules: {
      pdf_name: {
        required: true,
        maxlength: 100,
        restrictedChars: true // Use the custom validation rule 
      },
      effect_from_date: "required",
      effect_to_date: {
        required: true,
        greaterTender: "#effect_from_date"
      }, 
      attachment: {
        required: true,
        maxfilesize: 5242880,
        //greaterNotice: "#effect_from_date"
      },
    },
    // Specify validation error messages
   messages: {
      pdf_name: {
        required: "Please Enter Tender  Name",
        maxlength: "Your Exam Name must be maximum 100 characters long",
        restrictedChars: "Special characters are not allowed."
      },
      effect_from_date: "Please Enter  From Date",
      effect_to_date:
      {
        required: "Please Enter To Date",
        greaterTender: "Must be greater than From date"
      },
      attachment: {
        required: "Please select a PDF file",
        //accept: "Only PDF files are allowed",
        maxfilesize: "File size must be less than 5 MB"
        }
    }, errorPlacement: function(error, element) {
      if (element.attr("name") === "effect_from_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else if (element.attr("name") === "effect_to_date") {
  // Place the error message after the Select2 element
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
     submitHandler: function (form) {
      form.submit();
    }
  });
  jQuery.validator.addMethod("greaterTender", function (value, element, params) {
      var startDate = document.getElementById("effect_from_date").value;
      var startDate = startDate.split("-").reverse().join("-");
      var endDate = document.getElementById("effect_to_date").value;
      var endDate = endDate.split("-").reverse().join("-");
      var startDateParseData = Date.parse(startDate) ;
      var endDateParseData = Date.parse(endDate) ;
    return this.optional(element) || endDateParseData >= startDateParseData;
  }, 'Must be greater than start date.');
  $("#tenderForm").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 
/***************** Tender validation below ****************/	
// $('#pdf_name').on("cut copy paste",function(e) {
//   e.preventDefault();
// });
$("#pdf_name").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/***  Tender Page Validation    ***/
/***  Important Links Validation    ***/
$(document).ready(function () {
  $('#importantLinkForm').validate({ // initialize the plugin
      rules: {
      link_name: {
        required: true,
        maxlength: 100,
        restrictedChars: true // Use the custom validation rule 
      },
      menu_link:{
	  required : true,
	  url:true
	  },
    creation_date:{
      required:true,
    }
 },
    // Specify validation error messages
    messages: {
      link_name: {
        required: "Please Enter Link  Name",
        maxlength: "Your Exam Name must be maximum 100 characters long",
        restrictedChars: "Special characters are not allowed."
      },
	  menu_link: {
        required: "Please Enter Link  URL ",
        url: "Please Enter Valid URL"
      },
      creation_date:{
        required:"Please select creation date",
      }
    },errorPlacement: function(error, element) {
      if (element.attr("name") === "creation_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
     submitHandler: function (form) {
      form.submit();
    }
  });
  $("#importantLinkForm").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 
/***************** Tender validation below ****************/	
$('#link_name').on("cut copy paste",function(e) {
  e.preventDefault();
});
$("#link_name").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/***  Important Links Page Validation    ***/
/*****     Menu Page Validation */
$('#menu_name').on("cut copy paste",function(e) {
  e.preventDefault();
});
$("#menu_name").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/*****     Menu Page Validation */
/*****     Page Validation */
// $('#title').on("cut copy paste",function(e) {
//   e.preventDefault();
// });
$("#title").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/*****    Page Validation */
function validateImages() {
  var imageInputs = $('input[type="file"]');
  var imageCount = 0;
  imageInputs.each(function() {
      if ($(this).val() !== "") {
          imageCount++;
      }
  });
  return imageCount > 0;
}
// Event Category Form
$(document).ready(function () {
  $('#event_category_form').validate({ // initialize the plugin
    rules: {
      event_name: {
        required: true,
        maxlength: 256,
        restrictedChars: true // Use the custom validation rule
      },
      creation_date: "required"
    },
    // Specify validation error messages
    messages: {
      event_name: {
        required: "Please Enter Enter  Name",
        maxlength: "Your Exam Name must be maximum 256 characters long",
        restrictedChars: "Special characters are not allowed."
      },
      creation_date: "Please Enter  Creation  Date"
    },errorPlacement: function(error, element) {
      if (element.attr("name") === "creation_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function (form) {
      form.submit();
    }
  });
  $("#event_category_form").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 
  $('#event_name').on("cut copy paste",function(e) {
    e.preventDefault();
  });
  $("#event_name").keypress(function (e) {
    var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
    var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
    if(!regex.test(key)){
    event.preventDefault();
    return false;
    }
     });
// Event Category Form
//Photo gallery
//Photo gallery
//  Category Form
$(document).ready(function () {
  $('#editgallery_form').submit(function(e) {
    if (!validateImages()) {
      e.preventDefault(); // Prevent form submission
      swal("Please upload at least one image", "", "warning");
  }
  });
  $('#category_form').validate({ // initialize the plugin
    rules: {
      category_name: {
        required: true,
        maxlength: 256,
        restrictedChars: true // Use the custom validation rule
      },
    },
    // Specify validation error messages
    messages: {
      category_name: {
        required: "Please Enter Category  Name",
        maxlength: "Your Category must be maximum 256 characters long",
        restrictedChars: "Special characters are not allowed."
      },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function (form) {
      form.submit();
    }
  });

  $("#category_form").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 
  $('#category_name').on("cut copy paste",function(e) {
    e.preventDefault();
  });
  $("#category_name").keypress(function (e) {
    var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
    var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
    if(!regex.test(key)){
    event.preventDefault();
    return false;
    }
     });
//  Category Form
// Faq Form
$(document).ready(function () {
  //  Form id 
  $('#faq_form').validate({ // initialize the plugin
    rules: {
      faq_title: {
        required: true,
        maxlength: 500,
        restrictedChars: true // Use the custom validation rule
      },
      faq_content: {
        required: true,
        maxlength: 500
      },
      effect_from_date: "required"
    },
    // Specify validation error messages
    messages: {
      faq_title: {
        required: "Please Enter Faq  Title",
        maxlength: "Your Faq must be maximum 500 characters long",
        restrictedChars: "Special characters are not allowed."
      },
      faq_content: {
        required: "Please Enter Faq  Content",
        maxlength: "Your Exam Name must be maximum 500 characters long"
      },
      effect_from_date: "Please Enter  From Date",
    }, errorPlacement: function(error, element) {
      if (element.attr("name") === "effect_from_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  }else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function (form) {
      form.submit();
    }
  });
  $("#faq_form").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  });
  // $('#faq_title').on("cut copy paste",function(e) {
  //   e.preventDefault();
  // });
  $("#faq_title").keypress(function (e) {
    var regex = new RegExp('^[a-zA-Z0-9 _.,(),-?]*$');
    var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
    if(!regex.test(key)){
    event.preventDefault();
    return false;
    }
     });
  // $('#faq_content').on("cut copy paste",function(e) {
  //   e.preventDefault();
  // });
  $("#faq_content").keypress(function (e) {
    var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
    var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
    if(!regex.test(key)){
    event.preventDefault();
    return false;
    }
     });
// Faq Form
/***  Announcement Validation    ***/
/***************** Announcement validation below ****************/	
// $('#announcement_name').on("cut copy paste",function(e) {
//   e.preventDefault();
// });
$("#announcement_name").keypress(function (e) {
  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');
  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);
  if(!regex.test(key)){
  event.preventDefault();
  return false;
  }
   });
/***  Announcement Page Validation    ***/
///selectionpost
/***  Selection Post Validation    ***/


$(document).ready(function () {

  $('#selection_post_form').validate({ // initialize the plugin
    rules: {
      exam_name: {
        required: true,
        maxlength: 256,
        restrictedChars: true 
      },
      effect_from_date: {
        required :true
      },
      effect_to_date: {
        required: true,
        greaterSelectionPost: "#effort_from_date"
      }, 
      'pdf_name[]': {
        required: true
    },
    'pdf_file[]': {
        required: true,
        extension: 'pdf'
    }


    },
    // Specify validation error messages
    messages: {
      exam_name: {
        required: "Please Enter Selection Post  Name",
        maxlength: "Your Exam Name must be maximum 256 characters long",
        restrictedChars: "Special characters are not allowed."
      },
      effect_from_date: {
        required :"Please Enter  From Date"
      } ,
      effect_to_date:
      {
        required: "Please Enter To Date",
        greaterSelectionPost: "Must be greater than From date"
      },
      'pdf_name[]': {
        required: "Please enter a PDF name"
    },
    'pdf_file[]': {
        required: "Please select a PDF file",
        extension: "Please upload a valid PDF file"
    }

    }, errorPlacement: function(error, element) {
      if (element.attr("name") === "effect_from_date") {
  // Place the error message after the image tag
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else if (element.attr("name") === "effect_to_date") {
  // Place the error message after the Select2 element
  error.insertAfter(element.next("img.ui-datepicker-trigger"));
  } else {
  // Use the default error placement for other fields
  error.insertAfter(element);
  }
  },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function (form) {
      form.submit();
    }
  });
  jQuery.validator.addMethod("greaterSelectionPost", function (value, element, params) {



    var startDate = document.getElementById("effort_from_date").value;
    var startDate = startDate.split("-").reverse().join("-");
    var endDate = document.getElementById("effect_to_date").value;
    var endDate = endDate.split("-").reverse().join("-");
    var startDateParseData = Date.parse(startDate) ;
    var endDateParseData = Date.parse(endDate) ;
  return this.optional(element) || endDateParseData >= startDateParseData;
}, 'Must be greater than start date.');


  $("#selection_post_form").on("submit", function(){
  });
  $.validator.addMethod("restrictedChars", function (value, element) {
    // Define the restricted characters
    var restrictedChars = /[@#$%^*<>;:=_?~,{}\\]/;
    return !restrictedChars.test(value);
  }, "Special characters are not allowed.");
  }); 


/***************** Selection Post field validation below ****************/	

// $('#exam_name').on("cut copy paste",function(e) {
//   e.preventDefault();
// });

$("#exam_name").keypress(function (e) {


  var regex = new RegExp('^[a-zA-Z0-9 _.,(),-]*$');

  var key = String.fromCharCode(!event.charcode ? event.which : event.charcode);

  if(!regex.test(key)){


  event.preventDefault();
  return false;
  }

   });




/***   Selection Post Page Validation    ***/