<?php

class Video_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main videos page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("video.view")){
			return Response::error('401');
		}
		return View::make('video/index')->with('videos', Video::all());
	}


	/**
	 * New videos page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("video.edit")){
			return Response::error('401');
		}
		$video = Video::find($id);
		$parent = $video->getParent();
		return View::make('video/edit')
						->with('video', $video)
						->with('parent', $parent);
	}


	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
	{
		if(!Auth::user()->has_access("video.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'title' => 'required',
			'description'  => 'required|between:5,1000',
			// 'body' => 'required|between:5,2000',
		);

		// Get all the inputs.
		//
		$inputs = Input::all();

		// Validate the inputs.
		//
		$validator = Validator::make($inputs, $rules);

		// Check if the form validates with success.
		//
		if ($validator->passes())
		{
			// Create the site
			//
			if(is_null($id)){
				$video = new Video;
			}else{
				$video =  Video::find($id);
			}
			$video->title = Input::get('title');

			$video->description = Input::get('description');
			$video->slug = Str::slug(Input::get('slug') ?:Input::get('title'));
			$video->tags = explode(',', Input::get('tags'));

			if($premiere_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('premiere_date'))){
				$video->premiere_date = new MongoDate($premiere_date->getTimestamp());
			}else{
				$video->premiere_date = '';
			}

			$video->genre = Input::get('genre');

			$video->urls = array( 
				'source' => Input::get('urls_source'),
				'streaming' => Input::get('urls_streaming'),
				'thumbnail' => Input::get('urls_thumbnail')
			);

			$availability_sunrise = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunrise'));
			$availability_sunset = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunset'));

			$video->availability = array(
				'sunrise' => $availability_sunrise ? new MongoDate($availability_sunrise->getTimestamp()) : '',
				'sunset' =>  $availability_sunset ? new MongoDate($availability_sunset->getTimestamp()) : '',
			);

			$video->parent = array(
				'id' => Input::get('parent_id'),
				'type' =>  Input::get('parent_type'),
			);

			$video->dateify() // set updated and created fields
					->save();


			// Redirect to the video page.
			//
			return Redirect::to('video')->with('success', 'Video updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('video/edit/'.$id)->with_input()->with_errors($validator);
	}

	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_upload()
	{


		/**
		 * upload.php
		 *
		 * Copyright 2009, Moxiecode Systems AB
		 * Released under GPL License.
		 *
		 * License: http://www.plupload.com/license
		 * Contributing: http://www.plupload.com/contributing
		 */

		// HTTP headers for no cache etc
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// Settings
		$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		$targetDir = '/tmp';

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Create target dir
		if (!file_exists($targetDir))
			@mkdir($targetDir);

		// Remove old temp files	
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}

			closedir($dir);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}


		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

	}
}
