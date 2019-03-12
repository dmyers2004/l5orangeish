document.addEventListener('DOMContentLoaded',function() {
	jQuery('body').on('click','.js-submit',function(e) {
		e.preventDefault();
		orangeJax.before($(this),jQuery(this).closest('form'));
	});
});

/**
 * <form ...
 * method
 * patch, post, get, put, delete
 *
 * action
 * uri to send the ajax request
 *
 * Optional name of primary id input if other than default "id"
 * data-primaryFieldName
 *
 * Optional confirmation dialog text to show before sending the request
 * options include true which default the message to "Are you sure?"
 * and false (or just don't include it on the form element)
 * data-confirm
 *
 * Optional URL to redirect to on success
 * data-redirect
 *
 * Optional URL to redirect to on failure
 * data-redirectOnFailure
 *
 * Optional orangeJax method to call on success
 * defaults to showSuccess
 * data-success
 *
 * Optional orangeJax method name to call on failure
 * defaults to showError
 * data-failure
 *
 * Optional orangeJax method name to call after success or failure
 * defaults to after
 * data-after
 *
 * Optional message to display on success
 * optionally the value "true" will use the default "Record Saved"
 * this maybe queued for the next page load if a redirect is specified
 * data-successMsg
 *
 * Of course these can all be overridden because they are simply anonymous functions
 */

var orangeJax = {};

orangeJax.before = function(element,closestForm) {
	var form = {};

	form.element = element;
	form.closestForm = closestForm;

	/* grab all of the form fields */
	form.fields = closestForm.serializeArray();

	form.attribute = {};

  /* collect all of the attributes on the closest form element */
	jQuery.each(closestForm[0].attributes, function(index, attribute) {
    form.attribute[attribute.name] = attribute.value;
  });

	/**
	 * Append anything else to
	 * form,
	 * form.fields,
	 * form.attribute
	 */

console.log(form);

	orangeJax.confirm(form);
}

orangeJax.ajaxSubmit = function(form) {
	/* save this for later */
	orangeJax.form = form;

	orangeJax.primaryFieldName = (orangeJax.form.attribute['data-primaryfieldname'] == undefined) ? 'id' : orangeJax.form.attribute['data-primaryfieldname'];

	/* Incase you need to build a special uri ie. Laravel */
	var uri = orangeJax.BuildURI();

	jQuery.ajax({
		method: form.attribute.method,
		url: uri,
		dataType: 'json',
		data: form.fields,
		cache: false,
		timeout: 5000,
		async: true,
		success: orangeJax.processResponds,
		error: orangeJax.ajaxError
	});
};

orangeJax.ajaxError = function() {
	notify.addError('Processing Error.');
}

orangeJax.processResponds = function(data, textStatus, jqXHR) {
	notify.removeAll();

	if (data.success == true) {
		var method = (orangeJax.form.attribute['data-success'] == undefined) ? 'showSuccess' : orangeJax.form.attribute['data-success'];
	} else {
		var method = (orangeJax.form.attribute['data-failure'] == undefined) ? 'showError' : orangeJax.form.attribute['data-failure'];
	}

	orangeJax[method](data);
}

orangeJax.showError = function(data) {
	/* Laravel Message Bag Style */
	for (var index in data.errors) {
		notify.addError(data.errors[index][0]);
	}

	var method = (orangeJax.form.attribute['data-after'] == undefined) ? 'after' : orangeJax.form.attribute['data-after'];

	orangeJax[method](data);
};

orangeJax.showSuccess = function(data) {
	/*
	now do we needs to:
	swap post and path? - yes Laravel
	add primary id in hidden?  - yes Laravel
	setup a success message?
	redirect?
	*/
	orangeJax.swapPostPatch(data);
	orangeJax.insertId(orangeJax.primaryFieldName,data.input[orangeJax.primaryFieldName]);

	var redirect = orangeJax.form.attribute['data-redirect'];
	var successMessage = orangeJax.form.attribute['data-successmsg'];

	if (successMessage) {
		if (successMessage != 'false') {
			successMessage = (successMessage == 'true') ? 'Record Saved' : successMessage;

			if (redirect) {
				notify.save(notify.buildMsg(successMessage,'success'));
			} else {
				notify.addSuccess(successMessage);
			}
		}
	}

	var method = (orangeJax.form.attribute['data-after'] == undefined) ? 'after' : orangeJax.form.attribute['data-after'];

	orangeJax[method](data);

	if (redirect) {
		switch(redirect) {
			case '@action':
				window.location.href = orangeJax.form.attribute.action;
			break;
			case '@back':
				window.history.back();
			break;
			default:
				window.location.href = redirect;
		}
	}
};

/* finally regardless of success or error this is called (default) */
orangeJax.after = function(data) {
};

/* optional destroy "after" */
orangeJax.destroy = function(data) {
	orangeJax.form.element.closest('tr').fadeOut(400,function(){
		orangeJax.form.element.remove();
	});
}

orangeJax.confirm = function(form) {
	var text = form.attribute['data-confirm'];

	if (text == undefined || text == 'false') {
		/* If they didn't add or it's string false so proceed to submitting the request. */
		orangeJax.ajaxSubmit(form);
	} else {
		/* Show the dialog. */
		text = (text == 'true') ? 'Are You Sure?' : text;

		/**
		 * Show Dialog
		 *
		 * Bootbox provides three functions, alert, confirm, and prompt,
		 * whose aim is to mimic their native JavaScript equivalents.
		 *
		 * http://bootboxjs.com/
		 *
		 * <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
		 */
		bootbox.confirm(text,function(result) {
			/**
			 * if result is true then they pressed ok
			 * if result is false then they pressed cancel
			 */
			if (result) {
				/* Proceed to submitting the request. */
				orangeJax.ajaxSubmit(form);
			}
		});
	}
};

orangeJax.swapPostPatch = function(data) {
	orangeJax.form.closestForm.attr('method','PATCH');
};

orangeJax.insertId = function(primaryFieldName,primaryValue) {
	jQuery('input[name="'+primaryFieldName+'"]').val(primaryValue);
}

orangeJax.BuildURI = function(form) {
	/**
	 * If the primary id is NOT empty then it needs to be appended to the url
	 * Laravel Resourceful URIs
	 */
	var url = orangeJax.form.attribute.action;

	if (orangeJax.form.attribute.method == 'PATCH') {
		url += '/' + jQuery('input[name="' + orangeJax.primaryFieldName + '"]').val();
	}

	return url;
};
