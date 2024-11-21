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
 * NOTE: 	      Still needs further testing
 */

// Check if a custom content file exists... 
add_action('wp_head','CheckForCustomContent');
$BaseCustomDir = "";
$CurID = "";
$FilePath_ID = "";
$FilePath_Slug = "";



function CheckForCustomContent()
{
	global $BaseCustomDir;
	global $CurID;
	global $FilePath_ID;
	global $FilePath_Slug;
	global $post;

	

	// A folder for custom files is manually added to the appropriate location
	$BaseCustomDir = get_stylesheet_directory()."/Custom";
	
	// The post id is used to correctly identify the files to include
	$CurID = get_the_ID(); 
	//$FilePath = $BaseCustomDir."/custom-css/custom-css-".$CurID.".css";
	// Alternatively, the post's slug can (maybe 'should') be used
	$slug = $post->post_name;

	// Only want to include custom content when a single post is being shown 
	if( is_singular() )  // if post is singular...go ahead...	
	{

		$FilePath_ID = $BaseCustomDir."/custom-css/custom-css-".$CurID.".css";
		// Check for custom CSS files. Link if file exists. Filename must be exact. 

		if(file_exists ( $FilePath_ID))
		{
			//$RelFilePath = get_stylesheet_directory_uri()."/Custom/custom-css/custom-css-".$CurID.".css";
			$RelFilePath = get_stylesheet_directory_uri()."/Custom/custom-css/custom-css-".$CurID.".css";
			// Custom CSS file exists so it is included 
			?>
			<!-- Custom CSS via plugin -->
			<link rel="stylesheet" type="text/css" href="<?php echo $RelFilePath; ?>" />
			<?php
		}


		$FilePath_Slug = $BaseCustomDir."/custom-css/".$slug.".css";
		// Check for custom CSS files. Link if file exists. Filename must be exact. 

		if(file_exists ( $FilePath_Slug))
		{
			
			//$RelFilePath = get_stylesheet_directory_uri()."/Custom/custom-css/custom-css-".$CurID.".css";
			$RelFilePath = get_stylesheet_directory_uri()."/Custom/custom-css/".$slug.".css";

			// Custom CSS file exists so it is included 
			?>
			<!-- Custom CSS via plugin -->
			<link rel="stylesheet" type="text/css" href="<?php echo $RelFilePath; ?>" />
			<?php
		}

		// Check for custom content. Link if file exists.
		// Test for id
		$FilePath = $BaseCustomDir."/custom-content/Custom-Content-".$CurID.".php";
		if(file_exists ( $FilePath))
		{
			//error_log("FilePath for content: ".$FilePath);
			add_filter('the_content', 'InsertCustomContent');	
		}

		// Test for slug
		$FilePath_Slug = $BaseCustomDir."/custom-content/".$slug.".php";
		if(file_exists ( $FilePath_Slug))
		{
			//error_log("FilePath for content: ".$FilePath);
			add_filter('the_content', 'InsertCustomContent_slug');	
		}

		// Check for custom scripts to use. Link if file exists. NOTE: this script goes into the header
		$FilePath = $BaseCustomDir."/custom-js/".$slug.".js";
		//error_log("FilePath before insert content function: ".$FilePath);
		if(file_exists ( $FilePath))
		{
			//error_log("FilePath for content: ".$FilePath);
			//add_filter('the_content', 'InsertCustomContent');	
			//add_filter('wp_footer','AddScriptToFooter');
			include($FilePath);
		}
	}
};

// Puts the contents of the associated .js file at the bottom of the document, just before the end body
function AddScriptToFooter()
{
	global $CurID;
	global $FilePath_ID;
	global $FilePath_Slug;

	$FilePath = get_stylesheet_directory_uri()."/Custom/Custom-js/custom-js-".$CurID.".js";
	//echo "here:".$FilePath."<br />";	
	$Script = file_get_contents($FilePath);
	echo $Script;
	//return $Script;
}


// Appends the contents of the 'custom content file' to the current post content 
function InsertCustomContent($content)
{
	//global $FilePath;
	//$CCFilePath = $FilePath;
	//echo "1.: ".$CCFilePath;
	global $CurID;
	$FilePath = get_stylesheet_directory_uri()."/Custom/custom-content/Custom-Content-".$CurID.".php";
	$content = $content.file_get_contents($FilePath);

    return $content;
}

function InsertCustomContent_slug($content)
{
	global $slug;
	global $FilePath_Slug;
	//$FilePath = get_stylesheet_directory_uri()."/Custom/custom-content/".$slug.".php";

	$content = $content.file_get_contents($FilePath_Slug);

    return $content;
}

