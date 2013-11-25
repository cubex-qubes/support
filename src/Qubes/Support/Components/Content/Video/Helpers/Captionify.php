<?php
/**
 * Author: oke.ugwu
 * Date: 23/08/13 15:01
 */
namespace Qubes\Support\Components\Content\Video\Helpers;

use Qubes\Support\Components\Content\Video\Mappers\VideoCaption;

class Captionify
{
  CONST API_JTALK  = 'jtalk';
  CONST API_TTSAPI = 'tts-api';

  public static function create(
    $videoId, $text, $api = Captionify::API_JTALK
  )
  {
    //this might take up to 2 mins to finish, so let make that provision
    set_time_limit(120);

    //we want to always start afresh when captionifying text
    //so delete all existing caption before we start
    $captions = VideoCaption::collection(['video_id' => $videoId]);
    foreach($captions as $caption)
    {
      $caption->delete();
    }

    $text      = str_replace('. ', "\n", $text);
    $sentences = explode("\n", $text);

    $result  = array();
    $lastEnd = 0;
    foreach($sentences as $sentence)
    {
      switch($api)
      {
        case self::API_TTSAPI:
          $caption = self::_jTalkCaptionify($sentence, $lastEnd, 0);
          break;
        case self::API_JTALK:
        default:
          $caption = self::_ttsApiCaptionify($sentence, $lastEnd, 0);
          break;
      }

      if($caption)
      {
        $lastEnd += $caption['duration'];
        $result[] = $caption;
      }
    }

    foreach($result as $captionData)
    {
      $caption              = new VideoCaption();
      $caption->videoId     = $videoId;
      $caption->startSecond = $captionData['start'];
      $caption->endSecond   = $captionData['end'];
      $caption->text        = $captionData['text'];
      $caption->saveChanges();
    }
  }

  private static function _ttsApiCaptionify($sentence, $lastEnd, $durationError)
  {
    $speechMp3 = self::_ttsApi($sentence);
    if($speechMp3)
    {
      $mp3File  = new \Mp3File($speechMp3);
      $metaData = $mp3File->get_metadata();
      unset($mp3File);

      $duration = $metaData['Length'] + $durationError;

      unlink($speechMp3);

      return array(
        'text'     => $sentence,
        'duration' => $duration,
        'start'    => $lastEnd,
        'end'      => $lastEnd + $duration
      );
    }
    else
    {
      return false;
    }
  }

  private function _jTalkCaptionify($sentence, $lastEnd, $durationError)
  {
    $metaData = self::_jtalktts($sentence);

    $KBps     = ($metaData->data->bitrate * 1000) / 8;
    $length   = $metaData->data->size / $KBps;
    $duration = (int)sprintf("%d", $length);

    $duration = $duration + $durationError;

    if($duration)
    {
      return array(
        'text'     => $metaData->data->speech,
        'duration' => $duration,
        'start'    => $lastEnd,
        'end'      => $lastEnd + $duration
      );
    }

    return false;
  }

  /**
   * Connect to jTalk apo and return speech mp3 metadata
   *
   * @param $text
   *
   * @return bool|mixed
   */
  private static function _jtalktts($text)
  {
    $text = trim($text);
    if(!empty($text))
    {
      $text    = urlencode($text);
      $mp3data = file_get_contents(
        "http://speech.jtalkplugin.com/api/?speech={$text}"
      );

      return json_decode(stripslashes($mp3data));
    }
    else
    {
      return false;
    }
  }

  /**
   * Connect to tts-api, save mp3 file and return filename
   *
   * @param $text
   *
   * @return bool|string
   */
  private static function _ttsApi($text)
  {
    $text = trim($text);
    if(!empty($text))
    {
      $speechMp3 = "tts.mp3";
      $text      = urlencode($text);
      $mp3data   = file_get_contents("http://tts-api.com/tts.mp3?q={$text}");
      file_put_contents($speechMp3, $mp3data);
      chmod($speechMp3, 0777);

      return $speechMp3;
    }
    else
    {
      return false;
    }
  }
}
