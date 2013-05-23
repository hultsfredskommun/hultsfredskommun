/**
 * @version 1.0
 * @author d33k4y
 */
	
/*********************************
 *** Configuration
 *** Made for Ruby version 1.9.3 .
 *********************************/

/**
 * This value has to be the absolute path to the ruby-bin directory, with a trailing slash!
 */
var pathToRubyBinDir = "C:\\Ruby200-x64\\bin\\";

/**
 * If anything doesn't work, you can enable the debugMode.
 * This just shows you the commandline, where scss/sass and ruby are called and you can look for any errors in this command line window.
 */
var debugMode = true;
		
/**
 * Output style is the style of the .css you get, try them to see how they look.
 * Possible styles are: "expanded", "nested", "compact" and "compressed".
 * Make sure you pick ONE OF THESE, so you don't get any errors.
 *
 * "Expanded" means normal, nicely readable.
 * "Nested" means, that sub classes are indented somehow.
 * "Compact" seemed like one class one line...
 * "Compressed" is what it sounds like, only neccessary chars in you .css file, no newlines or indentations.
 */
var outputStyle = "expanded";

/**
 * Set, if you want to skip files that start with an underscore.
 * As the SCSS specification says, those files are being included as imports.
 * The standard configuration is to skip those files.
 */
 var skipUnderscoredFiles = true;
 
/*********************************
 *** Configuration End
 *********************************/


 
/**
 * No config, but Sass-Auto-Compile functionality.
 * Don't change anything below, if you don't know what you're doing.
 */

/**
 * Set the global listener and specify the function "FILESAVED".
 */
GlobalListener.addListener({
		tryTranslations:function(){
			var view = Editor.currentView;
			var filePath = view.files[view.file];
			
			// Get the last 5 chars of filePath and check if first char is a dot, return if not
			var fileType = filePath.substr(filePath.length-5);
			if(fileType[0] != ".")
				return;
			
			// Now get only the file type without the dot
			fileType = fileType.substr(1);

			// If file type is scss or sass, call matching translator on this file
			if(fileType == "scss" || fileType == "sass")
			{
				var targetFilePath = filePath.slice(0, -4) + "css";
				this.startTranslation(fileType, filePath, targetFilePath);
			}
		},
		
		startTranslation:function(type, filePath, targetFilePath){
			// Check if filename starts with an underscore.
			// If it does and the config is set to stop, stop.
			var fileName = filePath.split("\\");
			fileName = fileName[fileName.length-1];
			if(skipUnderscoredFiles && fileName[0] == '_')
				return;
			// Check END
			
			// Get the file's directory, needed for imports in the same directory
			var fileDir = filePath.split("\\");
			fileDir[fileDir.length-1] = "";
			fileDir = fileDir.join("\\");
			// End
			
			var shell = new ActiveXObject("WScript.Shell");
		
			// Make it possible to see the command line for getting any translation-errors
			if(debugMode == false) //
				shell.run('cmd /C "cd '+pathToRubyBinDir+' && '+type+'.bat --style '+outputStyle+' --load-path \''+fileDir+'\' --trace \''+filePath+':'+targetFilePath+'\'" && exit', 0);
			else
				shell.run('cmd /K "cd '+pathToRubyBinDir+' && '+type+'.bat --style '+outputStyle+' --load-path \''+fileDir+'\' --trace \''+filePath+':'+targetFilePath+'\'" && exit');
		},
	
		FILESAVED:function(v,pos){
			this.tryTranslations();
		},	
	});