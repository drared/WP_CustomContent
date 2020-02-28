<?php
/**
 * Plugin Name:       Include Custom Content
 * Plugin URI:        https://dalestake.com/2019/11/26/wordpress-add-custom-content-plugin/
 * Description:       Inserts files stored in 'Custom/Content/' into the content section (ie within the body of the post)
 * Version:           0.1
 * Author:            Dale Anderson
 * Author URI:        NA
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       include-custom-content
 */

// Check if a custom content file exists... 


add_action('wp_head','CheckForCustomContent');
$BaseCustomDir = "";
$CurID = "";
$FilePath = "";

function CheckForCustomContent()
{
	global $BaseCustomDir;
	global $CurID;
	global $FilePath;
	
	$BaseCustomDir = get_stylesheet_directory()."/Custom";
	$CurID = get_the_ID();
	$FilePath = $BaseCustomDir."/custom-css/custom-css-".$CurID.".css";
	if( is_single() )
	{
		
		// if post is singular...go ahead...
		
		// Check for custom CSS files. Link if file exists.
		if(file_exists ( $FilePath))
		{
			$RelFilePath = get_stylesheet_directory_uri()."/Custom/custom-css/custom-css-".$CurID.".css";
			// Custom CSS file exists so it is included 
			?>
			<!-- Custom CSS via plugin -->
			<link rel="stylesheet" type="text/css" href="<?php echo $RelFilePath; ?>" />
			<?php
		}
		
		// Check for custom content. Link if file exists.
		$FilePath = $BaseCustomDir."/Custom-content/custom-content-".$CurID.".php";
		//error_log("FilePath before insert content function: ".$FilePath);
		if(file_exists ( $FilePath))
		{
			//error_log("FilePath for content: ".$FilePath);
			add_filter('the_content', 'InsertCustomContent');	
		}
		
	}
	
};


function InsertCustomContent($content)
{
    
	global $FilePath;
    if(file_exists ( $FilePath))
    {
        $content = $content.file_get_contents($FilePath);
    }
    else
    {
        $content = $content;
    }
    return $content;
}

// 



