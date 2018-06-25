# Mbiz_InvisibleCaptcha

This module adds the Invisible ReCaptcha from Google in all pages and setup the captcha only for the contact page.

Adding the JS in all pages is not a choice we made just because it's simple. It's also because most of the time you'll want to add the captcha in newsletter form and so on.

## Requirements

You need to get an API key from Google: https://www.google.com/recaptcha/admin

## How it works

You can setup the API key in the admin panel: `System > Configuration > General > Invisible Captcha`

In that page you can set your site details and of course you can disable completely the captcha.

You can also choose if you want it by default to be on some pages.

## Setup on my own form

It's easy.

Given the following example:

```html
<form method="post">
    <label>
        My Content
        <input type="text" name="content" />
    </label>
    <button type="submit">Send</button>
</form>
```

You just have to make few changes (only additions):

```diff
+<?php
+$_recaptcha = $this->helper('mbiz_invisiblecaptcha');
+?>
+
-<form method="post" id="myForm">
+<form method="post" id="myForm"
+    <?php if ($_recaptcha->isActive()): ?>
+        onsubmit="return captchaMyForm.uiSubmit('<?php echo $_recaptcha->getSiteKey(); ?>', onCaptchaMyFormSubmit, '#g-recaptcha-myform');"
+    <?php endif; ?>
+>
     <label>
         My Content
         <input type="text" name="content" />
     </label>
     <button type="submit">Send</button>
+
+    <?php if ($_recaptcha->isActive()): ?>
+        <div class="g-recaptcha" id="g-recaptcha-myform"></div>
+    <?php endif; ?>
+
 </form>
+
+<?php if ($_recaptcha->isActive()): ?>
+    <script type="text/javascript">
+        //<![CDATA[
+        var captchaMyForm = new MbizInvisibleRecaptchaForm('myForm', true);
+        var onCaptchaMyFormSubmit = captchaMyForm.onSubmit.bind(captchaMyForm);
+        //]]>
+    </script>
+<?php endif; ?>

```

## License

See the [LICENSE](https://github.com/monsieurbiz/Mbiz_InvisibleCaptcha/blob/master/LICENSE) file.

## Contributors

- The people of Monsieur Biz <https://monsieurbiz.com>
