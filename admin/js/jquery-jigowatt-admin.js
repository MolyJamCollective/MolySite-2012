// Admin profile fields
$('button.add-field').live('click', function(e) {
	e.preventDefault();
	var size = $('table.profile-field-rows tbody .profile-field-row').size();
	// Make sure tbody exists
	var tbody_size = $('table.profile-field-rows tbody').size();
	if (tbody_size==0) $('table.profile-field-rows').append('<tbody></tbody>');
	// Add the row
	var addThis = $('<tr class="profile-field-row">\
		<td><a href="#profileModal" class="btn btn-danger remove-button" data-toggle="modal"><i class="icon-trash icon-white"></i></a></td>\
		<td><select name="profile-field_type[' + size + ']">\
			<option value="text_input[' + size + ']">Text input</option>\
			<option value="textarea[' + size + ']">Textarea</option>\
			<option value="checkbox[' + size + ']">Checkbox</option>\
		</select></td>\
		<td><input type="text" value="" name="profile-field_name[' + size + ']" class="input-xlarge" /></td>').fadeIn();
	$('table.profile-field-rows tr:last').before(addThis);
});
$('a.remove-button').live('click', function() {
	var id = $(this);
	$('#profileModal').modal('show');
	$('a.delete-field').live('click', function() {
		$('#profileModal').modal('hide');
		$('input', $(id).parent().parent()).val('');
		$(id).parent().parent().fadeOut();
	});
});

// admin add user form
// ========================
$('#user-add-form').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#user-add-submit').button('loading');

    var post = $('#user-add-form').serialize();
    var action = $(this).attr('action');

    $("#message").slideUp(350, function () {

        $('#message').hide();

        $.post(action, post, function (data) {

            $('#message').html(data);

            document.getElementById('message').innerHTML = data;
            $('#message').slideDown('slow');
            if (data.match('success') !== null) {
				$('#user-add-form :text').val('');
                $('#user-add-submit').button('reset');
            } else {
                $('#user-add-submit').button('reset');
            }
        });
    });
});

// admin add level form
// ========================
$('#level-add-form').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#level-add-submit').button('loading');

    var post = $('#level-add-form').serialize();
    var action = $(this).attr('action');

    $("#level-message").slideUp(350, function () {

        $('#level-message').hide();

        $.post(action, post, function (data) {

            $('#level-message').html(data);

            document.getElementById('level-message').innerHTML = data;
            $('#level-message').slideDown('slow');
            if (data.match('success') !== null) {
				$('#level-add-form :text').val('');
                $('#level-add-submit').button('reset');
            } else {
                $('#level-add-submit').button('reset');
            }
        });
    });
});

// Add user form
$("#user-add-form").validate({
	rules: {
		name: "required",
		username: {
			required: true,
			minlength: 2,
			remote: {
				url: "classes/class.add_user.php",
				type: "post",
				data: { checkusername: "1" }
			}
		},
		email: {
			required: true,
			email: true,
			remote: {
				url: "classes/class.add_user.php",
				type: "post",
				data: { checkemail: "1" }
			}
		}
	},
	messages: {
		name: "Please enter a name.",
		username: {
			required: "Username is required.",
			minlength: $.format("Enter at least {0} characters"),
			remote: jQuery.format("Username has been taken.")
		},
		email: {
			required: "We need an email address too.",
			email: "Doesn't look like a valid email :(",
			remote: jQuery.format("Email address is in use.")
		}
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

// Create level form
$("#level-add-form").validate({
	rules: {
		level: "required",
		auth: {
			required: true,
			remote: {
				url: "classes/class.add_level.php",
				type: "post",
				data: { checklevel: "1" }
			}
		}
	},
	messages: {
		level: {
			required: "This needs to be filled out.",
			remote: jQuery.format("Username has been taken.")
		},
		auth: {
			required: "An auth level is required.",
			remote: jQuery.format("Auth level in use.")
		}
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

// Save settings
$('#settings-form').submit(function (e) {
	"use strict";

    e.preventDefault();
    $('#save-settings').button('loading');

    var post = $('#settings-form').serialize();
    var action = $(this).attr('action');

    $("#message").slideUp(350, function () {

        $('#message').hide();

        $.post(action, post, function (data) {
            $('#message').html(data);
            $('#message').slideDown('slow');
            if (data.match('success') !== null) {
                $('#save-settings').button('complete');
            } else {
                $('#save-settings').button('reset');
            }
        });
    });
});