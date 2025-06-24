# WP_CustomContent
Inserting custom content into wordpress posts 

Purpose: A wordpress plugin to allow content to be written in separate files rather than in the wordpress text editor which can be quite limiting. 
The plugin allows separate html content, js scripts and css rules to be added. 
The html content is added before the post_content. Normal use has the wordpress text editor containing no content with the content  being contained in the separate custom content folder. This allows direct editing of the html file with a text editor such as notepad++ or VS Code. 
Any custom CSS files (1 per post) are linked to within the header of the page. 
JS scripts are inserted in the footer. 


General stucture: 
A folder named 'Custom' is added to the selected theme folder. Within this folder, three separate folders are added: 
Custom-content
custom-css
custom-js

Custom files are adding in each of the respective files with the post id or post slug identifying the file to use. 
Example, for post with id=200
Custom content file would be named: custom-content-200.php
CSS file would be: custom-css-200.css
and JS file would be custom-js-200.js


