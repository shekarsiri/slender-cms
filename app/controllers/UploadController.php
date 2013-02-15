<?php
//use ZendGData\ClientLogin as ClientLogin;
//use Zend\Http\Client as HttpClient;
//use Zend\Http\Request as Request;

class UploadController extends BaseController {

	public function uploadVideo()
	{
        $videoData = array(
            //path to file
            'source' => 'file.mov',
            'mime' => 'video/quicktime',
            'slug' => 'file.mov',
            'title' => 'Title',
            'description' => 'Lorem ipsum dolor..',
            //must be valid youtube video category
            'category' => 'Autos',
            // Please note that this must be a comma-separated string
            // and that individual keywords cannot contain whitespace
            'tags' => 'cars, funny',
            'developer_tags' => array('mydevtag', 'anotherdevtag') //optional
        );

		$youtubeConfig = Config::get('gdata.youtube');

        if (file_exists($videoData['source'])) {
            $service = \ZendGData\Spreadsheets::AUTH_SERVICE_NAME;
            $adapter = new \Zend\Http\Client\Adapter\Curl();
            $httpClient = new \ZendGData\HttpClient();
            $httpClient->setAdapter($adapter);
            $client =
                ZendGData\ClientLogin::getHttpClient(
                    $username = $youtubeConfig['youtube_email'],
                    $password = $youtubeConfig['youtube_pass'],
                    $service = $service,
                    $client = $httpClient,
                    $source = $youtubeConfig['api_name'],
                    $loginToken = null,
                    $loginCaptcha = null,
                    $youtubeConfig['auth_url']);

            $yt = new \ZendGData\YouTube($client, $youtubeConfig['api_name'], 'Video Upload', $youtubeConfig['api_key']);

            $myVideoEntry = new \ZendGData\YouTube\VideoEntry();

            $filesource = $yt->newMediaFileSource($videoData['source']);
            $filesource->setContentType($videoData['mime']);
            $filesource->setSlug($videoData['slug']);

            $myVideoEntry->setMediaSource($filesource);
            $myVideoEntry->setVideoTitle($videoData['title']);
            $myVideoEntry->setVideoDescription($videoData['description']);
            $myVideoEntry->setVideoCategory($videoData['category']);

            $myVideoEntry->SetVideoTags($videoData['tags']);

            if (is_array($videoData['developer_tags']) && count($videoData['developer_tags']))
                $myVideoEntry->setVideoDeveloperTags($videoData['developer_tags']);

            $newEntry = false;
            try {
                $newEntry = $yt->insertEntry($myVideoEntry, $youtubeConfig['upload_url'], '\ZendGData\YouTube\VideoEntry');
            } catch (\ZendGData\HttpException $httpException) {
                echo $httpException->getRawResponseBody();
            } catch (\ZendGData\HttpException $e) {
                echo $e->getMessage();
            }
            return $newEntry;
        }
        else {
            return false;
        }
        return false;
	}

}