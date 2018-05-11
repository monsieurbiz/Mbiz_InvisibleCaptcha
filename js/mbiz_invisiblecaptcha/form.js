var MbizInvisibleRecaptchaForm = Class.create();
MbizInvisibleRecaptchaForm.prototype = {
    initialize: function (formId, firstFieldFocus) {
        Validation.defaultOptions.onSubmit = false;
        this.dataForm = new VarienForm(formId, firstFieldFocus);
        Validation.defaultOptions.onSubmit = true;

        this.uiSubmit.bind(this);
        this.onSubmit.bind(this);
    },
    uiSubmit: function (siteKey, callback, recaptchaDivSelector) {
        if (this.dataForm.validator && this.dataForm.validator.validate()) {
            var recaptcha = document.querySelector(recaptchaDivSelector);
            grecaptcha.render(recaptcha.id, {
                'sitekey': siteKey,
                'badge': 'inline',
                'size': 'invisible',
                'callback': callback
            });
            grecaptcha.execute();
        }
        return false;
    },
    onSubmit: function (htmlCaptcha, token) {
        if (token !== "" && token !== "undefined") {
            this.dataForm.form.submit();
        }
    }
};
