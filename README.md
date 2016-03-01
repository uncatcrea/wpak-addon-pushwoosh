# PushWoosh Addon for WP-AppKit
Addon to manage PushWoosh notifications with WP-AppKit.  
This addon currently supports and is tested with iOS and Android only.

## HOW TO SETUP
First things first, this addon only works with PushWoosh: https://www.pushwoosh.com/  
You can see its documentation here for more details and features: https://cp.pushwoosh.com/v2/docs

To start with setuping push notifications within your WP-AppKit app, you need a PushWoosh account.  
When logged in, you can manage your applications and the platforms each one is supporting through your PushWoosh dashboard.

![PushWoosh print screen](http://uncatcrea.github.io/wpak-addon-pushwoosh/printscreen.png)

Plus, you need to activate this addon for each WP-AppKit application that will use it, simply by checking the _WP AppKit PushWhoosh_ checkbox.

Once you created your app both in PushWoosh and WP-AppKit, you need to put its **Application Code** into the _PushWoosh ID_ field from WP-AppKit screen.

![PushWoosh WP-AppKit addon metabox print screen](http://uncatcrea.github.io/wpak-addon-pushwoosh/addon_metabox.png)

### Android
You need to register your app (create a _project_) in your Google Developers account. The global configuration between Google and PushWoosh is detailed here: http://docs.pushwoosh.com/docs/gcm-configuration

What you’ll need regarding this addon is to write down your Google Application **Project Number** and put it into the _Google Project ID_ field from WP-AppKit screen.

### iOS
You need to register your app in your Apple Developer account. The global configuration between Apple and PushWoosh is detailed here (Mac OSX only): http://docs.pushwoosh.com/docs/apns-configuration

If you want to create the needed certificates from Windows, you’ll find some help below. You’ll first need the openssl command line, for example by downloading OpenSSL binaries (https://www.openssl.org/community/binaries.html), or any tool that will bring you UNIX CLI commands (Cygwin, Git bash for Windows, etc.).

#### Generate a certificate request
Execute these commands:

    openssl genrsa -out mykey.key 2048
    openssl req -new -key mykey.key -out CertificateSigningRequest.certSigningRequest  -subj "/emailAddress=yourAddress@example.com, CN=John Doe, C=US"

#### Convert .cer file to .p12 (export certificate)
Execute these commands:

    openssl x509 -in apple_certificate.cer -inform DER -out apple_certificate.pem -outform PEM
    openssl pkcs12 -export -inkey mykey.key -in apple_certificate.pem -out exported_certificate.p12

Then, enter the password. You’ll need to enter it in PushWoosh configuration later.

One thing you need to understand here is that these certificates are only useful for PushWoosh to communicate with Apple servers, you’ll then need to get different certificates to be able to build and deploy your application.

_Sources for certificates generation with Windows:_
* _http://help.adobe.com/en_US/as3/iphone/WS144092a96ffef7cc-371badff126abc17b1f-8000.html_
* _http://help.adobe.com/en_US/as3/iphone/WS144092a96ffef7cc-371badff126abc17b1f-7fff.html_

## DEEP LINKS
Since WP-AppKit natively supports Deep Linking (as of v0.5), this addon just adds the ability to use it from notifications.

Deep Linking is a feature letting you open a specific screen of your app thanks to a single external link. This is especially useful when you are sending push notifications to your users and you want them to see a specific landing page when clicking on the notification.

This addon lets you achieve this goal, with one condition though: you must be able to send _Custom Data_ thanks to PushWoosh, meaning that you have at least a **Premium** account.

To use this feature, add the route you want the app to follow when the user clicks on the notification into the PushWoosh _Pass additional Custom Data to the app_ field, with the following format:  
`{ route: "[route]" }`

For example, to open the page with ID 1, included into the "all-pages" component, type in the following value:  
`{ route: "/page/all-pages/1" }`
