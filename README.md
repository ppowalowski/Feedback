Feedback
========

Magento Feedback Extension

How to Install:
- Disable Compilation in Magento
- Copy the /app/ and /skin/ folders to your magento root folder.
Access to Magento:
- Create two transactional email template: es: "New Feedback" and "Feedback Reply"
- In System -> Configuration -> Fancy Feedback -> Configuration set up the extension.
- In a footer/header CMS Block add the following two blocks:

Overlay block: this will include the overlay (without showing it)
{{block type="fancyfeedback/fancyfeedback" name="fancyfeedback" template="fancyfeedback/fancyfeedback_overlay.phtml" }}
Now if you append o=feedback to the url of the page you visit the feedback overlay will show up (es: http://yoursite.com/?o=feedback)


Optionally include the following block where you want to show a "Leave a Feedback" link that will open the form overlay:

{{block type="fancyfeedback/fancyfeedback" name="fancyfeedback" template="fancyfeedback/fancyfeedback_trigger.phtml" }}

- Eventually Re-enable Compilation
- Empy Magento Cache
