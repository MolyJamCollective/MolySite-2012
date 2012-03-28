/* =========================================================
 * jquery.jigowatt.js
 * Author: Jigowatt
 * ========================================================= */

$(function () {
	"use strict";

    // add active class to nav links
    // =============================
    var path = location.pathname.substr(location.pathname.lastIndexOf("/") + 1);
    if (path) {
		$('#findme li a[href$="' + path + '"]').parent().attr('class', 'active');
	}

    // focus inputs on load
    // ====================
    if ($('#CurrentPass').length) {
        $('#CurrentPass').focus();
    } else if ($('#name').length) {
        $('#name').focus();
    } else if ($('#username').length) {
        $('#username').focus();
    }

});

// checkbox logic
// ==============
$('.add-on :checkbox').click(function () {
	"use strict";
    if ($(this).attr('checked')) {
        $(this).parents('.add-on').addClass('active');
    } else {
        $(this).parents('.add-on').removeClass('active');
    }
});

// forgotten password modal
// ========================
$('#forgot-form').bind('shown', function () {
	"use strict";
    $('#usernamemail').focus();
});

$('#forgot-form').bind('hidden', function () {
	"use strict";
    $('#username').focus();
});

$("#sign-up-form").validate({
	rules: {
		name: "required",
		username: {
			required: true,
			minlength: 2,
			remote: {
				url: "classes/class.signup.php",
				type: "post",
				data: { checkusername: "1" }
			}
		},
		password: {
			required: true,
			minlength: 5
		},
		validation: {
			required: true
		},
		password_confirm: {
			required: true,
			minlength: 5,
			equalTo: "#password"
		},
		email: {
			required: true,
			email: true,
			remote: {
				url: "classes/class.signup.php",
				type: "post",
				data: { checkemail: "1" }
			}
		}
	},
	messages: {
		name: "I know you've got one.",
		username: {
			required: "You need a username!",
			minlength: $.format("Enter at least {0} characters"),
			remote: jQuery.format("Username has been taken.")
		},
		password: {
			required: "Create a password",
			minlength: $.format("Enter at least {0} characters")
		},
		password_confirm: {
			required: "Confirm your password",
			minlength: $.format("Enter at least {0} characters"),
			equalTo: "Your passwords do not match."
		},
		email: {
			required: "What's your email address?",
			email: "Doesn't look like a valid email :(",
			remote: jQuery.format("Email address is in use.")
		},
		validation: "Maybe you're a robot? >_>"
   },
	errorClass: 'error',
	validClass: 'success',
	errorElement: 'p',
	highlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(validClass).addClass(errorClass);
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(errorClass).addClass(validClass);
	},
});

$('#forgotform').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#forgotsubmit').button('loading');

    var post = $('#forgotform').serialize();
    var action = $(this).attr('action');

    $("#message").slideUp(350, function () {

        $('#message').hide();

        $.post(action, post, function (data) {
            $('#message').html(data);
            document.getElementById('message').innerHTML = data;
            $('#message').slideDown('slow');
            $('#usernamemail').focus();
            if (data.match('success') !== null) {
                $('#forgotform').slideUp('slow');
                $('#forgotsubmit').button('complete');
                $('#forgotsubmit').click(function (eb) {
                    eb.preventDefault();
                    $('#forgot-form').modal('hide');
                });
            } else {
                $('#forgotsubmit').button('reset');
            }
        });
    });
});

// The following thanks to @dsully
// https://github.com/twitter/bootstrap/pull/581#issuecomment-4232108
$(document).ready(function() {

	// Handle tabs, page reloads & browser forward/back history.
	var History = window.History;

	if (!History.enabled) {
	  return false;
	}

	$(window).bind('load statechange', function () {
	  var State = History.getState();
	  var hash  = History.getHash();

	  // Our default tab.
	  if (!State.data || !State.data.tab) {
		if (hash) {
		  State.data.tab = hash;
		  window.location.hash = '';
		} else {
		  State.data.tab = 'general-options';
		}
	  }

	  $('a[href="#' + State.data.tab + '"]').tab('show');
	});

	$('a[data-toggle="tab"]').on('shown', function (event) {

	  // Set the selected tab to be the current state. But don't update the URL.
	  var url = event.target.href.split("#")[0];
	  var tab = event.target.href.split("#")[1];

	  var State = History.getState();

	  // Don't set the state if we haven't changed tabs.
		if (State.data.tab != tab) {
			History.pushState({'tab': tab}, null, url);
		}
	});
  });