document.addEventListener('DOMContentLoaded',function() {
	jQuery('body').on('click','.js-submit',function(e) {
		e.preventDefault();

		orangejax.before(jQuery(this).closest('form'));
	});
});

/**
 * <form ...
 * method patch, post, get, put, delete
 * action uri to send the request
 * data-primaryFieldName primary id if other than "id"
 * data-confirm - show confirmation dialog before sending the request options include true or a message to show.
 * data-redirect - URL to redirect to on success
 * data-redirectOnFailure = URL to redirect to on failure
 * data-swap = weither to swap the method from Post to Patch AND insert hidden primary id
 * data-success = orangejax method to call on success
 * data-failure = orangejax method to call on failure
 * data-successMsg = messesage to display on success (this maybe queued for the next page load on redirect)
 *
 * Of course these can all be overridden becase they are simply anonyomus functions
 */

var orangejax = {};

orangejax.before = function(closestForm) {
	var form = {};

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
	 * form.attribute,
	 * form.fields
	 */

	orangejax.confirm(form);
}

orangejax.ajaxSubmit = function(form) {
	/* save this for later */
	orangejax.form = form;

	orangejax.primaryFieldName = (orangejax.form.attribute['data-primaryfieldname'] == undefined) ? 'id' : orangejax.form.attribute['data-primaryfieldname'];

	/* Incase you need to build a special uri ie. Laravel */
	var uri = orangejax.BuildURI();

	jQuery.ajax({
		method: form.attribute.method,
		url: uri,
		dataType: 'json',
		data: form.fields,
		cache: false,
		timeout: 5000,
		async: true,
		success: orangejax.processResponds,
		error: orangejax.ajaxError
	});
};

orangejax.ajaxError = function() {
	notify.addError('Processing Error.');
}

orangejax.processResponds = function(data, textStatus, jqXHR) {
	notify.removeAll();

	if (data.success == true) {
		var method = (orangejax.form.attribute['data-success'] == undefined) ? 'showSuccess' : orangejax.form.attribute['data-success'];
	} else {
		var method = (orangejax.form.attribute['data-failure'] == undefined) ? 'showError' : orangejax.form.attribute['data-failure'];
	}

	orangejax[method](data);
}

orangejax.showError = function(data) {
	for (var index in data.errors) {
		notify.addError(data.errors[index][0]);
	}

	orangejax.after(data);
};

orangejax.showSuccess = function(data) {
	/*
	now do we needs to:
	swap post and path? - yes Laravel
	add primary id in hidden?  - yes Laravel
	setup a success message?
	redirect?
	*/
	orangejax.swapPostPatch();
	orangejax.insertId(orangejax.primaryFieldName,data.input[orangejax.primaryFieldName]);

	successMessage = orangejax.form.attribute['data-successmsg'];

	if (successMessage) {
		if (successMessage != 'false') {
			successMessage = (successMessage == 'true') ? 'Record Saved' : successMessage;

			notify.save(notify.buildMsg(successMessage,'success'));
		}
	}

	redirect = orangejax.form.attribute['data-redirect'];

	orangejax.after(data);

	console.log(redirect,orangejax.form.attribute);

	if (redirect) {
		switch(redirect) {
			case '@action':
				window.location.href = orangejax.form.attribute.action;
				//console.log(orangejax.form.attribute.action);
			break;
			case '@back':
				window.history.back();
				//console.log(back);
			break;
			default:
				window.location.href = redirect;
				//console.log(redirect);
		}
	}
};

/* finally reguardless of success or error this is called */
orangejax.after = function(data) {
};

orangejax.confirm = function(form) {
	var text = form.attribute['data-confirm'];

	if (text == undefined || text == 'false') {
		/* If they didn't add or it's string false proceed to submitting the request. */
		orangejax.ajaxSubmit(form);
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
				orangejax.ajaxSubmit(form);
			}
		});
	}
};

orangejax.swapPostPatch = function(record) {
	jQuery('#'+orangejax.form.attribute.id).attr('method','PATCH');
};

orangejax.insertId = function(primaryFieldName,primaryValue) {
	jQuery('input[name="'+primaryFieldName+'"]').val(primaryValue);
}

orangejax.BuildURI = function(form) {
	/**
	 * If the primary id is NOT empty then it needs to be appended to the url
	 * Laravel Resourceful URIs
	 */
	var url = orangejax.form.attribute.action;
	var primaryValue = jQuery('input[name="'+orangejax.primaryFieldName+'"]').val();

	if (primaryValue != '') {
		url += '/' + primaryValue;
	}

	return url;
};
